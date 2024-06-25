<?php

use Illuminate\Support\Facades\Route;
use App\MoonShine\Controllers\UserController;
use App\MoonShine\Controllers\SettingsController;
use App\MoonShine\Controllers\FormNewUserController;

Route::post('setup/store', SettingsController::class)
    ->name('settings.store');

Route::post('/new-user/store', FormNewUserController::class)
    ->name('user.store');

Route::post('/profile', [UserController::class, 'storeProfile'])
    ->middleware(config('moonshine.auth.middleware', []))
    ->name('profile.store');

Route::post('/store', [UserController::class, 'store'])
    ->middleware(config('moonshine.auth.middleware', []))
    ->name('new.user.store');
