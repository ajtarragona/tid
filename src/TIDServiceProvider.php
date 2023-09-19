<?php

namespace Ajtarragona\TID;

use Illuminate\Support\ServiceProvider;

class TIDServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        
        //vistas
        $this->loadViewsFrom(__DIR__.'/resources/views', 'ajtarragona-tid');
        
        //cargo rutas
        $this->loadRoutesFrom(__DIR__.'/routes.php');

        //idiomas
        $this->loadTranslationsFrom(__DIR__.'/resources/lang', 'ajtarragona-tid');

        $this->publishes([
            __DIR__.'/resources/lang' => resource_path('lang/vendor/ajtarragona-tid'),
        ], 'ajtarragona-tid-translations');


        //publico configuracion
        $config = __DIR__.'/Config/tid.php';
        
        $this->publishes([
            $config => config_path('tid.php'),
        ], 'ajtarragona-tid-config');


        $this->mergeConfigFrom($config, 'tid');


         //publico assets
        $this->publishes([
            __DIR__.'/../public' => public_path('vendor/ajtarragona'),
        ], 'ajtarragona-tid-assets');

      
        

        

       
    }
    
    
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {

        //registro middleware
        $this->app['router']->aliasMiddleware('tid', \Ajtarragona\TID\Middlewares\TIDAuth::class);
     
     
        //defino facades
        $this->app->bind('tid', function(){
            return new \Ajtarragona\TID\Services\TIDService;
        });



        //helpers
        foreach (glob(__DIR__.'/Helpers/*.php') as $filename){
            require_once($filename);
        }
    }
}
