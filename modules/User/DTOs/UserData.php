<?php

declare(strict_types=1);

namespace Modules\User\DTOs;

use Modules\User\Models\User;

final readonly class UserData
{
    public function __construct(
        public string $name,
        public string $email,
        public string $phone,
        public string $timezone,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            name: $data['name'],
            email: $data['email'],
            phone: $data['phone'] ?? null,
            timezone: $data['timezone'] ?? null,
        );
    }

    public static function fromModel(User $user): self
    {
        return new self(
            name: $user->name,
            email: $user->email,
            phone: $user->phone,
            timezone: $user->timezone,
        );
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'timezone' => $this->timezone,
        ];
    }
}
