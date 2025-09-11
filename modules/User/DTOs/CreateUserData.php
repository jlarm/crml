<?php

declare(strict_types=1);

namespace Modules\User\DTOs;

final class CreateUserData
{
    public function __construct(
        public string $name,
        public string $email,
        public ?string $password,
        public ?string $phone,
        public ?string $timezone,
        public bool $is_admin,
    ) {}

    public static function fromRequest(array $request): self
    {
        return new self(
            name: $request['name'],
            email: $request['email'],
            password: $request['password'] ?? null,
            phone: $request['phone'] ?? null,
            timezone: $request['timezone'] ?? null,
            is_admin: $request['is_admin'] ?? false,
        );
    }

    public static function withGeneratedPassword(self $userData, string $hashedPassword): self
    {
        return new self(
            name: $userData->name,
            email: $userData->email,
            password: $hashedPassword,
            phone: $userData->phone,
            timezone: $userData->timezone,
            is_admin: $userData->is_admin,
        );
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
            'password' => $this->password,
            'phone' => $this->phone,
            'timezone' => $this->timezone,
            'is_admin' => $this->is_admin,
        ];
    }
}
