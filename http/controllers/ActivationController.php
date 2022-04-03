<?php
declare(strict_types=1);

namespace ReaZzon\JWTAuth\Http\Controllers;

use October\Rain\Argon\Argon;
use ReaZzon\JWTAuth\Classes\Dto\TokenDto;
use ReaZzon\JWTAuth\Classes\Exceptions\Http\ActivationCodeIncorrectException;
use ReaZzon\JWTAuth\Http\Requests\ActivationRequest;
use ReaZzon\JWTAuth\Http\Resources\TokenResource;

/**
 *
 */
class ActivationController extends Controller
{
    /**
     * @param ActivationRequest $registrationRequest
     * @throws \ApplicationException
     * @return mixed
     */
    public function __invoke(ActivationRequest $registrationRequest): TokenResource
    {
        $user = $this->userPluginResolver
            ->getResolver()
            ->activateByCode($registrationRequest->validated());

        if (empty($user)) {
            throw new ActivationCodeIncorrectException();
        }

        $tokenDto = new TokenDto([
            'token' => $this->userPluginResolver->getGuard()->login($user),
            'expires' => Argon::createFromTimestamp($this->userPluginResolver->getGuard()->getPayload()->get('exp')),
            'user' => $user,
        ]);

        return new TokenResource($tokenDto);
    }
}
