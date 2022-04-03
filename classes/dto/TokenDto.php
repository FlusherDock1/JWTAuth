<?php
declare(strict_types=1);

namespace ReaZzon\JWTAuth\Classes\Dto;

use October\Rain\Argon\Argon;
use October\Rain\Auth\Models\User;
use Spatie\DataTransferObject\DataTransferObject;

/**
 *
 */
final class TokenDto extends DataTransferObject
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
}
