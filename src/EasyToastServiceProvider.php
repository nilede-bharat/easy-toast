<?php


namespace Bharat\EasyToast;

use Illuminate\Support\ServiceProvider;

class EasyToastServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any package services.
     */
    public function boot()
    {


        // Publish Vue.js or JS files
        $this->publishes([
            __DIR__ . '/../resources/js' => resource_path('js/Components'),
        ], 'assets');
    }

    /**
     * Register any package services.
     */
    public function register()
    {
        // You can bind services or singletons if needed
    }
}
