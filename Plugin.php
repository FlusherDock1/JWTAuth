<?php namespace ReaZzon\JWTAuth;

use Backend;
use System\Classes\PluginBase;

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
            'author'      => 'ReaZzon',
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
     * Registers any front-end components implemented in this plugin.
     *
     * @return array
     */
    public function registerComponents()
    {
        return []; // Remove this line to activate

        return [
            'ReaZzon\JWTAuth\Components\MyComponent' => 'myComponent',
        ];
    }

    /**
     * Registers any back-end permissions used by this plugin.
     *
     * @return array
     */
    public function registerPermissions()
    {
        return []; // Remove this line to activate

        return [
            'reazzon.jwtauth.some_permission' => [
                'tab' => 'JWTAuth',
                'label' => 'Some permission'
            ],
        ];
    }

    /**
     * Registers back-end navigation items for this plugin.
     *
     * @return array
     */
    public function registerNavigation()
    {
        return []; // Remove this line to activate

        return [
            'jwtauth' => [
                'label'       => 'JWTAuth',
                'url'         => Backend::url('reazzon/jwtauth/mycontroller'),
                'icon'        => 'icon-leaf',
                'permissions' => ['reazzon.jwtauth.*'],
                'order'       => 500,
            ],
        ];
    }
}
