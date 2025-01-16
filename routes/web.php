<?php

use App\Http\Middleware\IfLoginUser;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware([IfLoginUser::class])
    ->name('dashboard');

require __DIR__.'/auth.php';
