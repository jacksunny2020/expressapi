# expressapi
api for express information exchange

How to install and configurate package

1. install the laravel package 
  composer require jacksunny/expressapi

2. publish view files
  php artisan vendor:publish
  
3. append new service provider file line in the section providers of file app.config
  after appended,it should looks like
   'providers' => [
        Illuminate\Auth\AuthServiceProvider::class,
        ......
        \Jacksunny\ExpressApi\ExpressApiServiceProvider::class,
    ],
4.  test if it works
  http://localhost/api/status

5. paste code below to file app/Http/Providers/AppServiceProvider.php in method "register"

         $this->app->singleton('Jacksunny\ExpressApi\OrderServiceContract', function ($app) {
             return new MockOrderService();
         });
         $this->app->singleton('Jacksunny\ExpressApi\SecurityServiceContract', function ($app) {
             return new DefaultSecurityService();
         });
         $this->app->singleton('Jacksunny\ExpressApi\LogServiceContract', function ($app) {
             return new MockLogService();
         });
         $this->app->singleton('Jacksunny\ExpressApi\ParamTransServiceContract', function ($app) {
             return new MockParamTransService();
         });
         $this->app->make('Jacksunny\ExpressApi\ApiController');

6. please notify me if you got any problem or error on it,thank you!
