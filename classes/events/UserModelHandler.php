<?php
declare(strict_types=1);

namespace ReaZzon\JWTAuth\Classes\Events;

use Illuminate\Contracts\Auth\Authenticatable;
use October\Rain\Database\Model;
use ReaZzon\JWTAuth\Classes\Contracts\UserPluginResolver;
use ReaZzon\JWTAuth\Classes\Behaviors\UserSubjectBehavior;

final class UserModelHandler
{
    /**
     * Add listeners
     * @param \October\Rain\Events\Dispatcher $event
     */
    public function subscribe($event)
    {
        $model = app(UserPluginResolver::class)->getModel();
        $model::extend(static function (Authenticatable $userModel) {
            /** @var Authenticatable|Model $userModel */
            $userModel->implementClassWith(UserSubjectBehavior::class);
        });
    }
}
