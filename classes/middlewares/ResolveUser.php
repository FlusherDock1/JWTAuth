<?php namespace ReaZzon\JWTAuth\Classes\Middlewares;

use Kharanenka\Helper\Result;
use ReaZzon\JWTAuth\Classes\Guards\JWTGuard;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\UserNotDefinedException;
use Tymon\JWTAuth\Exceptions\TokenBlacklistedException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;

/**
 * Class ResolveUser
 * @package ReaZzon\JWTAuth\Classes\Middlewares
 */
class ResolveUser
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, \Closure $next)
    {
        try {
            /** @var JWTGuard $obJWTGuard */
            $obJWTGuard = app('JWTGuard');

            if (!$obJWTGuard->hasToken()) {
                abort('406', 'Token not provided');
            }

            $obJWTGuard->userOrFail();

            return $next($request);
        } catch (TokenExpiredException|UserNotDefinedException $e) {
            abort(406, 'Token is expired');
        } catch (TokenBlacklistedException $e) {
            abort(406, 'Token is blacklisted');
        } catch (JWTException $e) {
            abort(406, 'Token not found in request');
        }
    }
}
