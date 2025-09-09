<?php

declare(strict_types=1);

namespace App\Domains\User\DTOs;

final readonly class UpdateUserDTO
{
    public function __construct(
        public string $name,
        public string $email,
        public string $password,
        public string $phone,
    ) {}

    public function toArray(): array
    {
        $data = [];

        if ($this->name !== null) {
            $data['name'] = $this->name;
        }

        if ($this->email !== null) {
            $data['email'] = $this->email;
        }

        if ($this->phone !== null) {
            $data['phone'] = $this->phone;
        }

        if ($this->password !== null) {
            $data['password'] = $this->password;
        }

        return $data;
    }
}
