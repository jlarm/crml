<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

final class MigrateOldDataCommand extends Command
{
    protected $signature = 'migrate:old-data {--table=} {--from=mysql_old} {--to=mysql} {--timeout=30} {--dump-file=}';

    protected $description = 'Migrate data from old database to new schema';

    private array $mappings = [
        'users' => [
            'name' => 'name',
            'email' => 'email',
            'phone' => 'phone',
            'email_verified_at' => 'email_verified_at',
            'password' => 'password',
            'created_at' => 'created_at',
            'updated_at' => 'updated_at',
        ],
    ];

    public function handle(): void
    {
        $table = $this->option('table');
        $fromConnection = $this->option('from');
        $toConnection = $this->option('to');
        $dumpFile = $this->option('dump-file');
        $this->option('timeout');

        if (! $table) {
            $this->error('Please specify table name: --table=users');

            return;
        }

        if (! isset($this->mappings[$table])) {
            $this->error("No mapping defined for table: $table");

            return;
        }

        if ($dumpFile) {
            $this->importFromDumpFile($dumpFile, $table, $toConnection);

            return;
        }

        $this->info("Migrating table: $table from {$fromConnection} to {$toConnection}...");

        // Test connections first
        try {
            DB::connection($fromConnection)->getPdo();
            $this->info("✓ Source connection ({$fromConnection}) established");
        } catch (Exception $e) {
            $this->error("✗ Failed to connect to source database ({$fromConnection}): ".$e->getMessage());
            $this->line('');
            $this->line('Available options:');
            $this->line('1. Check if the external database server is accessible');
            $this->line('2. Use a different source connection: --from=mysql');
            $this->line('3. Import data from a SQL dump file: --dump-file=path/to/dump.sql');

            return;
        }

        try {
            DB::connection($toConnection)->getPdo();
            $this->info("✓ Target connection ({$toConnection}) established");
        } catch (Exception $e) {
            $this->error("✗ Failed to connect to target database ({$toConnection}): ".$e->getMessage());

            return;
        }

        // Get total count for progress tracking
        try {
            $totalRows = DB::connection($fromConnection)->table($table)->count();
            $this->info("Found {$totalRows} rows to migrate");
        } catch (Exception $e) {
            $this->error('Failed to query source table: '.$e->getMessage());

            return;
        }

        if ($totalRows === 0) {
            $this->info('No rows found in source table');

            return;
        }

        $count = 0;
        $chunkSize = 1000;

        // Process in chunks to avoid memory and timeout issues
        try {
            DB::connection($fromConnection)
                ->table($table)
                ->orderBy('id')
                ->chunk($chunkSize, function ($rows) use ($table, $toConnection, &$count): void {
                    $batchData = [];

                    foreach ($rows as $row) {
                        $data = [];

                        foreach ($this->mappings[$table] as $oldCol => $newCol) {
                            $value = $row->$oldCol ?? null;

                            if (is_callable($newCol)) {
                                $mapped = $newCol($value);
                                $data = [...$data, ...$mapped];
                            } elseif (is_string($newCol)) {
                                $data[$newCol] = $value;
                            }
                        }

                        $batchData[] = $data;
                    }

                    // Insert batch of records
                    DB::connection($toConnection)->table($table)->insert($batchData);

                    $count += count($batchData);
                    $this->info("Processed {$count} rows...");
                });

            $this->info("Successfully migrated {$count} rows into {$table}");
        } catch (Exception $e) {
            $this->error('Migration failed: '.$e->getMessage());
        }
    }

    private function importFromDumpFile(string $dumpFile, string $table, string $toConnection): void
    {
        if (! file_exists($dumpFile)) {
            $this->error("Dump file not found: {$dumpFile}");

            return;
        }

        $this->info("Importing {$table} from dump file: {$dumpFile}");

        // Create temporary database for importing
        $tempDb = 'temp_import_'.time();

        try {
            // Create temporary database
            DB::connection($toConnection)->statement("CREATE DATABASE IF NOT EXISTS `{$tempDb}`");

            // Import dump file into temporary database
            $config = config("database.connections.{$toConnection}");
            $host = $config['host'];
            $username = $config['username'];
            $password = $config['password'];

            $command = sprintf(
                'mysql -h %s -u %s %s %s < %s',
                escapeshellarg((string) $host),
                escapeshellarg((string) $username),
                $password ? '-p'.escapeshellarg((string) $password) : '',
                escapeshellarg($tempDb),
                escapeshellarg($dumpFile)
            );

            $this->info('Importing dump file...');
            exec($command, $output, $returnCode);

            if ($returnCode !== 0) {
                throw new Exception("Failed to import dump file. Return code: {$returnCode}");
            }

            // Migrate data from temp database to target
            $this->migrateFromTempDatabase($tempDb, $table, $toConnection);

        } catch (Exception $e) {
            $this->error('Import failed: '.$e->getMessage());
        } finally {
            // Clean up temporary database
            try {
                DB::connection($toConnection)->statement("DROP DATABASE IF EXISTS `{$tempDb}`");
            } catch (Exception $e) {
                $this->warn('Failed to clean up temporary database: '.$e->getMessage());
            }
        }
    }

    private function migrateFromTempDatabase(string $tempDb, string $table, string $toConnection): void
    {
        $count = 0;
        $chunkSize = 1000;

        // Get total rows
        $totalRows = DB::connection($toConnection)
            ->table("{$tempDb}.{$table}")
            ->count();

        $this->info("Found {$totalRows} rows in dump file");

        if ($totalRows === 0) {
            return;
        }

        // Process in chunks
        DB::connection($toConnection)
            ->table("{$tempDb}.{$table}")
            ->orderBy('id')
            ->chunk($chunkSize, function ($rows) use ($table, $toConnection, &$count): void {
                $batchData = [];

                foreach ($rows as $row) {
                    $data = [];

                    foreach ($this->mappings[$table] as $oldCol => $newCol) {
                        $value = $row->$oldCol ?? null;

                        if (is_callable($newCol)) {
                            $mapped = $newCol($value);
                            $data = [...$data, ...$mapped];
                        } elseif (is_string($newCol)) {
                            $data[$newCol] = $value;
                        }
                    }

                    $batchData[] = $data;
                }

                // Insert batch of records
                DB::connection($toConnection)->table($table)->insert($batchData);

                $count += count($batchData);
                $this->info("Processed {$count} rows...");
            });

        $this->info("Successfully migrated {$count} rows into {$table}");
    }
}
