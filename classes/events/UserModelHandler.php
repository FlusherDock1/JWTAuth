<?php namespace ReaZzon\JWTAuth\Classes\Events;

use Illuminate\Contracts\Auth\Authenticatable;
use ReaZzon\JWTAuth\Classes\Contracts\UserPluginResolver;
use ReaZzon\JWTAuth\Classes\Behaviors\UserSubjectBehavior;

class UserModelHandler
{
    /**
     * Add listeners
     * @param \October\Rain\Events\Dispatcher $event
     */
    public function subscribe($event)
    {
        $model = app(UserPluginResolver::class)->getModel();
        $model::extend(static function (Authenticatable $userModel) {
            $userModel->implement[] = UserSubjectBehavior::class;
        });
    }
}
