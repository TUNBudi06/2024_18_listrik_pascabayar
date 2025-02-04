<?php

use App\Http\Middleware\IfLoginUser;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::middleware([IfLoginUser::class])->group(function () {
    Route::view('dashboard', 'dashboard')
        ->name('dashboard');
    Route::view('electricBills', 'electricBills')->name('electricBills');
    Route::view('UsageHistory', 'usageHistory')->name('UsageHistory');
    Route::view('Payment-Management', 'makePayment')->name('make-payment');
    Route::view('PaymendAndConfirmation', 'PayAndConfirm')->name('confirm-and-pay');
});

require __DIR__.'/auth.php';
