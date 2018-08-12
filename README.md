# codeforyou-laravel-jwt


## Installation


* First: Require this package with composer using the following command

> composer require codeforyou/laravel-jwt

* Second: add the service provider to the providers array in config/app.php

> Codeforyou\Auth\Providers\JwtProvider::class,

* Last: publish jwt config to laravel config path

> php artisan vendor:publish --provider="Codeforyou\Auth\Providers\JwtProvider"


## Configuration


* add the JWT middleware to the routeMiddleware array in app/Http/Kenel.php

> 'jwt' => \Codeforyou\Auth\Middleware\JWTMiddleware::class,

* JWT config in config/jwt.php 
```
<?php
/**
 * Created by PhpStorm.
 * User: gaoyang
 * Date: 2018/8/11
 * Time: 下午4:38
 */
return [
    'secret' => substr(explode(':', env('APP_KEY'))[1], 0, 32),

    'expires_in' => 7200,

    'auth' => [
        'model' => App\User::class,
        'primary_key' => 'id'
    ]
];
```


### User Guide

```
use Codeforyou\Auth\JwtAuth;
use App\User;

$user = User::find(1);

$token = JwtAuth::token($user);


```

#### http api process for laravel  

* First: http request must have header

``` 
{
    "Authorization": "jwt PIe5T3xJWAMA95Uwf7pde7gmS7ZTiURg"
}	
```

* Second: laravel route use middleware jwt 

```
Route::middleware(['jwt'])->group(function () {
    Route::get('/test2', 'TestController@test2');
});
```

* Last: other function can be used in your laravel controller

```
$payload = JwtAuth::payload();

$user = JwtAuth::user();

$id = JwtAuth::id();
```