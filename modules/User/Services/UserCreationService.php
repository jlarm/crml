<?php

declare(strict_types=1);

namespace Modules\User\Services;

use Illuminate\Support\Str;
use Modules\User\Contracts\UserRepositoryInterface;
use Modules\User\DTOs\CreateUserData;
use Modules\User\Events\UserCreated;
use Modules\User\Models\User;

final class UserCreationService
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
    ) {}

    public function create(CreateUserData $userData): User
    {
        $generatedPassword = $this->generatedPassword();

        $userDataWithPassword = CreateUserData::withGeneratedPassword(
            $userData,
            bcrypt($generatedPassword),
        );

        $user = $this->userRepository->create($userDataWithPassword);

        event(new UserCreated($user, $generatedPassword));

        return $user;
    }

    private function generatedPassword(): string
    {
        return Str::password(12);
    }
}
