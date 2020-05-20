<?php

use Illuminate\Http\Request;

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

Route::post('/login', 'Api\AuthController@login');

Route::group(['middleware' => 'auth.jwt'], function () {
    Route::post('/logout', 'Api\AuthController@logout');
    Route::get('/me', 'Api\AuthController@me');
    Route::post('/refresh', 'Api\AuthController@refresh');

    Route::apiResource('/facturas', 'Api\InvoiceController')
        ->names('invoices')
        ->parameters(['facturas' => 'invoice']);

    Route::apiResource('/clientes', 'Api\ClientController')
        ->names('clients')
        ->parameters(['clientes' => 'client']);

    Route::apiResource('/productos', 'Api\ProductController')
        ->names('products')
        ->parameters(['productos' => 'product']);

    Route::apiResource('/usuarios', 'Api\UserController')
        ->names('users')
        ->parameters(['usuarios' => 'user']);
});
