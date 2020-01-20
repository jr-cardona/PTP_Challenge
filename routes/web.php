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

Auth::routes();

Route::middleware(['auth'])->group(function (){
    Route::get('/', 'HomeController@index');
    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/clientes/buscar', 'ClientController@search')->name('clients.search');
    Route::get('/vendedores/buscar', 'SellerController@search')->name('sellers.search');
    Route::get('/productos/buscar', 'ProductController@search')->name('products.search');

    Route::resource('/facturas/{invoice}/detalle', 'InvoiceProductController')
        ->except('index', 'show')
        ->names('invoiceDetails')
        ->parameters(['detalle' => 'product']);

    Route::resource('/facturas', 'InvoiceController')
        ->names('invoices')
        ->parameters(['facturas' => 'invoice']);

    Route::resource('/clientes', 'ClientController')
        ->names('clients')
        ->parameters(['clientes' => 'client']);

    Route::resource('/productos', 'ProductController')
        ->names('products')
        ->parameters(['productos' => 'product']);

    Route::resource('/vendedores', 'SellerController')
        ->names('sellers')
        ->parameters(['vendedores' => 'seller']);

    Route::get('invoices-export-excel', 'InvoiceController@exportExcel')->name('invoices.exportExcel');
    Route::post('invoices-import-excel', 'InvoiceController@importExcel')->name('invoices.importExcel');
    Route::get('invoices-received-check/{invoice}', 'InvoiceController@receivedCheck')->name('invoices.receivedCheck');

    Route::get('/facturas/pagar/{invoice}', 'PaymentAttemptsController@create')->name('invoices.payments.create');
    Route::post('/facturas/pagar/{invoice}', 'PaymentAttemptsController@store')->name('invoices.payments.store');
    Route::get('/facturas/pagar/{invoice}/{paymentAttempt}', 'PaymentAttemptsController@show')->name('invoices.payments.show');
});

