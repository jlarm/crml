<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('current_solutions', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('dealership_id')->constrained('dealerships')->cascadeOnDelete();
            $table->string('name');
            $table->string('use');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('current_solutions');
    }
};
