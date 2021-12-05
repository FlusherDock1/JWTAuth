<?php
declare(strict_types=1);

namespace ReaZzon\JWTAuth\Http\Controllers;

use ReaZzon\JWTAuth\Classes\Contracts\UserPluginResolver;
use ReaZzon\JWTAuth\Classes\Guards\JWTGuard;

/**
 * Base JWTAuth Controller
 */
abstract class Controller
{
    /**
     * @var UserPluginResolver
     */
    protected UserPluginResolver $userPluginResolver;

    /**
     * @var JWTGuard
     */
    protected JWTGuard $JWTGuard;

    /**
     * @param UserPluginResolver $userPluginResolver
     */
    public function __construct(UserPluginResolver $userPluginResolver)
    {
        $this->userPluginResolver = $userPluginResolver;
        $this->JWTGuard = app('JWTGuard');
    }
}
