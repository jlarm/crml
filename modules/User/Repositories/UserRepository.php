<?php

declare(strict_types=1);

namespace Modules\User\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Modules\User\Contracts\UserRepositoryInterface;
use Modules\User\DTOs\CreateUserData;
use Modules\User\DTOs\UpdateUserData;
use Modules\User\DTOs\UserData;
use Modules\User\Models\User;

final class UserRepository implements UserRepositoryInterface
{
    public function create(CreateUserData $userData): User
    {
        return User::create($userData->toArray());
    }

    public function update(User $user, UpdateUserData $userData): bool
    {
        return $user->update($userData->toArray());
    }

    public function getUserData(User $user): UserData
    {
        return UserData::fromModel($user);
    }

    public function findById(int $id): ?User
    {
        return User::find($id);
    }

    public function findByEmail(string $email): ?User
    {
        return User::where('email', $email)->first();
    }

    public function delete(User $user): bool
    {
        return $user->delete();
    }

    public function getAll(): Collection
    {
        return User::all();
    }
}
