<?php
declare(strict_types=1);
namespace ReaZzon\JWTAuth\Http\Requests;

use ReaZzon\JWTAuth\Classes\Contracts\UserPluginResolver;

/**
 *
 */
class LoginRequest extends FormRequest
{
    /**
     * @return string[]
     */
    public function rules(): array
    {
        return array_merge([
            'password' => 'required',
        ], $this->resolveLoginValidation());
    }

    /**
     * @return array
     */
    protected function resolveLoginValidation(): array
    {
        /** @var UserPluginResolver $userPluginResolver */
        $userPluginResolver = app(UserPluginResolver::class);
        return $userPluginResolver->getResolver()->loginValidationExtend();
    }
}
