<?php

declare(strict_types=1);

namespace App\Domains\User\Contracts;

use App\Domains\User\DTOs\CreateUserDTO;
use App\Domains\User\DTOs\UpdateUserDTO;
use App\Domains\User\Models\User;
use Illuminate\Database\Eloquent\Collection;

interface UserRepositoryInterface
{
    public function all(): Collection;

    public function find(int $id): ?User;

    public function findOrFail(int $id): User;

    public function create(CreateUserDTO $dto): User;

    public function update(int $id, UpdateUserDTO $dto): User;

    public function delete(int $id): bool;
}
