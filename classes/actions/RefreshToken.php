<?php
declare(strict_types=1);

namespace ReaZzon\JWTAuth\Classes\Actions;

use ReaZzon\JWTAuth\Classes\Dto\TokenDto;

/**
 * Class RefreshToken.
 * @package ReaZzon\JWTAuth\Classes\Actions
 */
class RefreshToken extends TokenAction
{
    /**
     * @param string $token
     * @return TokenDto
     */
    public function handle(): TokenDto
    {
        $tokenRefreshed = $this->userPluginResolver->getGuard()->refresh(true);
        $this->userPluginResolver->getGuard()->setToken($tokenRefreshed);

        return TokenDto::createByJWTGuard($this->userPluginResolver->getGuard());
    }
}
