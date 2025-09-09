<?php

declare(strict_types=1);

namespace Modules\User\Contracts;

use Illuminate\Database\Eloquent\Collection;
use Modules\User\DTOs\CreateUserData;
use Modules\User\DTOs\UpdateUserData;
use Modules\User\DTOs\UserData;
use Modules\User\Models\User;

interface UserRepositoryInterface
{
    public function create(CreateUserData $userData): User;

    public function update(User $user, UpdateUserData $userData): bool;

    public function getUserData(User $user): UserData;

    public function findById(int $id): ?User;

    public function findByEmail(string $email): ?User;

    public function delete(User $user): bool;

    public function getAll(): Collection;
}
