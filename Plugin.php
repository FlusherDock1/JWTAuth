<?php
declare(strict_types=1);

namespace ReaZzon\JWTAuth;

use Event, Config;
use System\Classes\PluginBase;
use ReaZzon\JWTAuth\Classes\UserPluginResolver;
use ReaZzon\JWTAuth\Classes\Contracts\UserPluginResolver as UserPluginResolverContract;

use Illuminate\Auth\Access\Gate;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Contracts\Auth\Access\Gate as GateContract;

use ReaZzon\JWTAuth\Classes\Guards\JWTGuard;
use ReaZzon\JWTAuth\Classes\Providers\UserProvider;

use Lovata\Buddies\Models\User;
use ReaZzon\JWTAuth\Classes\Events\UserModelHandler;

use System\Classes\PluginManager;
use PHPOpenSourceSaver\JWTAuth\Providers\LaravelServiceProvider;

/**
 * JWTAuth Plugin Information File
 */
class Plugin extends PluginBase
{
    /**
     *
     */
    public const PLUGIN_NAME = 'ReaZzon.JWTAuth';

    /**
     * Returns information about this plugin.
     *
     * @return array
     */
    public function pluginDetails()
    {
        return [
            'name'        => 'JWTAuth',
            'description' => 'JWT authorization plugin',
            'author'      => 'ReaZzon, LeMaX10',
            'icon'        => 'icon-leaf'
        ];
    }

    /**
     * Register method, called when the plugin is first registered.
     *
     * @return void
     */
    public function register()
    {
        $this->checkRequiredPlugins();

        $this->app->singleton(
            UserPluginResolverContract::class,
            static fn() => UserPluginResolver::instance(),
        );

    }

    /**
     * Boot method, called right before the request route.
     *
     * @return void
     */
    public function boot()
    {
        if (!$this->getResolver()->isRequiredResolve()) {
            PluginManager::instance()->disablePlugin(static::PLUGIN_NAME);
            if (method_exists($this->getResolver(), 'forgetInstance')) {
                $this->getResolver()::forgetInstance();
            }

            return;
        }

        $this->registerGates();
        $this->registerJWT();
        $this->registerConfigs();
        $this->addEventListeners();
    }

    protected function checkRequiredPlugins()
    {
        $plugins = ['RainLab.User', 'Lovata.Buddies'];
        $pluginInstalled = false;

        foreach ($plugins as $pluginName) {
            if (PluginManager::instance()->hasPlugin($pluginName)) {
                $pluginInstalled = true;
            }
        }

        if (!$pluginInstalled) {
            PluginManager::instance()->disablePlugin('ReaZzon.JWTAuth');
        }
    }

    /**
     *
     */
    private function registerConfigs()
    {
        $pluginNamespace = str_replace('\\', '.', strtolower(__NAMESPACE__));
        $packages = Config::get($pluginNamespace . '::packages');

        foreach ($packages as $name => $options) {
            if (!empty($options['config']) && !empty($options['config_namespace'])) {
                Config::set($options['config_namespace'], $options['config']);
            }
        }
    }

    /**
     *
     */
    private function addEventListeners(): void
    {
        Event::subscribe(UserModelHandler::class);
    }

    /**
     * Регистрация менеджера авторизации.
     */
    private function registerGates(): void
    {
        $alias = AliasLoader::getInstance();
        $alias->alias('Gate', \Illuminate\Support\Facades\Gate::class);

        $this->app->singleton(GateContract::class, function ($app): Gate {
            return new Gate($app, function () use ($app): ?User {
                return $this->getResolver()->getProvider()->user();
            });
        });
    }

    /**
     * Регистрация JWT.
     */
    private function registerJWT(): void
    {
        (new LaravelServiceProvider($this->app))->register();

        $this->app->singleton('JWTGuard', function ($app): Guard {
            $guard = new JWTGuard(
                $app['tymon.jwt'],
                new UserProvider($this->getResolver()->getModel()),
                $app['request']
            );

            $app->refresh('request', $guard, 'setRequest');
            return $guard;
        });
    }

    /**
     * @return array[]
     */
    public function registerSettings(): array
    {
        return [
            'settings' => [
                'label'       => 'Buddies Settings',
                'description' => 'Manage user based settings.',
                'category'    => 'JWTAuth',
                'icon'        => 'icon-cog',
                'class'       => \ReaZzon\JWTAuth\Models\BuddiesSettings::class,
                'order'       => 500,
                'keywords'    => 'buddies users',
                'permissions' => ['buddies-menu-*']
            ]
        ];
    }

    /**
     * @return UserPluginResolverContract
     */
    private function getResolver(): UserPluginResolverContract
    {
        return app(UserPluginResolverContract::class);
    }
}
