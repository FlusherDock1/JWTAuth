<?php
declare(strict_types=1);

namespace ReaZzon\JWTAuth\Classes\Traits;

use October\Rain\Database\Model;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;
use ReaZzon\JWTAuth\Classes\Exception\PluginModelResolverException;

/**
 *
 */
trait BasePluginResolver
{
    /**
     * @inheritDoc
     * @throws PluginModelResolverException
     */
    public function resolve($model): JWTSubject
    {
        if (!is_a($model, $this->getModelClass())) {
            throw new PluginModelResolverException;
        }

        $proxyObject = $this->proxyObject();
        return (new $proxyObject)->setRawAttributes($model->getAttributes());
    }

    /**
     * @return string
     * @throws PluginModelResolverException
     */
    protected function getModelClass(): string
    {
        if (!defined('static::MODEL')) {
            throw new PluginModelResolverException;
        }

        return constant('static::MODEL');
    }

    /**
     * @return JWTSubject
     */
    protected function proxyObject(): JWTSubject
    {
        return new class extends Model implements JWTSubject {
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
