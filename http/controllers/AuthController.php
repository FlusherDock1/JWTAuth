<?php
declare(strict_types=1);

namespace ReaZzon\JWTAuth\Http\Controllers;

use October\Rain\Argon\Argon;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;
use ReaZzon\JWTAuth\Classes\Dto\TokenDto;
use ReaZzon\JWTAuth\Classes\Exceptions\Http\PasswordWrongException;
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
        /** @var JWTSubject $user */
        $user = $this->userPluginResolver
            ->getProvider()
            ->authenticate($loginRequest->validated());

        if (empty($user)) {
            throw new PasswordWrongException();
        }

        $tokenDto = new TokenDto([
            'token' => $this->userPluginResolver->getGuard()->login($user),
            'expires' => Argon::createFromTimestamp($this->userPluginResolver->getGuard()->getPayload()->get('exp')),
            'user' => $user,
        ]);

        return new TokenResource($tokenDto);
    }
}
