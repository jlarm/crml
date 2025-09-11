<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

final class Dealership extends Model
{
    protected $fillable = [
        'name',
        'address',
        'city',
        'state',
        'zip_code',
        'phone',
        'email',
        'notes',
        'status',
        'rating',
        'type',
        'in_development',
        'dev_status',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];
}
