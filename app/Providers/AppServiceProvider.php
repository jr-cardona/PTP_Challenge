<?php

namespace App\Providers;

use Dnetix\Redirection\PlacetoPay;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(PlacetoPay::class, static function () {
            return new PlacetoPay([
                'login' => config('services.placetopay.login'),
                'tranKey' => config('services.placetopay.trankey'),
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

        Blade::directive('routeIs', static function ($expression) {
            return "<?php if (Request::url() == route(${expression})): ?>";
        });
    }
}
