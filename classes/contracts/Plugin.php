<?php
declare(strict_types=1);

namespace ReaZzon\JWTAuth\Classes\Contracts;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Model;

/**
 *
 */
interface Plugin
{
    /**
     * @return JWTSubject
     */
    public function resolve(Model $model): JWTSubject;
}
