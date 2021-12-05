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
     * @param LoginRequest $loginRequest
     * @return array
     * @throws \ApplicationException
     */
    public function __invoke(LoginRequest $loginRequest): array
    {
        $user = $this->userPluginResolver
            ->getProvider()
            ->authenticate($loginRequest->validated());

        if (empty($user)) {
            throw new \ApplicationException('Login failed');
        }

        $tokenDto = new TokenDto([
            'token' => $this->JWTGuard->login($user),
            'expires' => Argon::createFromTimestamp($this->JWTGuard->getPayload()->get('exp')),
            'user' => $user,
        ]);

        return ['data' => $tokenDto->toArray()];
    }
}
