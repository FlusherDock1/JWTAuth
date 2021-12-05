<?php
declare(strict_types=1);

namespace ReaZzon\JWTAuth\Http\Controllers;

use October\Rain\Argon\Argon;
use ReaZzon\JWTAuth\Classes\Dto\TokenDto;
use ReaZzon\JWTAuth\Http\Requests\ActivationRequest;

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
    public function __invoke(ActivationRequest $registrationRequest)
    {
        $user = $this->userPluginResolver
            ->getResolver()
            ->activateByCode($registrationRequest->validated());

        if (empty($user)) {
            throw new \ApplicationException('Activation failed');
        }

        $tokenDto = new TokenDto([
            'token' => $this->JWTGuard->login($user),
            'expires' => Argon::createFromTimestamp($this->JWTGuard->getPayload()->get('exp')),
            'user' => $user,
        ]);

        return ['data' => $tokenDto->toArray()];
    }
}
