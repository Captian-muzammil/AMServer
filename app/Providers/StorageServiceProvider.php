<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class StorageServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind( // binding the WebGame model repositories
            'App\Libs\Platform\Storage\Order\OrderRepository',
            'App\Libs\Platform\Storage\Order\EloquentOrderRepository'
        );
    }
}
