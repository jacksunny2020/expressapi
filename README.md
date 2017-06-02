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
