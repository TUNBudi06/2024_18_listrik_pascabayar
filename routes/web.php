<?php

use App\Http\Middleware\IfLoginUser;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware([IfLoginUser::class])->group(function () {
    Route::view('dashboard', 'dashboard')
        ->name('dashboard');
    Route::view('electricBills', 'electricBills')->name('electricBills');
    Route::view('UsageHistory', 'usageHistory')->name('UsageHistory');
    Route::view('Payment-Management', 'makePayment')->name('make-payment');
    Route::view('PaymendAndConfirmation', 'PayAndConfirm')->name('confirm-and-pay');
    Route::view('generate-report', 'generateReport')->name('generate-report');
    Route::view('listTariff', 'tariffPrice')->name('listTariff');
    Route::view('CustomerList', 'customerManagement')->name('customer-management');
    Route::view('Admin-Management', 'adminManagement')->name('admin-management');
});

require __DIR__.'/auth.php';
