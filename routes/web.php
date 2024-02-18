<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\TransactionController;

Route::get('/cancel-transaction', [TransactionController::class, 'cancelTransaction'])->name('cancelTransaction');
Route::get('/success-transaction', [TransactionController::class, 'successTransaction'])->name('successTransaction');
//Route::get('reset-password', function (){})->name('password.reset');
Route::group(['middleware' => ['localization']], function () {
    Route::get('/{any}', function () {
        return view('app');
    })->where('any', '.*')->name('vueApp');
});
