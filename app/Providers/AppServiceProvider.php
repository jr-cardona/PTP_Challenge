<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Dnetix\Redirection\PlacetoPay;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(PlaceToPay::class, function () {
            return new PlaceToPay([
                'login' => env('LOGIN'),
                'tranKey' => env('TRANKEY'),
                'url' => 'https://test.placetopay.com/redirection/',
            ]);
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Route::resourceVerbs([
            'create' => 'crear',
            'edit' => 'editar'
        ]);
    }
}
