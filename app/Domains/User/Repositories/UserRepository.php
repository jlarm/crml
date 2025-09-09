<?php

declare(strict_types=1);

namespace App\Domains\User\Repositories;

use App\Domains\User\Contracts\UserRepositoryInterface;
use App\Domains\User\DTOs\CreateUserDTO;
use App\Domains\User\DTOs\UpdateUserDTO;
use App\Domains\User\Models\User;
use Illuminate\Database\Eloquent\Collection;

final class UserRepository implements UserRepositoryInterface
{
    public function all(): Collection
    {
        return User::all();
    }

    public function find(int $id): ?User
    {
        return User::find($id);
    }

    public function findOrFail(int $id): User
    {
        return User::findOrFail($id);
    }

    public function create(CreateUserDTO $dto): User
    {
        return User::create($dto->toArray());
    }

    public function update(int $id, UpdateUserDTO $dto): User
    {
        $user = $this->findOrFail($id);
        $user->update($dto->toArray());

        return $user;
    }

    public function delete(int $id): bool
    {
        return $this->findOrFail($id)->delete();
    }
}
