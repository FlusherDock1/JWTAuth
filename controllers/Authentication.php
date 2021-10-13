<?php namespace ReaZzon\JWTAuth\Controllers;

use Input;
use Illuminate\Routing\Controller;
use Lovata\Buddies\Facades\AuthHelper;
use ReaZzon\JWTAuth\JWT\JWTGuard;
use Kharanenka\Helper\Result;
use October\Rain\Argon\Argon;

/**
 * Class Authentication
 * @package ReaZzon\JWTAuth\Controllers
 */
class Authentication extends Controller
{
    protected array $arRequestParams = [
        'email', 'name', 'last_name', 'middle_name', 'phone', 'password', 'password_confirmation'
    ];

    protected function getCredentials()
    {
        $arRequest = Input::only($this->arRequestParams);

        // Escaping each value to secure creation to database
        $arCredentials = [];
        foreach ($arRequest as $sKey => $sValue) {
            $arCredentials[$sKey] = e($sValue);
        }

        return $arCredentials;
    }

    public function register()
    {
        \Db::table('lovata_buddies_users')->truncate();
        $arCredentials = $this->getCredentials();

        try {
            $obUser = AuthHelper::register($arCredentials, true);
        } catch (\Exception $ex) {
            return Result::setFalse($ex->getMessage())->getJSON();
        }

        if (empty($obUser)) {
            return Result::setFalse()->setMessage('')->getJSON();
        }

        $arResponse = $this->attempt($arCredentials);

        return Result::setTrue($arResponse)->getJSON();
    }

    public function login()
    {
        $arCredentials = $this->getCredentials();

        try {
            $obUser = AuthHelper::authenticate($arCredentials, true);
        } catch (\Exception $ex) {
            return Result::setFalse($ex->getMessage())->getJSON();
        }

        if (empty($obUser)) {
            return Result::setFalse()->setMessage('')->getJSON();
        }

        $arResponse = $this->attempt($arCredentials);

        return Result::setTrue($arResponse)->getJSON();
    }

    public function refresh()
    {
        /** @var JWTGuard $obJWTGuard */
        $obJWTGuard = app('JWTGuard');

        $sToken = $obJWTGuard->refresh(true);
        $obJWTGuard->setToken($sToken);

        return Result::setTrue($this->getResponse($sToken))->getJSON();
    }

    protected function attempt($arCredentials)
    {
        $obUser = AuthHelper::authenticate(['email' => $arCredentials['email'], 'password' => $arCredentials['password']], true);
        $sToken = app('JWTGuard')->login($obUser);

        return $this->getResponse($sToken, $obUser->toArray());
    }

    protected function getResponse($sToken, $arUser = null): array
    {
        $sExpiredAt = Argon::createFromTimestamp(app('JWTGuard')->getPayload()->get('exp'));
        return [
            'token' => $sToken,
            'expires' => $sExpiredAt,
            'user' => $arUser
        ];
    }
}
