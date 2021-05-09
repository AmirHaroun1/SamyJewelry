<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
    Route::get('/Admin/DashBoard','ApiDashBoardController@index')->name('api.DashBoard.index');
    Route::get('/AdminEmployees/main','ApiAdminEmployeesController@index')->name('api.AdminEmployees.index');
    Route::get('/AdminSearchEmployee','ApiAdminEmployeesController@search')->name('api.AdminEmployees.search');
    Route::get('/AdminEmployee/GoldWeightTransactionHistory/{employeeID}','ApiAdminEmployeesController@weight_history')->name('api.AdminEmployees.WeightHistory');
    Route::get('/AdminEmployee/GoldWeightTransactionHistory/{employeeID}/Search','ApiAdminEmployeesController@search_weight_history')->name('api.AdminEmployees.WeightHistory.search');

    Route::get('/AdminInvoices/main','ApiAdminInvoicesController@index')->name('api.AdminInvoices.index');
    Route::get('/AdminSearchInvoice','ApiAdminInvoicesController@search')->name('api.AdminInvoices.search');
    Route::get('/AdminInvoices/loadProducts/{invoice:id}','ApiAdminInvoicesController@loadProducts')->name('api.AdminInvoices.loadProducts');

    Route::get('/AdminProducts/main','ApiAdminProductsController@index')->name('api.AdminProducts.index');

    Route::get('/AdminEmployees/invoices/{employeeID}','ApiAdminEmployeesController@invoices')->name('api.AdminEmployees.invoices');

    Route::get('/AdminSuppliers/main','ApiAdminSuppliersController@index')->name('api.AdminSuppliers.index');

    Route::get('/AdminSupplies/main','ApiAdminSuppliesController@index')->name('api.AdminSupplies.index');
