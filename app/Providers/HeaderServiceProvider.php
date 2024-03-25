<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class HeaderServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer([
            '*',
//            'components.nav-notification-dropdowns',
        ],'App\Http\ViewComposers\HeaderComposer');
//        View::composer([
//            'components.nav-notification-dropdowns',
//        ],'App\Http\ViewComposers\HeaderComposer');
    }
}
