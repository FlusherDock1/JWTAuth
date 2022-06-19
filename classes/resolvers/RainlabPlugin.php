<?php
declare(strict_types=1);

namespace ReaZzon\JWTAuth\Classes\Resolvers;

use RainLab\User\Models\Settings as UserSettings;
use RainLab\User\Models\User as RainlabUserModel;
use ReaZzon\JWTAuth\Classes\Contracts\Plugin;
use ReaZzon\JWTAuth\Classes\Exception\PluginModelResolverException;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;
use Model;
use ReaZzon\JWTAuth\Classes\Traits\BasePluginResolver;

/**
 *
 */
final class RainlabPlugin implements Plugin
{
    use BasePluginResolver;

    protected const MODEL = RainlabUserModel::class;

    public function initActivation(Model $user): Model
    {

    }

    public function activateByCode($code): Model
    {
        // TODO: Implement activateByCode() method.
    }

    /**
     * @inheritDoc
     */
    public function registrationValidationExtend(): array
    {
        return [
            'username' => 'sometimes|string',
            'surname' => 'sometimes|string',
        ];
    }

    /**
     * @inheritDoc
     */
    public function loginValidationExtend(): array
    {
        return [];
    }

    /**
     * @return JWTSubject
     */
    protected function proxyObject(): JWTSubject
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
                return UserSettings::get('activate_mode') === UserSettings::ACTIVATE_AUTO;
            }
        };
    }
}
