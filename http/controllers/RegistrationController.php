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
     * @throws \ApplicationException
     * @return mixed
     */
    public function __invoke(RegistrationRequest $registrationRequest)
    {
        $user = $this->userPluginResolver
            ->getProvider()
            ->register($registrationRequest->validated());

        if (empty($user)) {
            throw new \ApplicationException('Registration failed');
        }

        if ($this->userPluginResolver->getResolver()->initActivation($user) !== 'on') {
            return [
                'message' => 'User created'
            ];
        }

        request()->request->add([
            'email' => $user->email,
            'password' => $registrationRequest->password
        ]);

        return app()->call(AuthController::class);
    }
}
