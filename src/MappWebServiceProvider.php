<?php

namespace mappweb\mappweb\Helpers;

use Illuminate\Support\ServiceProvider;

class MappWebServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Language
        $this->loadTranslationsFrom( __DIR__.'/Lang', 'MappWeb');

        $this->publishes([
            __DIR__.'/Lang' => base_path('resources/lang'),
        ]);

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
