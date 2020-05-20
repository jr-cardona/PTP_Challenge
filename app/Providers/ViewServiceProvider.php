<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use App\Http\View\Composers\TypeDocumentComposer;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // Compose a list of Type documents
        View::composer(
            ['clients.__form', 'clients.index', 'users.__form', 'users.index'],
            TypeDocumentComposer::class
        );
    }
}
