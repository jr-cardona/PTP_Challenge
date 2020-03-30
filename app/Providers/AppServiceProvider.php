<?php

namespace App\Providers;

use App\Entities\Client;
use App\Entities\User;
use App\Entities\Invoice;
use App\Entities\Product;
use App\Entities\PaymentAttempt;
use App\Observers\ClientsObserver;
use App\Observers\UsersObserver;
use Dnetix\Redirection\PlacetoPay;
use App\Observers\InvoicesObserver;
use App\Observers\ProductsObserver;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use App\Observers\PaymentAttemptsObserver;

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
                'url' => config('services.placetopay.url'),
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
        PaymentAttempt::observe(PaymentAttemptsObserver::class);
        Product::observe(ProductsObserver::class);
        Invoice::observe(InvoicesObserver::class);
        Client::observe(ClientsObserver::class);
        User::observe(UsersObserver::class);

        Route::resourceVerbs([
            'create' => 'crear',
            'edit' => 'editar'
        ]);

        Blade::directive('routeIs', static function ($expression) {
            return "<?php if (Request::url() == route(${expression})): ?>";
        });
    }
}
