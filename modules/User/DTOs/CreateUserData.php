<?php

declare(strict_types=1);

namespace Modules\User\DTOs;

final class CreateUserData
{
    public function __construct(
        public string $name,
        public string $email,
        public ?string $password = null,
        public ?string $phone = null,
        public ?string $timezone = null,
    ) {}

    public static function fromRequest(array $request): self
    {
        return new self(
            name: $request['name'],
            email: $request['email'],
            password: $request['password'] ?? null,
            phone: $request['phone'] ?? null,
            timezone: $request['timezone'] ?? null,
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
        ];
    }
}
