<?php

use App\Http\Middleware\IfLoginUser;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::middleware([IfLoginUser::class])->group(function () {
    Route::view('dashboard', 'dashboard')
        ->name('dashboard');
});

require __DIR__.'/auth.php';
