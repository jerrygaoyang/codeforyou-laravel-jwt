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

class JWTMiddleware
{
    public function handle($request, Closure $next)
    {
        $token = JwtAuth::authorization();
        $payload = JwtAuth::check($token);
        $request->attributes->add(['jwt' => $payload]);

        return $next($request);
    }
}