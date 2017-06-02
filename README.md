# expressapi
api for express information exchange

How to install and configurate package
1. composer require jacksunny/expressapi

2.edit main composer file comper.json

  append a new line "Jacksunny\\ExpressApi\\": "vendor/jacksunny/expressapi/src" in "psr-4" section
  after appended,it should looks like
  "psr-4": {
            "App\\": "app/",
            "Tests\\": "tests/",
            "Jacksunny\\ExpressApi\\": "vendor/jacksunny/expressapi/src"
        }
        
3.publish view files
  php artisan vendor:publish
