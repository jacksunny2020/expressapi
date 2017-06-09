# expressapi
api for express information exchange,which may be used in laravel framework 5.4+

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

5.please notify me if you got any problem or error on it,thank you!
