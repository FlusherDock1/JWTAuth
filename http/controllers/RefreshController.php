<?php
declare(strict_types=1);

namespace ReaZzon\JWTAuth\Http\Controllers;

use October\Rain\Argon\Argon;
use ReaZzon\JWTAuth\Classes\Dto\TokenDto;
use ReaZzon\JWTAuth\Http\Resources\TokenResource;

/**
 *
 */
class RefreshController extends Controller
{
    /**
     * @return mixed
     */
    public function __invoke(): TokenResource
    {
        $tokenRefreshed = $this->JWTGuard->refresh(true);
        $this->JWTGuard->setToken($tokenRefreshed);

        $tokenDto = new TokenDto([
            'token' => $tokenRefreshed,
            'expires' => Argon::createFromTimestamp($this->JWTGuard->getPayload()->get('exp')),
            'user' => $this->JWTGuard->user(),
        ]);
        return new TokenResource($tokenDto);
    }
}
