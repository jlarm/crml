<?php

declare(strict_types=1);

namespace Modules\User\DTOs;

final class UpdateUserData
{
    public function __construct(
        public ?string $name = null,
        public ?string $email = null,
        public ?string $phone = null,
        public ?string $timezone = null,
        public ?bool $is_admin = null,
    ) {}

    public static function fromRequest(array $request): self
    {
        return new self(
            name: $request['name'] ?? null,
            email: $request['email'] ?? null,
            phone: $request['phone'] ?? null,
            timezone: $request['timezone'] ?? null,
            is_admin: $request['is_admin'] ?? false,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'timezone' => $this->timezone,
            'is_admin' => $this->is_admin,
        ], fn ($value) => $value !== null);
    }
}
