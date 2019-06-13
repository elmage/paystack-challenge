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

Route::get('/', 'HomeController@handleRoot');

Auth::routes();


Route::group(['middleware'=>['auth']], function () {
    Route::get('/resolve/account/{account}/{bank}', 'Supplier\BankAccountController@resolveAccount');

    Route::get('/dashboard', 'HomeController@index')->name('home');
    Route::get('/suppliers', 'Supplier\SupplierController@index')->name('suppliers');
    Route::get('/suppliers/add', 'Supplier\SupplierController@create')->name('supplier.create');
    Route::get('/supplier/edit/{supplier}', 'Supplier\SupplierController@edit')->name('supplier.edit')->where('supplier', '[0-9]+');
    Route::get('/suppliers/get-suppliers', 'Supplier\SupplierController@getSuppliers');
    Route::post('/supplier/store', 'Supplier\SupplierController@store')->name('supplier.store');
    Route::put('/supplier/update', 'Supplier\SupplierController@updateSupplier')->name('supplier.update');
    Route::post('/supplier/account/add', 'Supplier\BankAccountController@create')->name('supplier.account.create');
    Route::patch('/supplier/account/make-primary', 'Supplier\BankAccountController@makePrimary')->name('supplier.account.primary');
    Route::delete('/supplier/account/delete', 'Supplier\BankAccountController@delete')->name('supplier.account.delete');

    //Transfer Route
    Route::get('/transfer/all', 'Transfer\TransferController@index')->name('transfers');
    Route::get('/transfer/single', 'Transfer\TransferController@single')->name('transfer.single');
    Route::post('/transfer/single/make', 'Transfer\TransferController@singleTransfer')->name('transfer.single.make');
    Route::get('/transfer/single/otp/{transfer}', 'Transfer\TransferController@enterOtp')->name('transfer.single.enter_otp')->where('transfer', '[0-9]+');
    Route::post('/transfer/single/otp', 'Transfer\TransferController@sendOtp')->name('transfer.single.send_otp');

    Route::get('/transfer/get/accounts/{supplier}', 'Transfer\TransferController@getAccountsForSupplier')->where('supplier', '[0-9]+');



    Route::get('/settings', 'SettingController@index')->name('settings');
    Route::patch('/settings/profile/update', 'SettingController@updateProfile')->name('profile.update');
    Route::post('/settings/profile/enable', 'SettingController@enableOtp')->name('otp.enable');
    Route::post('/settings/otp/disable', 'SettingController@disableOtp')->name('otp.disable');
    Route::post('/settings/otp/disable/finalize', 'SettingController@finalizeDisableOtp')->name('otp.disable.finalize');
});