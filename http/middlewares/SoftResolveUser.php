<?php
declare(strict_types=1);
namespace ReaZzon\JWTAuth\Http\Middlewares;

use ReaZzon\JWTAuth\Classes\Guards\JWTGuard;
use PHPOpenSourceSaver\JWTAuth\Exceptions\JWTException;
use PHPOpenSourceSaver\JWTAuth\Exceptions\UserNotDefinedException;
use PHPOpenSourceSaver\JWTAuth\Exceptions\TokenBlacklistedException;
use PHPOpenSourceSaver\JWTAuth\Exceptions\TokenExpiredException;

/**
 * Class SoftResolveUser
 * @package ReaZzon\JWTAuth\Http\Middlewares
 */
class SoftResolveUser
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($obRequest, \Closure $next)
    {
        try {
            /** @var \BizMark\Gateway\JWT\JWTGuard $obJWTGuard */
            $obJWTGuard = app('JWTGuard');
            $obJWTGuard->user();
        } catch (\Exception $ex) {}

        return $next($obRequest);
    }
}
