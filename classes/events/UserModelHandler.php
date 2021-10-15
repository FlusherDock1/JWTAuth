<?php namespace ReaZzon\JWTAuth\Classes\Events;

use ReaZzon\JWTAuth\Classes\Behaviors\UserSubjectBehavior;
use Illuminate\Contracts\Auth\Authenticatable;
use ReaZzon\JWTAuth\Classes\Contracts\UserPluginResolver;

class UserModelHandler
{
    /**
     * Add listeners
     * @param \Illuminate\Events\Dispatcher $obEvent
     */
    public function subscribe($obEvent)
    {
        $model = app(UserPluginResolver::class)->getModel();
        $model::extend(static function (Authenticatable $userModel) {
            $userModel->implement[] = UserSubjectBehavior::class;
        });
    }
}
