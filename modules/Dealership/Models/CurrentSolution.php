<?php

declare(strict_types=1);

namespace Modules\Dealership\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class CurrentSolution extends Model
{
    protected $fillable = [
        'dealership_id',
        'name',
        'use',
    ];

    public function dealership(): BelongsTo
    {
        return $this->belongsTo(Dealership::class);
    }
}
