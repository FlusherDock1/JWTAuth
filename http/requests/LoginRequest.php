<?php
declare(strict_types=1);
namespace ReaZzon\JWTAuth\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
        return [
            'email' => 'required|email',
            'password' => 'required',
        ];
    }
}
