<?php

declare(strict_types=1);

use Modules\User\Models\User;

uses(Modules\User\tests\UserTestCase::class, Illuminate\Foundation\Testing\RefreshDatabase::class);

test('guests are redirected to the login page', function () {
    $this->get('/users')->assertRedirect('/login');
});

test('authenticated users can visit the dashboard', function () {
    $this->actingAs($user = User::factory()->create());

    $this->get('/users')->assertStatus(200);
});

test('user index livewire component is present on page', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get('/users')
        ->assertSeeLivewire('user.index');
});

test('component renders without errors', function () {
    $user = User::factory()->create();

    Livewire::test('user.index')
        ->assertStatus(200)
        ->assertViewIs('user::livewire.index');
});

test('component has correct initial state', function () {
    Livewire::test('user.index')
        ->assertSet('sortBy', 'name')
        ->assertSet('sortDirection', 'desc');
});

test('users are displayed in the table', function () {
    $user1 = User::factory()->create(['name' => 'John Doe', 'email' => 'john@example.com']);
    $user2 = User::factory()->create(['name' => 'Jane Smith', 'email' => 'jane@example.com']);

    Livewire::test('user.index')
        ->assertSee('John Doe')
        ->assertSee('Jane Smith');
});

test('shows no users message when no users exist', function () {
    Livewire::test('user.index')
        ->assertSee('There are no users');
});

test('displays correct number of users per page', function () {
    User::factory()->count(7)->create();

    $component = Livewire::test('user.index');

    expect($component->get('users'))->toHaveCount(5);
});

test('empty timezone displays dash', function () {
    User::factory()->create(['name' => 'John Doe', 'email' => 'john@example.com', 'timezone' => null]);

    Livewire::test('user.index')
        ->assertSee('-');
});

test('component handles large datasets efficiently', function () {
    User::factory()->count(100)->create();

    $component = Livewire::test('user.index');

    expect($component->get('users'))->toHaveCount(5);
});
