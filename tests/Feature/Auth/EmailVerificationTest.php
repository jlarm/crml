<?php

declare(strict_types=1);

use App\Livewire\Auth\VerifyEmail;
use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\URL;
use Livewire\Livewire;
use Modules\User\Models\User;

uses(Illuminate\Foundation\Testing\RefreshDatabase::class);

test('email verification screen can be rendered', function () {
    $user = User::factory()->unverified()->create();

    $response = $this->actingAs($user)->get('/verify-email');

    $response->assertStatus(200);
});

test('email can be verified', function () {
    $user = User::factory()->unverified()->create();

    Event::fake();

    $verificationUrl = URL::temporarySignedRoute(
        'verification.verify',
        now()->addMinutes(60),
        ['id' => $user->id, 'hash' => sha1($user->email)]
    );

    $response = $this->actingAs($user)->get($verificationUrl);

    Event::assertDispatched(Verified::class);

    expect($user->fresh()->hasVerifiedEmail())->toBeTrue();
    $response->assertRedirect(route('dashboard', absolute: false).'?verified=1');
});

test('already verified user is redirected correctly', function () {
    $user = User::factory()->create(); // Already verified

    $verificationUrl = URL::temporarySignedRoute(
        'verification.verify',
        now()->addMinutes(60),
        ['id' => $user->id, 'hash' => sha1($user->email)]
    );

    $response = $this->actingAs($user)->get($verificationUrl);

    $response->assertRedirect(route('dashboard', absolute: false).'?verified=1');
});

test('email is not verified with invalid hash', function () {
    $user = User::factory()->unverified()->create();

    $verificationUrl = URL::temporarySignedRoute(
        'verification.verify',
        now()->addMinutes(60),
        ['id' => $user->id, 'hash' => sha1('wrong-email')]
    );

    $this->actingAs($user)->get($verificationUrl);

    expect($user->fresh()->hasVerifiedEmail())->toBeFalse();
});

test('user can resend verification email', function () {
    $user = User::factory()->unverified()->create();

    expect($user->hasVerifiedEmail())->toBeFalse();

    Notification::fake();

    $this->actingAs($user);

    Livewire::test(VerifyEmail::class)
        ->call('sendVerification');

    Notification::assertSentTo($user, Illuminate\Auth\Notifications\VerifyEmail::class);
});

test('verified user is redirected when trying to send verification', function () {
    $user = User::factory()->create(); // Already verified

    $this->actingAs($user);

    $response = Livewire::test(VerifyEmail::class)
        ->call('sendVerification');

    $response->assertRedirect(route('dashboard', absolute: false));
});

test('user can logout from verification screen', function () {
    $user = User::factory()->unverified()->create();

    $this->actingAs($user);

    $response = Livewire::test(VerifyEmail::class)
        ->call('logout');

    $response->assertRedirect('/');
    $this->assertGuest();
});
