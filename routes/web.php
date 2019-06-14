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

Route::get('/home', function () { return redirect('/'); });


Route::group(['middleware'=>['auth']], function () {
    Route::get('/resolve/account/{account}/{bank}', 'Supplier\BankAccountController@resolveAccount');

    Route::get('/dashboard', 'HomeController@index')->name('home');

    //Supplier Routes
    Route::get('/suppliers', 'Supplier\SupplierController@index')->name('suppliers');
    Route::get('/suppliers/add', 'Supplier\SupplierController@create')->name('supplier.create');
    Route::get('/supplier/edit/{supplier}', 'Supplier\SupplierController@edit')->name('supplier.edit')->where('supplier', '[0-9]+');
    Route::get('/suppliers/get-suppliers', 'Supplier\SupplierController@getSuppliers');
    Route::post('/supplier/store', 'Supplier\SupplierController@store')->name('supplier.store');
    Route::put('/supplier/update', 'Supplier\SupplierController@updateSupplier')->name('supplier.update');
    Route::post('/supplier/account/add', 'Supplier\BankAccountController@create')->name('supplier.account.create');
    Route::patch('/supplier/account/make-primary', 'Supplier\BankAccountController@makePrimary')->name('supplier.account.primary');
    Route::delete('/supplier/account/delete', 'Supplier\BankAccountController@delete')->name('supplier.account.delete');

    //Transfer Routes
    Route::get('/transfer/all', 'Transfer\TransferController@index')->name('transfers');
    Route::get('/transfer/single', 'Transfer\TransferController@single')->name('transfer.single');
    Route::get('/balance/topup', 'Transfer\TransferController@topup')->name('transfer.topup');
    Route::post('/balance/topup/charge', 'Transfer\TransferController@chargeTopup')->name('transfer.topup.charge');
    Route::post('/transfer/single/make', 'Transfer\TransferController@singleTransfer')->name('transfer.single.make');
    Route::get('/transfer/single/otp/{transfer}', 'Transfer\TransferController@enterOtp')->name('transfer.single.enter_otp')->where('transfer', '[0-9]+');
    Route::post('/transfer/single/otp', 'Transfer\TransferController@sendOtp')->name('transfer.single.send_otp');
    Route::post('/transfer/single/resend-otp', 'Transfer\TransferController@resendOtp')->name('transfer.single.resend_otp');
    Route::get('/transfer/get/accounts/{supplier}', 'Transfer\TransferController@getAccountsForSupplier')->where('supplier', '[0-9]+');

        //Schedule Routes
    Route::get('/transfer/schedules', 'Transfer\ScheduleController@index')->name('transfer.schedules');
    Route::post('/transfer/schedules/add', 'Transfer\ScheduleController@schedule')->name('transfer.schedule.create');
    Route::delete('/transfer/schedules/delete', 'Transfer\ScheduleController@delete')->name('transfer.schedule.delete');
    Route::patch('/transfer/schedules/toggle-status', 'Transfer\ScheduleController@toggleStatus')->name('transfer.schedule.toggle');


    //Settings Routes
    Route::get('/settings', 'SettingController@index')->name('settings');
    Route::patch('/settings/profile/update', 'SettingController@updateProfile')->name('profile.update');
    Route::patch('/settings/password/update', 'SettingController@updatePassword')->name('password.update');
    Route::post('/settings/profile/enable', 'SettingController@enableOtp')->name('otp.enable');
    Route::post('/settings/otp/disable', 'SettingController@disableOtp')->name('otp.disable');
    Route::post('/settings/otp/disable/finalize', 'SettingController@finalizeDisableOtp')->name('otp.disable.finalize');


    //Card Routes
    Route::post('/card/add/{ref}', 'Transfer\CardController@add')->name('card.add');
    Route::post('/card/remove', 'Transfer\CardController@remove')->name('card.remove');
});