<?php
declare(strict_types=1);

namespace ReaZzon\JWTAuth\Http\Controllers;

use Illuminate\Http\Resources\Json\JsonResource;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;
use ReaZzon\JWTAuth\Classes\Actions\CreateToken;
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
     * @return JsonResource
     * @throws \ApplicationException
     */
    public function __invoke(LoginRequest $loginRequest, CreateToken $createTokenAction): JsonResource
    {
        /** @var JWTSubject $user */
        $user = $this->userPluginResolver
            ->getProvider()
            ->authenticate($loginRequest->validated());

        if (empty($user)) {
            throw new PasswordWrongException();
        }

        $tokenDto = $createTokenAction->handle($user);
        return new TokenResource($tokenDto);
    }
}
