<?php namespace ReaZzon\JWTAuth\JWT;

use October\Rain\Database\ModelBehavior;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Lovata\Buddies\Models\User;

/**
 * Class JWTUserSubjectBehavior
 * @package ReaZzon\JWTAuth\Behaviors
 */
class JWTUserSubjectBehavior extends ModelBehavior implements JWTSubject
{
    /** @var User */
    protected $model;

    /**
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->model->getKey();
    }

    /**
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    /**
     * @return JWTSubject
     */
    public function getProxyJwtSubject(): JWTSubject
    {
        $proxyClass = new class extends User implements JWTSubject {
            public $exists = true;

            public function getJWTIdentifier()
            {
                return $this->extendableCall('getJWTIdentifier', []);
            }

            public function getJWTCustomClaims()
            {
                return $this->extendableCall('getJWTCustomClaims', []);
            }
        };

        return (new $proxyClass())->setRawAttributes($this->model->toArray());
    }
}
