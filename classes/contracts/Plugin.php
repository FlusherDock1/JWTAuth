<?php
declare(strict_types=1);

namespace ReaZzon\JWTAuth\Classes\Contracts;

use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;
use Model;

/**
 *
 */
interface Plugin
{
    /**
     * @param Model $model
     * @return JWTSubject
     */
    public function resolve(Model $model): JWTSubject;

    public function initActivation($model): string;

    public function activateByCode($code);
}
