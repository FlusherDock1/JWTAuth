<?php
declare(strict_types=1);

namespace ReaZzon\JWTAuth\Classes;

use PHPOpenSourceSaver\JWTAuth\JWTGuard;
use ReaZzon\JWTAuth\Classes\Contracts\Plugin;
use ReaZzon\JWTAuth\Classes\Dto\PluginDto;
use System\Classes\PluginManager;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;
use October\Rain\Support\Traits\Singleton;
use October\Rain\Auth\Manager as AuthManager;
use ReaZzon\JWTAuth\Classes\Contracts\UserPluginResolver as UserPluginResolverContract;

/**
 *
 */
final class UserPluginResolver implements UserPluginResolverContract
{
    use Singleton;

    /**
     * @var PluginDto|null
     */
    private ?PluginDto $plugin = null;

    /**
     * Boot resolver
     *
     * @throws \SystemException
     * @return void
     */
    public function init(): void
    {
        $this->plugin = \Arr::first($this->getSupportPlugins(), static function (PluginDto $plugin): bool {
            return PluginManager::instance()->hasPlugin($plugin->name);
        });
    }

    /**
     * @inheritDoc
     */
    public function getModel(): string
    {
        return $this->plugin->model;
    }

    /**
     * @inheritDoc
     */
    public function getResolver(): Plugin
    {
        return app($this->plugin->resolver);
    }

    /**
     * @inheritDoc
     */
    public function resolveModel($model): JWTSubject
    {
        return $this->getResolver()->resolve($model);
    }

    /**
     * @inheritDoc
     */
    public function getProvider(): AuthManager
    {
        return app($this->plugin->provider);
    }

    /**
     * @inheritDoc
     */
    public function getSupportPlugins(): array
    {
        return \array_map(
            static fn(array $plugin) => new PluginDto($plugin),
            config('reazzon.jwtauth::plugins')
        );
    }

    /**
     * @inheritDoc
     */
    public function getGuard(): JWTGuard
    {
        return app('JWTGuard');
    }

    /**
     * @inheritDoc
     */
    public function isRequiredResolve(): bool
    {
        return $this->plugin !== null;
    }
}
