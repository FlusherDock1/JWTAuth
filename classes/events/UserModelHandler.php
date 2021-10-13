<?php namespace ReaZzon\JWTAuth\Classes\Events;

use ReaZzon\JWTAuth\Classes\Behaviors\UserSubjectBehavior;
use Lovata\Buddies\Models\User;

class UserModelHandler
{
    /**
     * Add listeners
     * @param \Illuminate\Events\Dispatcher $obEvent
     */
    public function subscribe($obEvent)
    {
        User::extend(function (User $user) {
            $user->implement[] = UserSubjectBehavior::class;
        });
    }
}