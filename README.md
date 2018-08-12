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


## User Guide

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
    "Authorization": "jwt eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJpZCI6MSwiaWF0IjoxNTM0MDUzNzQ4fQ.Hn8ZvcJyY0nu8s2fkVeRf3TYt4Up1HtGpIqoC9gLUjs"
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


#### Exception (global for api)
you can copy below code to your Laravel app/Exceptions/handler.php render function;

it's easy to change the token exception for us;

it's easy to change the return data for api response.

of course, we should:
```
use Codeforyou\Auth\Exceptions\TokenExpireException;
use Codeforyou\Auth\Exceptions\NoAuthorizationException;
use Codeforyou\Auth\Exceptions\AuthModelException;
use Codeforyou\Jwt\JwtException;


if ($exception instanceof TokenExpireException) {
    return response()->json([
        'code' => $exception->getCode(),
        'message' => $exception->getMessage(),
        'data' => ''
    ]);
}
if ($exception instanceof NoAuthorizationException) {
    return response()->json([
        'code' => $exception->getCode(),
        'message' => $exception->getMessage(),
        'data' => ''
    ]);
}
if ($exception instanceof AuthModelException) {
    return response()->json([
        'code' => $exception->getCode(),
        'message' => $exception->getMessage(),
        'data' => ''
    ]);
}
if ($exception instanceof JwtException) {
    return response()->json([
        'code' => $exception->getCode(),
        'message' => $exception->getMessage(),
        'data' => ''
    ]);
}
```