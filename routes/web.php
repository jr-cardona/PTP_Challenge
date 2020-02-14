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
    Route::get('/', function() {
        return view('home');
    })->name('home');

    Route::get('/clientes/buscar', 'SearchController@clients')->name('search.clients');
    Route::get('/productos/buscar', 'SearchController@products')->name('search.products');
    Route::get('/vendedores/buscar', 'SearchController@sellers')->name('search.sellers');

    Route::get('/clientes/exportar', 'ExportController@clients')->name('export.clients');
    Route::get('/facturas/exportar', 'ExportController@invoices')->name('export.invoices');
    Route::get('/productos/exportar', 'ExportController@products')->name('export.products');
    Route::get('/vendedores/exportar', 'ExportController@sellers')->name('export.sellers');

    Route::post('/clientes/importar', 'ImportController@clients')->name('import.clients');
    Route::post('/facturas/importar', 'ImportController@invoices')->name('import.invoices');
    Route::post('/productos/importar', 'ImportController@products')->name('import.products');
    Route::post('/vendedores/importar', 'ImportController@sellers')->name('import.sellers');

    Route::resource('/facturas/{invoice}/detalle', 'InvoiceProductController')
        ->except('index', 'show')
        ->names('invoices.details')
        ->parameters(['detalle' => 'product']);

    Route::resource('/facturas/{invoice}/pagar', 'PaymentAttemptsController')
        ->only('create', 'store', 'show')
        ->names('invoices.payments')
        ->parameters(['pagar' => 'paymentAttempt']);

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

    Route::get('invoices-received-check/{invoice}', 'InvoiceController@receivedCheck')->name('invoices.receivedCheck');


});

