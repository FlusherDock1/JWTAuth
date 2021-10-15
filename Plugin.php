<?php
declare(strict_types=1);

namespace ReaZzon\JWTAuth;

use Event, Config;
use ReaZzon\JWTAuth\Classes\Contracts\UserPluginResolver as UserPluginResolverContract;
use ReaZzon\JWTAuth\Classes\UserPluginResolver;
use System\Classes\PluginBase;

use Illuminate\Auth\Access\Gate;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Contracts\Auth\Access\Gate as GateContract;

use ReaZzon\JWTAuth\Classes\Guards\JWTGuard;
use ReaZzon\JWTAuth\Classes\Providers\UserProvider;

use Lovata\Buddies\Models\User;
use ReaZzon\JWTAuth\Classes\Events\UserModelHandler;

use Tymon\JWTAuth\Providers\LaravelServiceProvider;

/**
 * JWTAuth Plugin Information File
 */
class Plugin extends PluginBase
{
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
        $this->app->singleton(
            UserPluginResolverContract::class,
            static fn() => UserPluginResolver::instance()
        );

        $this->registerGates();
        $this->registerJWT();
    }

    /**
     * Boot method, called right before the request route.
     *
     * @return array
     */
    public function boot()
    {
        $this->registerConfigs();
        $this->addEventListeners();
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
    private function addEventListeners()
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
                return app(UserPluginResolverContract::class)->getProvider()->user();
            });
        });
    }

    /**
     * Регистрация JWT.
     */
    private function registerJWT(): void
    {
        (new LaravelServiceProvider($this->app))->register();

        $this->app->singleton('JWTGuard', static function ($app): Guard {
            $guard = new JWTGuard(
                $app['tymon.jwt'],
                new UserProvider(app(UserPluginResolverContract::class)->getModel()),
                $app['request']
            );

            $app->refresh('request', $guard, 'setRequest');
            return $guard;
        });
    }
}
