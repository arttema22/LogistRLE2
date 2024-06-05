<?php

use App\MoonShine\Controllers\FormNewUserController;
use App\MoonShine\Controllers\SettingsController;
use Illuminate\Support\Facades\Route;

Route::post('setup/store', SettingsController::class)
    ->name('settings.store');

Route::post('/new-user/store', FormNewUserController::class)
    ->name('user.store');
