<?php

declare(strict_types=1);

namespace App\Domains\User\DTOs;

final readonly class CreateUserDTO
{
    public function __construct(
        public int $id,
        public string $name,
        public string $email,
        public string $password,
        public string $phone,
    ) {}

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'password' => $this->password,
            'phone' => $this->phone,
        ];
    }
}
