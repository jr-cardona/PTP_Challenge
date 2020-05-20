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

Auth::routes(['register' => false]);

Route::middleware(['auth'])->group(static function () {
    Route::view('/', 'home')->name('home');

    // Search
    Route::get('/clientes/buscar', 'SearchController@clients')
        ->name('search.clients');
    Route::get('/productos/buscar', 'SearchController@products')
        ->name('search.products');
    Route::get('/usuarios/buscar', 'SearchController@users')
        ->name('search.users');
    Route::get('/permisos/buscar', 'SearchController@permissions')
        ->name('search.permissions');

    // Imports
    Route::post('/importar', 'ImportController@import')->name('import');

    // Exports
    Route::get('/facturas/exportar', 'ExportController@invoices')
        ->name('invoices.export');
    Route::get('/clientes/exportar', 'ExportController@clients')
        ->name('clients.export');
    Route::get('/productos/exportar', 'ExportController@products')
        ->name('products.export');
    Route::get('/usuarios/exportar', 'ExportController@users')
        ->name('users.export');

    // Invoices
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
    Route::get('/facturas/{invoice}/recibir/', 'InvoiceController@receivedCheck')
        ->name('invoices.receivedCheck');
    Route::get('/facturas/{invoice}/imprimir', 'InvoiceController@print')
        ->name('invoices.print');

    // Clients
    Route::resource('/clientes', 'ClientController')
        ->names('clients')
        ->parameters(['clientes' => 'client']);

    // Products
    Route::resource('/productos', 'ProductController')
        ->names('products')
        ->parameters(['productos' => 'product']);

    // Users
    Route::resource('/usuarios', 'UserController')
        ->names('users')
        ->parameters(['usuarios' => 'user']);

    // Password Changes
    Route::get('usuarios/{user}/edit-password/', 'UserController@editPassword')
        ->name('users.edit-password');
    Route::put('usuarios/{user}/update-password/', 'UserController@updatePassword')
        ->name('users.update-password');

    // Reports
    Route::get('/reportes', 'ReportController@general')
        ->name('reports.general');
    Route::get('/reportes/clientes-deudores', 'ReportController@debtorClients')
        ->name('reports.debtorClients');
    Route::get('/reportes/utilidades', 'ReportController@utilities')
        ->name('reports.utilities');
    Route::get('/reportes/generados', 'ReportController@generated')
        ->name('reports.generated');
    Route::get('/reportes/{report}', 'ReportController@download')
        ->name('reports.download');
    Route::delete('/reportes/{report}', 'ReportController@destroy')
        ->name('reports.destroy');

    // Notifications
    Route::get('/notificaciones', 'NotificationController@index')
        ->name('notifications.index');
    Route::put('/notificaciones/{id}', 'NotificationController@read')
        ->name('notifications.read');
    Route::delete('/notificaciones/{id}', 'NotificationController@destroy')
        ->name('notifications.destroy');
});
