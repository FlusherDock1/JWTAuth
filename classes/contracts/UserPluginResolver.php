<?php
declare(strict_types=1);

namespace ReaZzon\JWTAuth\Classes\Contracts;

use October\Rain\Auth\Manager as AuthManager;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;
use Model;
use PHPOpenSourceSaver\JWTAuth\JWTGuard;

/**
 *
 */
interface UserPluginResolver
{
    /**
     * @return string
     */
    public function getModel(): string;

    public function getResolver(): Plugin;

    /**
     * @return Plugin
     */
    public function getResolver(): Plugin;

    /**
     * @param Model $model
     * @return JWTSubject
     */
    public function resolveModel(Model $model): JWTSubject;

    /**
     * @return AuthManager
     */
    public function getProvider(): AuthManager;

    /**
     * @return array
     */
    public function getSupportPlugins(): array;

    /**
     * @return JWTGuard
     */
    public function getGuard(): JWTGuard;

    /**
     * @return bool
     */
    public function isRequiredResolve(): bool;
}
