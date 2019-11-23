<?php
Route::get('/', 'HomeController@index');

Route::get('/facturas/{invoice}/detalle', 'InvoiceController@createDetail')->name('invoices.createDetail');
Route::post('/facturas/{invoice}', 'InvoiceController@storeDetail')->name('invoices.storeDetail');
Route::get('/facturas/{invoice}/detalle/editar', 'InvoiceController@editDetail')->name('invoices.editDetail');
Route::put('/facturas/{invoice}/detalle', 'InvoiceController@updateDetail')->name('invoices.updateDetail');
Route::delete('/facturas/{invoice}/detalle/', 'InvoiceController@destroyDetail')->name('invoices.destroyDetail');

Route::resource('/facturas', 'InvoiceController')
    ->names('invoices')
    ->parameters(['facturas' => 'invoice']);

Route::resource('/clientes', 'ClientController')
    ->names('clients')
    ->parameters(['clientes' => 'client']);

Route::resource('/productos', 'ProductController')
    ->names('products')
    ->parameters(['productos' => 'product']);

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
