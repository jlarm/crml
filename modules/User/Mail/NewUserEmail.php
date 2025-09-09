<?php

declare(strict_types=1);

namespace Modules\User\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Modules\User\Models\User;

final class NewUserEmail extends Mailable
{
    public function __construct(
        public User $user,
        public string $resetPasswordUrl,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Welcome to '.config('app.name').' - Set Up Your Password',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'user::emails.welcome',
        );
    }
}
