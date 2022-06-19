<?php
declare(strict_types=1);

namespace ReaZzon\JWTAuth\Classes\Actions;

use October\Rain\Argon\Argon;
use ReaZzon\JWTAuth\Classes\Contracts\UserPluginResolver;
use ReaZzon\JWTAuth\Classes\Dto\TokenDto;

/**
 * Class TokenAction.
 * @package ReaZzon\JWTAuth\Classes\Actions
 */
abstract class TokenAction
{
    /**
     * @var UserPluginResolver
     */
    protected UserPluginResolver $userPluginResolver;

    /**
     * @param UserPluginResolver $userPluginResolver
     */
    public function __construct(UserPluginResolver $userPluginResolver)
    {
        $this->userPluginResolver = $userPluginResolver;
    }
}
