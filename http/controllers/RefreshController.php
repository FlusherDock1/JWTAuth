<?php
declare(strict_types=1);

namespace ReaZzon\JWTAuth\Http\Controllers;

use October\Rain\Argon\Argon;
use ReaZzon\JWTAuth\Classes\Dto\TokenDto;

/**
 *
 */
class RefreshController extends Controller
{
    /**
     * @return array
     */
    public function __invoke(): array
    {
        $tokenRefreshed = $this->userPluginResolver->getGuard()->refresh(true);
        $this->userPluginResolver->getGuard()->setToken($tokenRefreshed);

        $tokenDto = new TokenDto([
            'token' => $tokenRefreshed,
            'expires' => Argon::createFromTimestamp($this->userPluginResolver->getGuard()->getPayload()->get('exp')),
            'user' => $this->userPluginResolver->getGuard()->user(),
        ]);

        return new TokenResource($tokenDto);
    }
}
