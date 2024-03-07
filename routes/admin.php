<?php

use App\MoonShine\Controllers\SettingsController;
use Illuminate\Support\Facades\Route;

Route::post('setup/store', SettingsController::class)
    ->name('settings.store');
