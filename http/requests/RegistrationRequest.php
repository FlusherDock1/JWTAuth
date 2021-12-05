<?php
declare(strict_types=1);
namespace ReaZzon\JWTAuth\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
        return [
            'name' => 'sometimes|string',
            'email' => 'sometimes|string',
            'last_name' => 'sometimes|string',
            'middle_name' => 'sometimes|string',
            'phone' => 'sometimes|string',
            'password' => 'sometimes|confirmed',
            'password_confirmation' => 'required_with:password',
        ];
    }
}
