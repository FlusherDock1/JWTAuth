<?php
declare(strict_types=1);

namespace ReaZzon\JWTAuth\Classes\Resolvers;

use Illuminate\Contracts\Auth\Authenticatable;
use Model;
use Lovata\Buddies\Models\User;
use Lovata\Buddies\Classes\Item\UserItem;
use Lovata\Buddies\Components\Registration;
use Lovata\Toolbox\Classes\Helper\SendMailHelper;
use Lovata\Toolbox\Models\Settings;
use Lovata\Buddies\Models\User as BuddiesUserModel;
use ReaZzon\JWTAuth\Classes\Traits\BasePluginResolver;
use ReaZzon\JWTAuth\Models\BuddiesSettings;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;
use ReaZzon\JWTAuth\Classes\Contracts\Plugin;
use ReaZzon\JWTAuth\Classes\Exception\PluginModelResolverException;

/**
 *
 */
final class BuddiesPlugin implements Plugin
{
    use BasePluginResolve;

    protected const MODEL = BuddiesUserModel::class;

    /**
     * @inheritDoc
     */
    public function initActivation(Model $user): Model
    {
        $activationType = BuddiesSettings::get('activation_type', 'off');

        $user->is_activated = ($activationType === 'on');
        $user->getActivationCode();

        if ($activationType === 'mail') {
            $this->notifcationMail($user);
        }

        return $user;
    }

    /**
     * @inheritDoc
     */
    public function activateByCode(string $code): ?Model
    {
        $user = User::getByActivationCode($code)->first();
        if (empty($user)) {
            return null;
        }

        $user->activate();
        $user->forceSave();

        return $user;
    }

    /**
     * @inheritDoc
     */
    public function registrationValidationExtend(): array
    {
        return [
            'email' => 'required|email',
            'last_name' => 'sometimes|string',
            'middle_name' => 'sometimes|string',
            'phone' => 'sometimes|string',
        ];
    }

    /**
     * @inheritDoc
     */
    public function loginValidationExtend(): array
    {
        return [
            'email' => 'required|email',
        ];
    }

    /**
     * @return JWTSubject
     */
    protected function proxyObject(): JWTSubject
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
     * @param Model $user
     * @return void
     */
    private function notificationMail(Model $user): void
    {
        //Get mail data
        $mailData = [
            'user'      => $user,
            'user_item' => UserItem::make($user->getKey(), $this),
            'site_url'  => config('app.url'),
        ];

        $templateName = Settings::getValue('registration_mail_template', 'lovata.buddies::mail.registration');

        SendMailHelper::instance()->send(
            $templateName,
            $user->email,
            $mailData,
            Registration::EMAIL_TEMPLATE_DATA_EVENT,
            true);
    }
}
