<?php
/**
 * Created by PhpStorm.
 * User: gaoyang
 * Date: 2018/8/11
 * Time: 下午4:59
 */

namespace Codeforyou\Auth\Middleware;

use Closure;
use Exception;
use Illuminate\Http\Request;
use Codeforyou\Jwt\JWT;
use Codeforyou\Auth\Exceptions\NoAuthorizationException;
use Codeforyou\Auth\JwtAuth;
use Codeforyou\Auth\Exceptions\TokenExpireException;

class JwtMiddleware
{
    public function handle($request, Closure $next)
    {
        if (!$request->hasHeader('Authorization')) {
            throw new NoAuthorizationException('no authorization');
        }
        $authorization = trim($request->header('Authorization'));
        $arr = explode(' ', trim($authorization));
        if (count($arr) != 2 || $arr[0] != 'jwt') {
            throw new TokenExpireException('invalid token');
        }
        $token = trim(substr($authorization, 4, strlen($authorization)));
        JwtAuth::check($token);

        return $next($request);
    }
}