<?php

declare(strict_types=1);

namespace Modules\User\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;
use Modules\User\DTOs\CreateUserData;
use Modules\User\Services\UserCreationService;

final class UserCreateForm extends Form
{
    #[Validate('required', 'string', 'max:255')]
    public string $name = '';

    #[Validate('required', 'email', 'unique:users,email')]
    public string $email = '';

    #[Validate('nullable', 'string', 'max:255')]
    public ?string $phone = null;

    #[Validate('required', 'string', 'max:255')]
    public string $timezone = '';

    public function store(UserCreationService $userCreationService): void
    {
        $this->validate();

        $userData = CreateUserData::fromRequest([
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'timezone' => $this->timezone,
        ]);

        $user = $userCreationService->create($userData);

        $this->reset();
    }
}
