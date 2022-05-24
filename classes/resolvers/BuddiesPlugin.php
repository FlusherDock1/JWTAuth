<?php
declare(strict_types=1);

namespace ReaZzon\JWTAuth\Classes\Resolvers;

use Model;
use Lovata\Buddies\Models\User;
use Lovata\Buddies\Classes\Item\UserItem;
use Lovata\Buddies\Components\Registration;
use Lovata\Toolbox\Classes\Helper\SendMailHelper;
use Lovata\Toolbox\Models\Settings;
use Lovata\Buddies\Models\User as BuddiesUserModel;
use ReaZzon\JWTAuth\Models\BuddiesSettings;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;
use ReaZzon\JWTAuth\Classes\Contracts\Plugin;
use ReaZzon\JWTAuth\Classes\Exception\PluginModelResolverException;

/**
 *
 */
final class BuddiesPlugin implements Plugin
{
    /**
     * @param Model $model
     * @return JWTSubject
     * @throws PluginModelResolverException
     */
    public function resolve($model): JWTSubject
    {
        if (!$model instanceof BuddiesUserModel) {
            throw new PluginModelResolverException;
        }

        $proxyObject = $this->proxyObject();
        return (new $proxyObject)->setRawAttributes($model->getAttributes());
    }

    /**
     * @return BuddiesUserModel|JWTSubject
     */
    private function proxyObject()
    {
        return new class extends BuddiesUserModel implements JWTSubject {
            public $exists = true;

            public function getJWTIdentifier()
            {
                return $this->extendableCall('getJWTIdentifier', []);
            }

            public function getJWTCustomClaims()
            {
                return $this->extendableCall('getJWTCustomClaims', []);
            }
        };
    }

    /**
     * @param User $user
     * @return string
     */
    public function initActivation($user): string
    {
        $activationType = BuddiesSettings::get('activation_type', 'off');

        switch ($activationType) {
            case 'on':
                $user->activation_code = $user->getActivationCode();
                $user->is_activated = true;
                break;

            case 'off':
                $user->activation_code = $user->getActivationCode();
                $user->is_activated = false;
                break;

            case 'mail':
                $user->activation_code = $user->getActivationCode();
                $user->is_activated = false;

                //Get mail data
                $mailData = [
                    'user'      => $user,
                    'user_item' => UserItem::make($user->id, $this),
                    'site_url'  => config('app.url'),
                ];

                $templateName = Settings::getValue('registration_mail_template', 'lovata.buddies::mail.registration');

                $sendMailHelper = SendMailHelper::instance();
                $sendMailHelper->send(
                    $templateName,
                    $user->email,
                    $mailData,
                    Registration::EMAIL_TEMPLATE_DATA_EVENT,
                    true);

                break;
        }

        $user->forceSave();

        return $activationType;
    }

    public function activateByCode($code)
    {
        $user = User::getByActivationCode($code)->first();
        if (empty($user)) {
            return null;
        }

        $user->activate();
        $user->forceSave();

        return $user;
    }
}
