<?php

declare(strict_types=1);

namespace App\Livewire\Settings;

use DateTimeZone;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Modules\User\Models\User;

final class Profile extends Component
{
    public string $name = '';

    public string $email = '';

    public string $phone = '';

    public string $timezone = '';

    /**
     * Mount the component.
     */
    public function mount(): void
    {
        $user = Auth::user();
        $this->name = $user->name ?? '';
        $this->email = $user->email ?? '';
        $this->phone = $user->phone ?? '';
        $this->timezone = $user->timezone ?? '';
    }

    /**
     * Update the profile information for the currently authenticated user.
     */
    public function updateProfileInformation(): void
    {
        $user = Auth::user();

        /** @var array{name: string, email: string} $validated */
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],

            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($user?->id),
            ],

            'phone' => ['nullable', 'string', 'max:255'],

            'timezone' => ['nullable', 'string', 'max:255'],
        ]);

        $user?->fill($validated);

        if ($user?->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user?->save();

        $this->dispatch('profile-updated', name: $user->name ?? '');
    }

    /**
     * Send an email verification notification to the current user.
     */
    public function resendVerificationNotification(): void
    {
        $user = Auth::user();

        if ($user?->hasVerifiedEmail()) {
            $this->redirectIntended(default: route('dashboard', absolute: false));

            return;
        }

        $user?->sendEmailVerificationNotification();

        Session::flash('status', 'verification-link-sent');
    }

    /**
     * @return array<int, string>
     */
    #[Computed]
    public function timezones(): array
    {
        return DateTimeZone::listIdentifiers(
            timezoneGroup: DateTimeZone::PER_COUNTRY,
            countryCode: 'US',
        );
    }
}
