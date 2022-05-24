<?php
declare(strict_types=1);
namespace ReaZzon\JWTAuth\Classes\Behaviors;

use October\Rain\Database\ModelBehavior;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;

/**
 * Class UserSubjectBehavior
 * @package ReaZzon\JWTAuth\Classes\Behaviors
 */
class UserSubjectBehavior extends ModelBehavior implements JWTSubject
{
    /**
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->model->getKey();
    }

    /**
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
