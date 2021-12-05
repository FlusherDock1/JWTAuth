<?php
declare(strict_types=1);

namespace ReaZzon\JWTAuth\Classes\Dto;

use October\Rain\Argon\Argon;
use October\Rain\Auth\Models\User;

/**
 *
 */
class TokenDto
{
    /**
     * @var string
     */
    public string $token;

    /**
     * @var Argon
     */
    public Argon $expires;

    /**
     * @var User
     */
    public User $user;

    /**
     * @param $data
     */
    public function __construct($data)
    {
        foreach($data as $name => $value) {
            $this->{$name} = $value;
        }
    }

    public function toArray(): array
    {
        return [
            'token' => $this->token,
            'expires' => $this->expires,
            'user' => $this->user
        ];
    }
}
