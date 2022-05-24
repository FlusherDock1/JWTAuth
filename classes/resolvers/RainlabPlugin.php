<?php
declare(strict_types=1);

namespace ReaZzon\JWTAuth\Classes\Resolvers;

use RainLab\User\Models\User as RainlabUserModel;
use ReaZzon\JWTAuth\Classes\Contracts\Plugin;
use ReaZzon\JWTAuth\Classes\Exception\PluginModelResolverException;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;
use Model;

/**
 *
 */
final class RainlabPlugin implements Plugin
{
    /**
     * @param Model $model
     * @return JWTSubject
     * @throws PluginModelResolverException
     */
    public function resolve(Model $model): JWTSubject
    {
        if (!$model instanceof RainlabUserModel) {
            throw new PluginModelResolverException;
        }

        $proxyObject = $this->proxyObject();
        return (new $proxyObject)->setRawAttributes($model->getAttributes());
    }

    /**
     * @return RainlabUserModel|JWTSubject
     */
    private function proxyObject()
    {
        return new class extends RainlabUserModel implements JWTSubject {
            public $exists = true;

            public function getJWTIdentifier()
            {
                return $this->extendableCall('getJWTIdentifier', []);
            }

            public function getJWTCustomClaims()
            {
                return $this->extendableCall('getJWTCustomClaims', []);
            }

            public function afterRegistrationActivate()
            {
                return 'on';
            }
        };
    }

    public function initActivation($model): string
    {
        // TODO: Implement initActivation() method.
    }

    public function activateByCode($code)
    {
        // TODO: Implement activateByCode() method.
    }
}
