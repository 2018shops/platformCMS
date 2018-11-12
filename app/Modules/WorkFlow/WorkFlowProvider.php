<?php
/**
 * Created by PhpStorm.
 * User: wangjh
 * Date: 2018/5/5
 * Time: 13:51
 */
namespace App\Modules\WorkFlow;

use Illuminate\Support\ServiceProvider;

class WorkFlowProvider extends ServiceProvider {

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerRoutes();
        app()->singleton('app-workflow', function () {
            return app()->make('App\Modules\WorkFlow\WorkFlowModule');
        });
    }

    public function registerRoutes()
    {
        $routes =  __DIR__.'/routes.php' ;
        require $routes;
    }

}