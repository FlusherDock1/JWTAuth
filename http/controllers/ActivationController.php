<?php
declare(strict_types=1);

namespace ReaZzon\JWTAuth\Http\Controllers;

use Illuminate\Http\Resources\Json\JsonResource;
use ReaZzon\JWTAuth\Classes\Actions\CreateToken;
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
     * @return JsonResource
     */
    public function __invoke(ActivationRequest $registrationRequest, CreateToken $createTokenAction): JsonResource
    {
        $user = $this->userPluginResolver
            ->getResolver()
            ->activateByCode($registrationRequest->validated());

        if (empty($user)) {
            throw new ActivationCodeIncorrectException();
        }

        $tokenDto = $createTokenAction->handle($user);
        return new TokenResource($tokenDto);
    }
}
