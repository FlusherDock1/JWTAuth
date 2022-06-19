<?php
declare(strict_types=1);

namespace ReaZzon\JWTAuth\Classes\Dto;

use October\Rain\Argon\Argon;
use October\Rain\Auth\Models\User;
use ReaZzon\JWTAuth\Classes\Guards\JWTGuard;
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


    // HELPERS
    /**
     * @param JWTGuard $JWTGuard
     * @return static
     */
    public static function createByJWTGuard(JWTGuard $JWTGuard): self
    {
        return new static([
            'token' => $JWTGuard->getCurrentToken(),
            'expires' => Argon::createFromTimestamp($JWTGuard->getPayload()->get('exp')),
            'user' => $JWTGuard->user(),
        ]);
    }
}
