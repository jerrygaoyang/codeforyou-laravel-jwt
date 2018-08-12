<?php
/**
 * Created by PhpStorm.
 * User: gaoyang
 * Date: 2018/8/11
 * Time: 下午5:32
 */

namespace Codeforyou\Auth\Providers;

use Illuminate\Support\ServiceProvider;

class JwtProvider extends ServiceProvider
{
    public function boot()
    {
        if (!file_exists(config_path('jwt.php'))) {
            $this->publishes([
                __DIR__ . '/../Config/jwt.php' => config_path('jwt.php')
            ]);
        }
    }
}