<?php
declare(strict_types=1);

namespace ReaZzon\JWTAuth\Classes\Resolvers;

use Lovata\Buddies\Models\User as BuddiesUserModel;
use ReaZzon\JWTAuth\Classes\Contracts\Plugin;
use ReaZzon\JWTAuth\Classes\Exception\PluginModelResolverException;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Model;

/**
 *
 */
final class BuddiesPlugin implements Plugin
{
    /**
     * @param Model $model
     * @return JWTSubject
     * @throws PluginModelResolverException
     */
    public function resolve(Model $model): JWTSubject
    {
        if (!$model instanceof BuddiesUserModel) {
            throw new PluginModelResolverException;
        }

        $proxyObject = $this->proxyObject();
        return (new $proxyObject)->setRawAttributes($model->getAttributes());
    }

    /**
     * @return BuddiesUserModel|JWTSubject
     */
    private function proxyObject()
    {
        return new class extends BuddiesUserModel implements JWTSubject {
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
    }
}
