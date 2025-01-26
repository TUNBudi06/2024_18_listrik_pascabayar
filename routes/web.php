<?php

use App\Http\Middleware\IfLoginUser;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::middleware([IfLoginUser::class])->group(function () {
    Route::view('dashboard', 'dashboard')
        ->name('dashboard');
    Route::view('electricBills', 'electricBills')->name('electricBills');
    Route::view('UsageHistory', 'usageHistory')->name('UsageHistory');
});

require __DIR__.'/auth.php';
