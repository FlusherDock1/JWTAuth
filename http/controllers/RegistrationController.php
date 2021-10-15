<?php
declare(strict_types=1);

namespace ReaZzon\JWTAuth\Http\Controllers;

use ReaZzon\JWTAuth\Http\Requests\RegistrationRequest;
use ReaZzon\JWTAuth\Http\Resources\TokenResource;

/**
 *
 */
class RegistrationController extends Controller
{
    /**
     * @param RegistrationRequest $registrationRequest
     * @return TokenResource
     */
    public function __invoke(RegistrationRequest $registrationRequest): TokenResource
    {
        $obUser = $this->userPluginResolver
            ->getProvider()
            ->register($registrationRequest->validated());

        if ($obUser === null) {
            //... error
        }

        request()->request->add([
            'email'    => $obUser->email,
            'password' => $registrationRequest->password
        ]);
        return app()->call('ReaZzon\JWTAuth\Http\Controllers\AuthController');
    }
}
