<?php namespace ReaZzon\JWTAuth\Classes\Guards;

use Illuminate\Contracts\Auth\Authenticatable;
use October\Rain\Auth\Models\User;
use ReaZzon\JWTAuth\Classes\Contracts\UserPluginResolver;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;
use PHPOpenSourceSaver\JWTAuth\JWTGuard as JWTGuardBase;
use ReaZzon\JWTAuth\Classes\Behaviors\UserSubjectBehavior;

/**
 * Class JWTGuard
 * @package ReaZzon\JwtUser\Classes\Guards
 */
class JWTGuard extends JWTGuardBase
{
    /**
     * @param  Authenticatable  $user
     * @return string
     */
    public function login($user): string
    {
        $this->validateMethodParam($user);

        $userPluginResolver = app(UserPluginResolver::class);
        $token = $this->jwt->fromSubject($userPluginResolver->resolveModel($user));
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
    private function validateMethodParam(Authenticatable $user): void
    {
        if (!$user->isClassExtendedWith(UserSubjectBehavior::class)) {
            throw new \InvalidArgumentException(
                sprintf('user param must extend %s', UserSubjectBehavior::class)
            );
        }
    }

}
