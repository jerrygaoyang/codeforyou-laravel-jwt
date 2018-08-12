<?php
/**
 * Created by PhpStorm.
 * User: gaoyang
 * Date: 2018/8/11
 * Time: 下午5:41
 */

namespace Codeforyou\Auth;

use App\User;
use Codeforyou\Jwt\JWT;
use Codeforyou\Auth\Exceptions\TokenExpireException;
use Codeforyou\Auth\Exceptions\NoAuthorizationException;
use Codeforyou\Auth\Exceptions\AuthModelException;
use Illuminate\Support\Facades\DB;

class JwtAuth
{
    public static function get_user_model()
    {
        return factory(config('jwt.auth.model'))->make();
    }

    public static function token($user, array $payload = [])
    {
        $user_model = self::get_user_model();
        if (!$user instanceof $user_model) {
            throw new AuthModelException('invalid auth model instance');
        }
        $id = $user->toArray()[config('jwt.auth.primary_key')];
        $data = array_merge($payload, ['id' => $id, 'iat' => time()]);
        return JWT::encode($data, config('jwt.secret'));
    }

    public static function check(string $token)
    {
        $payload = JWT::decode($token, config('jwt.secret'));
        $payload_iat = $payload['iat'];
        if ($payload_iat + config('jwt.expires_in') < time()) {
            throw new TokenExpireException('token expired');
        }
        return $payload;
    }

    public static function authorization()
    {
        if (!$request->hasHeader('Authorization')) {
            throw new NoAuthorizationException('no authorization');
        }
        $authorization = trim($request->header('Authorization'));
        $token = trim(substr($authorization, 4, strlen($authorization)));
        return $token;
    }

    public static function user()
    {
        $token = self::authorization();
        $payload = JWT::decode($token, config('jwt.secret'));
        $user_model = self::get_user_model();
        $user = $user_model->find($payload['id']);
        return $user;
    }

    public static function id()
    {
        $token = self::authorization();
        $payload = JWT::decode($token, config('jwt.secret'));
        return $payload['id'];
    }

}