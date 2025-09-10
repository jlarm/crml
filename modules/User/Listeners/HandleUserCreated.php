<?php

declare(strict_types=1);

namespace Modules\User\Listeners;

use Illuminate\Auth\Passwords\PasswordBrokerManager;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Modules\User\Events\UserCreated;
use Modules\User\Mail\NewUserEmail;

final class HandleUserCreated
{
    public function __construct(
        private readonly PasswordBrokerManager $passwordBrokerManager
    ) {}

    public function handle(UserCreated $event): void
    {
        Log::info('New user created', [
            'user_id' => $event->user->id,
            'email' => $event->user->email,
        ]);

        // Generate password reset token
        $token = $this->passwordBrokerManager->broker()->createToken($event->user);

        // Create reset password URL
        $resetPasswordUrl = url(route('password.reset', [
            'token' => $token,
            'email' => $event->user->email,
        ]));

        // Send welcome email with password reset link
        Mail::to($event->user->email)->send(
            new NewUserEmail($event->user, $resetPasswordUrl)
        );
    }
}
