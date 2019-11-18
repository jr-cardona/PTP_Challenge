<?php
Route::get('/', 'HomeController@index');

Route::resource('/facturas', 'InvoiceController')
    ->names('invoices')
    ->parameters(['facturas' => 'invoice']);

Route::resource('/clientes', 'ClientController')
    ->names('clients')
    ->parameters(['clientes' => 'client']);

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
