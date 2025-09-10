<?php

declare(strict_types=1);

namespace Modules\User\Events;

use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Modules\User\Models\User;

final class UserCreated
{
    use Dispatchable, SerializesModels;

    public function __construct(
        public User $user,
    ) {}
}
