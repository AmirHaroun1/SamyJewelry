<?php

use Illuminate\Support\Facades\Route;

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



Auth::routes();
Route::group(['middleware' => 'auth'], function (){
    Route::get('/','HomeController@index');
    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/AdminEmployees/main','AdminEmployeesController@index')->name('AdminEmployees.index');
    Route::patch('/AdminEmployees/update/{employee:id}','AdminEmployeesController@update')->name('AdminEmployees.update');
    Route::get('/AdminEmployees/create','AdminEmployeesController@create')->name('AdminEmployees.create');
    Route::post('/StoreNewEmployee','AdminEmployeesController@store')->name('AdminEmployees.store');
    Route::get('/AdminEmployees/edit/{employee:id}','AdminEmployeesController@edit')->name('AdminEmployees.edit');

    Route::get('/AdminInvoices/main','AdminInvoicesController@index')->name('AdminInvoices.index');
    Route::get('/AdminInvoices/create','AdminInvoicesController@create')->name('AdminInvoices.create');
    Route::patch('/AdminInvoices/update/{invoice:id}','AdminInvoicesController@update')->name('AdminInvoices.update');
    Route::post('/storeNewInvoice','AdminInvoicesController@store')->name('AdminInvoices.store');
    Route::get('/AdminInvoices/edit/{invoice:id}','AdminInvoicesController@edit')->name('AdminInvoices.edit');
    Route::delete('/AdminInvoices/DeleteProduct','AdminInvoicesController@deleteProductFromInvoice')->name('AdminInvoices.DeleteProduct');
    Route::post('/AdminInvoices/AddProduct','AdminInvoicesController@AddProductToInvoice')->name('AdminInvoices.AddProduct');
    Route::delete('/AdminInvoices/Delete/{invoice:id}','AdminInvoicesController@destroy')->name('AdminInvoices.delete');

    Route::post('/StoreNewProduct','AdminProductsController@store')->name('AdminProducts.store');
    Route::delete('/DeleteExistingProduct/{product:id}','AdminProductsController@destroy')->name('AdminProducts.destroy');

    Route::get('/AdminSuppliers/main','AdminSuppliersController@index')->name('AdminSuppliers.index');
    Route::get('/AdminSuppliers/create','AdminSuppliersController@create')->name('AdminSuppliers.create');
    Route::get('/AdminSuppliers/edit/{supplier:id}','AdminSuppliersController@edit')->name('AdminSuppliers.edit');
    Route::post('/AdminSuppliers/store','AdminSuppliersController@store')->name('AdminSuppliers.store');
    Route::patch('/AdminSuppliers/update/{supplier:id}','AdminSuppliersController@update')->name('AdminSuppliers.update');

    Route::get('/AdminSupplies/createSupply/ForSupplier/{supplier:id}','AdminSuppliesController@create')->name('AdminSupplies.create');
    Route::post('/AdminSupplies/StoreSupply','AdminSuppliesController@store')->name('AdminSupplies.store');
    Route::get('/AdminSupplies/edit/{supplyID}','AdminSuppliesController@edit')->name('AdminSupplies.edit');
    Route::patch('/AdminSupplies/update/{supplyID}','AdminSuppliesController@update')->name('AdminSupplies.update');

    Route::post('/AdminPayment/storePayment','AdminPaymentsController@store')->name('AdminPayments.store');
    Route::delete('/AdminPayment/Delete/{payment:id}','AdminPaymentsController@destroy')->name('AdminPayments.delete');

    Route::get('/DownloadSalesReportFor/{employeeID}/{employeeName}','AdminEmployeesController@ExportSalesExcel')->name('AdminEmployee.salesReport');
});


