<?php

declare(strict_types=1);

namespace Modules\User\Livewire;

use DateTimeZone;
use Illuminate\View\View;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Modules\User\Forms\UserCreateForm;
use Modules\User\Services\UserCreationService;

final class Create extends Component
{
    public UserCreateForm $form;

    public function create(UserCreationService $userCreationService): void
    {
        $this->form->store($userCreationService);
    }

    #[Computed]
    public function timezones(): array
    {
        return DateTimeZone::listIdentifiers(
            timezoneGroup: DateTimeZone::PER_COUNTRY,
            countryCode: 'US',
        );
    }

    public function render(): View
    {
        return view('user::livewire.create');
    }
}
