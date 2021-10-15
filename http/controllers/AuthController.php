<?php
declare(strict_types=1);

namespace ReaZzon\JWTAuth\Http\Controllers;

use October\Rain\Argon\Argon;
use ReaZzon\JWTAuth\Classes\Dto\TokenDto;
use ReaZzon\JWTAuth\Http\Requests\LoginRequest;
use ReaZzon\JWTAuth\Http\Resources\TokenResource;

/**
 *
 */
class AuthController extends Controller
{
    /**
     * @return TokenResource
     */
    public function __invoke(LoginRequest $loginRequest): TokenResource
    {
        $user = $this->userPluginResolver
            ->getProvider()
            ->authenticate($loginRequest->validated());

        $tokenDto = new TokenDto([
            'token' => $this->JWTGuard->login($user),
            'expires' => Argon::createFromTimestamp($this->JWTGuard->getPayload()->get('exp')),
            'user' => $user,
        ]);
        return new TokenResource($tokenDto);
    }
}
