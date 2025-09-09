<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {
    Route::view('users', 'user::index')->name('user.index');
    Route::view('users/create', 'user::create')->name('user.create');
});
