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

Route::prefix('account')->middleware('auth')->group(function() {
    Route::get('/', 'AccountController@index')->name('chart.index');
    Route::get('/create', 'AccountController@create')->name('account.create');
    Route::get('/{chart}/details', 'AccountController@show')->name('chart.show');
    Route::post('store', 'AccountController@store')->name('chart.store');

    //accounts


    Route::get('/{chart}/details/{account}', 'AccountController@showAccount')->name('chart.account.show');
    Route::patch('/{chart}/update/{account}', 'AccountController@updateAccount')->name('chart.account.update');


    // journals


    Route::get('/journals/','JournalController@index')->name('chart.journal');
    Route::get('/journals/create','JournalController@create')->name('chart.journal.create');
    Route::post('/journals/store','JournalController@store')->name('chart.journal.store');
    Route::get('/journals/{account}','JournalController@show')->name('chart.journal.show');
});
