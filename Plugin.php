<?php namespace ReaZzon\JWTAuth;

use Backend;
use System\Classes\PluginBase;

use Illuminate\Auth\Access\Gate;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Contracts\Auth\Access\Gate as GateContract;

use ReaZzon\JWTAuth\Classes\Guards\JWTGuard;
use ReaZzon\JWTAuth\Classes\Providers\UserProvider;
use ReaZzon\JWTAuth\Classes\Behaviors\UserSubjectBehavior;

use Lovata\Buddies\Models\User;

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
            'description' => 'No description provided yet...',
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

    }

    /**
     * Регистрация менеджера авторизации.
     */
    private function registerGates(): void
    {
        $alias = AliasLoader::getInstance();
        $alias->alias('Gate', \Illuminate\Support\Facades\Gate::class);

        $this->app->singleton(GateContract::class, static function ($app): Gate {
            return new Gate($app, static function () use ($app): ?User {
                return $app['user.auth']->user();
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
                new JWTUserProvider(User::class),
                $app['request']
            );

            $app->refresh('request', $guard, 'setRequest');

            return $guard;
        });
    }
}
