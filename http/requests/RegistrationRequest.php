<?php
declare(strict_types=1);
namespace ReaZzon\JWTAuth\Http\Requests;


use ReaZzon\JWTAuth\Classes\Contracts\UserPluginResolver;

/**
 *
 */
class RegistrationRequest extends FormRequest
{
    /**
     * @return string[]
     */
    public function rules(): array
    {
        return array_merge([
            'name' => 'sometimes|string',
            'email' => 'sometimes|string',
            'password' => 'sometimes|confirmed',
            'password_confirmation' => 'required_with:password',
        ], $this->resolveLoginValidation());
    }

    /**
     * @return array
     */
    protected function resolveRegistrationValidation(): array
    {
        /** @var UserPluginResolver $userPluginResolver */
        $userPluginResolver = app(UserPluginResolver::class);
        return $userPluginResolver->getResolver()->registrationValidationExtend();
    }
}
