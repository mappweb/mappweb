<?php

namespace Mappweb\Mappweb;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Response;
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
        //loads
        $this->loadTranslationsFrom( __DIR__.'/Resources/lang', 'MappWeb');

        //publish
        $this->publish();

        //boots
        $this->bootCrudAjaxMacroRespose();
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerAuditableMacroBlueprint();
    }

    protected function publish()
    {
        $this->publishes([
            __DIR__ .'/Resources/lang' => base_path('resources/lang')
        ], $this->_packageTag .'-langs');

        $this->publishes([
            __DIR__ .'/Resources/js' => base_path('resources/js')
        ],$this->_packageTag .'-js');

        $this->publishes([
            __DIR__ .'/Resources/lang' => base_path('resources/lang'),
            __DIR__ .'/Resources/js' => base_path('resources/js')
        ], $this->_packageTag);
    }

    protected function registerAuditableMacroBlueprint()
    {
        Blueprint::macro('auditable', function (){
            $this->uuid('created_by')->nullable()->index();
            $this->uuid('updated_by')->nullable()->index();
        });

        Blueprint::macro('dropAuditable', function (){
            $this->dropColumn(['created_by', 'updated_by']);
        });
    }

    protected function bootCrudAjaxMacroRespose()
    {
        Response::macro('crud', function ($object){
            return Response::json($object);
        });
    }
}
