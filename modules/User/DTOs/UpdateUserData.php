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
    ) {}

    public static function fromRequest(array $request): self
    {
        return new self(
            name: $request['name'] ?? null,
            email: $request['email'] ?? null,
            phone: $request['phone'] ?? null,
            timezone: $request['timezone'] ?? null,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'timezone' => $this->timezone,
        ], fn ($value) => $value !== null);
    }
}
