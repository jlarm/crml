<?php

declare(strict_types=1);

namespace Modules\User\tests;

use Modules\User\Models\User;
use Tests\TestCase;

abstract class UserTestCase extends TestCase
{
    protected function createUser(array $attributes = []): User
    {
        return User::factory()->create($attributes);
    }
}
