<?php

namespace Jacksunny\ExpressApi;

use Illuminate\Support\ServiceProvider;

class ExpressApiServiceProvider extends ServiceProvider {

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot() {
        //view name from package name is expressapi
        $this->loadViewsFrom(__DIR__ . '/views', 'expressapi');
        $this->publishes([
            __DIR__ . '/views' => base_path('resources/views/jacksunny/expressapi'),
        ]);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register() {
        include __DIR__ . '/routes.php';
        
        //因为ApiController依赖于 SecurityServiceContract 和 OrderServiceContract 所以他们必须放在Controller之前初始化
        $this->app->singleton('Jacksunny\ExpressApi\OrderServiceContract', function ($app) {
            return new MockOrderService();
        });
        $this->app->singleton('Jacksunny\ExpressApi\SecurityServiceContract', function ($app) {
            return new DefaultSecurityService();
        });
        $this->app->singleton('Jacksunny\ExpressApi\LogServiceContract', function ($app) {
            return new MockLogService();
        });
        //因为ApiController依赖于 SecurityServiceContract 和 OrderServiceContract 所以必须放在他们之后初始化
        $this->app->make('Jacksunny\ExpressApi\ApiController');
        
    }

}
