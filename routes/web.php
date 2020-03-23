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

Route::middleware(['auth'])->group(static function () {
    Route::get('/', static function () {
        return view('home');
    })->name('home');

    Route::get('/clientes/buscar', 'SearchController@clients')
        ->name('search.clients');

    Route::get('/productos/buscar', 'SearchController@products')
        ->name('search.products');

    Route::get('/usuarios/buscar', 'SearchController@creators')
        ->name('search.creators');

    Route::get('/permisos/buscar', 'SearchController@permissions')
        ->name('search.permissions');

    // Imports
    Route::post('/importar', 'ImportController@import')->name('import');

    Route::resource('/facturas/{invoice}/producto', 'InvoiceProductController')
        ->except('index', 'show')
        ->names('invoices.products')
        ->parameters(['producto' => 'product']);

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

    Route::resource('/usuarios', 'UserController')
        ->names('users')
        ->parameters(['usuarios' => 'user']);

    Route::get('/facturas/received-check/{invoice}', 'InvoiceController@receivedCheck')
        ->name('invoices.receivedCheck');

    Route::group(['middleware' => ['role_or_permission:Admin|View any reports']], function () {
        Route::get('/reportes', 'ReportController@index')
            ->name('reports.index');
        Route::get('/reportes/clientes', 'ReportController@clients')
            ->name('reports.clients');
        Route::get('/reportes/utilidades', 'ReportController@utilities')
            ->name('reports.utilities');
    });
});
