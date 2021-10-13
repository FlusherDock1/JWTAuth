<?php namespace ReaZzon\JWTAuth\JWT;

use ReaZzon\JWTAuth\JWT\JWTUserSubjectBehavior;
use Lovata\Buddies\Models\User;
use Tymon\JWTAuth\JWT;
use Tymon\JWTAuth\JWTGuard as JWTGuardBase;

/**
 * Class JWTGuard
 * @package LeMaX10\JwtUser\Classes
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
        if (!$user->isClassExtendedWith(JWTUserSubjectBehavior::class)) {
            throw new \InvalidArgumentException(
                sprintf('user param must extend %s', JWTUserSubjectBehavior::class)
            );
        }
    }

}
