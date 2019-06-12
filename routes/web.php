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


Route::get('/resolve/account/{account}/{bank}', 'Supplier\BankAccountController@resolveAccount');

Route::get('/dashboard', 'HomeController@index')->name('home');
Route::get('/suppliers', 'Supplier\SupplierController@index')->name('suppliers');
Route::get('/suppliers/add', 'Supplier\SupplierController@create')->name('supplier.create');
Route::get('/supplier/edit/{supplier}', 'Supplier\SupplierController@edit')->name('supplier.edit');
Route::get('/suppliers/get-suppliers', 'Supplier\SupplierController@getSuppliers');
Route::post('/supplier/store', 'Supplier\SupplierController@store')->name('supplier.store');
Route::put('/supplier/update', 'Supplier\SupplierController@updateSupplier')->name('supplier.update');
Route::post('/supplier/account/add', 'Supplier\BankAccountController@create')->name('supplier.account.create');
Route::patch('/supplier/account/make-primary', 'Supplier\BankAccountController@makePrimary')->name('supplier.account.primary');
Route::delete('/supplier/account/delete', 'Supplier\BankAccountController@delete')->name('supplier.account.delete');

//Transfer Route
Route::get('/transfer/all', 'Transfer\TransferController@index')->name('transfer');
//Route::get('/transfer', 'Transfer\TransferController@index')->name('transfer');