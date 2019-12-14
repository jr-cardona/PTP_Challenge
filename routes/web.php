<?php
Route::get('/', 'HomeController@index');

Auth::routes();

Route::middleware(['auth'])->group(function (){
    Route::get('/home', 'HomeController@index')->name('home');

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

    Route::resource('vendedores', 'SellerController')
        ->names('sellers')
        ->parameters(['vendedores' => 'seller']);

    Route::get('invoices-export-excel', 'InvoiceController@exportExcel')->name('invoices.exportExcel');
    Route::post('invoices-import-excel', 'InvoiceController@importExcel')->name('invoices.importExcel');
    Route::post('/autocomplete/search', 'AutocompleteController@search')->name('autocomplete.search');
});



