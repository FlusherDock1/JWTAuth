<?php
declare(strict_types=1);

namespace ReaZzon\JWTAuth\Classes;

use October\Rain\Support\Traits\Singleton;
use System\Classes\PluginManager;
use Model;
use Tymon\JWTAuth\Contracts\JWTSubject;
use October\Rain\Auth\Manager as AuthManager;
use ReaZzon\JWTAuth\Classes\Contracts\UserPluginResolver as UserPluginResolverContract;
/**
 *
 */
final class UserPluginResolver implements UserPluginResolverContract
{
    use Singleton;

    /**
     * @var string
     */
    private string $plugin;

    /**
     *
     */
    public function init(): void
    {
        $plugins = $this->getSupportPlugins();
        foreach($plugins as $pluginName) {
            if (PluginManager::instance()->hasPlugin($pluginName)) {
                $this->plugin = $pluginName;
                break;
            }
        }
    }

    /**
     * @return string
     */
    public function getModel(): string
    {
        return (string) config("reazzon.jwtauth::jwtauth.plugins.{$this->plugin}.model");
    }

    /**
     * @param Model $model
     * @return JWTSubject
     */
    public function resolveModel(Model $model): JWTSubject
    {
        $resolver = config("reazzon.jwtauth::jwtauth.plugins.{$this->plugin}.resolver");
        return (new $resolver)->resolve($model);
    }

    /**
     * @return AuthManager
     */
    public function getProvider(): AuthManager
    {
        $provider = config("reazzon.jwtauth::jwtauth.plugins.{$this->plugin}.provider");
        return app($provider);
    }

    /**
     * @return array
     */
    public function getSupportPlugins(): array
    {
        return array_keys(config('reazzon.jwtauth::jwtauth.plugins'));
    }
}
