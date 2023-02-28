<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::prefix('rent-transaction')
    ->middleware('auth')
    ->group(function() {
    Route::get('/{landlord}', 'RentTransactionController@index')->name('rent_transaction');
    Route::post('store/{landlord}', 'RentTransactionController@store')->name('rent_transaction_store');
});
