<?php

declare(strict_types=1);

use App\Domains\User\Models\User;
use App\Livewire\Auth\Login;
use Livewire\Livewire;

uses(Illuminate\Foundation\Testing\RefreshDatabase::class);

test('login screen can be rendered', function () {
    $response = $this->get('/login');

    $response->assertStatus(200);
});

test('users can authenticate using the login screen', function () {
    $user = User::factory()->create();

    $response = Livewire::test(Login::class)
        ->set('email', $user->email)
        ->set('password', 'password')
        ->call('login');

    $response
        ->assertHasNoErrors()
        ->assertRedirect(route('dashboard', absolute: false));

    $this->assertAuthenticated();
});

test('users can not authenticate with invalid password', function () {
    $user = User::factory()->create();

    $response = Livewire::test(Login::class)
        ->set('email', $user->email)
        ->set('password', 'wrong-password')
        ->call('login');

    $response->assertHasErrors('email');

    $this->assertGuest();
});

test('users can logout', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->post('/logout');

    $response->assertRedirect('/');

    $this->assertGuest();
});

test('users can authenticate with remember me', function () {
    $user = User::factory()->create();

    $response = Livewire::test(Login::class)
        ->set('email', $user->email)
        ->set('password', 'password')
        ->set('remember', true)
        ->call('login');

    $response
        ->assertHasNoErrors()
        ->assertRedirect(route('dashboard', absolute: false));

    $this->assertAuthenticated();
});

test('login is rate limited after multiple failed attempts', function () {
    $user = User::factory()->create();

    // Make 5 failed attempts to trigger rate limiting
    for ($i = 0; $i < 5; $i++) {
        Livewire::test(Login::class)
            ->set('email', $user->email)
            ->set('password', 'wrong-password')
            ->call('login');
    }

    // The 6th attempt should be rate limited
    $response = Livewire::test(Login::class)
        ->set('email', $user->email)
        ->set('password', 'password')
        ->call('login');

    $response->assertHasErrors('email');
    expect($response->errors()->get('email')[0])->toContain('Too many login attempts');
});

test('validation errors are shown for empty fields', function () {
    $response = Livewire::test(Login::class)
        ->set('email', '')
        ->set('password', '')
        ->call('login');

    $response->assertHasErrors(['email', 'password']);
});

test('validation errors are shown for invalid email format', function () {
    $response = Livewire::test(Login::class)
        ->set('email', 'invalid-email')
        ->set('password', 'password')
        ->call('login');

    $response->assertHasErrors('email');
});
