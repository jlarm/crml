### Import old data
`php artisan migrate:old-data --table=users --dump-file=database/seeders/data/users.sql`

### Get current users timezone
`now()->inApplicationTimezone()->subWeek()`

The `inApplicationTimezone()` method is what is used to get the current users timezone.
