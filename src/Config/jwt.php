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