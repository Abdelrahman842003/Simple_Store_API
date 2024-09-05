<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepostoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('App\Http\Interfaces\AuthInterface',
            'App\Http\Repository\AuthRepository');


        $this->app->bind('App\Http\Interfaces\ProductsInterface',
            'App\Http\Repository\ProductsRepository');


        $this->app->bind('App\Http\Interfaces\CartInterface',
            'App\Http\Repository\CartRepository');


        $this->app->bind('App\Http\Interfaces\OrdersInterface',
            'App\Http\Repository\OrdersRepository');
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
