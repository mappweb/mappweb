<?php

namespace mappweb\mappweb;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\ServiceProvider;

class MappWebServiceProvider extends ServiceProvider
{

    private $_packageTag = 'mappweb';

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $publishTag = $this->_packageTag;

        // Language
        $this->loadTranslationsFrom( __DIR__.'/Lang', 'MappWeb');

        $this->publishes([
            __DIR__.'/Lang' => base_path('resources/lang'),
        ], $publishTag.'-langs');

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Blueprint::macro('auditable', function (){
            $this->uuid('created_by')->nullable()->index();
            $this->uuid('updated_by')->nullable()->index();
        });

        Blueprint::macro('dropAuditable', function (){
            $this->dropColumn(['created_by', 'updated_by']);
        });
    }
}
