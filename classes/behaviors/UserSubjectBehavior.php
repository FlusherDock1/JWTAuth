<?php
declare(strict_types=1);
namespace ReaZzon\JWTAuth\Classes\Behaviors;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use October\Rain\Database\ModelBehavior;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;

/**
 * Class UserSubjectBehavior
 * @package ReaZzon\JWTAuth\Classes\Behaviors
 */
class UserSubjectBehavior extends ModelBehavior implements JWTSubject
{
    /** @var Authenticatable|Model */
    protected $model;

    /**
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->model->getAuthIdentifier();
    }

    /**
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
