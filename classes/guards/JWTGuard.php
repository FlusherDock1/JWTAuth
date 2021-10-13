<?php namespace ReaZzon\JWTAuth\Classes\Guards;

use Tymon\JWTAuth\JWT;
use Tymon\JWTAuth\JWTGuard as JWTGuardBase;
use Lovata\Buddies\Models\User;
use ReaZzon\JWTAuth\Classes\Behaviors\UserSubjectBehavior;

/**
 * Class JWTGuard
 * @package LeMaX10\JwtUser\Classes\Guards
 */
class JWTGuard extends JWTGuardBase
{
    /**
     * @param  User  $user
     * @return string
     */
    public function login($user)
    {
        $this->validateMethodParam($user);

        $proxyUserImplementedClass = $user->getProxyJwtSubject();
        $token = $this->jwt->fromSubject($proxyUserImplementedClass);
        $this->setToken($token)->setUser($user);

        return $token;
    }

    /**
     * @return bool
     */
    public function hasToken(): bool
    {
        return $this->jwt->parser()->setRequest($this->getRequest())->hasToken();
    }

    /**
     * @param User $user
     */
    private function validateMethodParam(User $user): void
    {
        if (!$user->isClassExtendedWith(UserSubjectBehavior::class)) {
            throw new \InvalidArgumentException(
                sprintf('user param must extend %s', UserSubjectBehavior::class)
            );
        }
    }

}
