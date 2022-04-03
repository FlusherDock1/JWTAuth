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

    /**
     * @param $model
     * @return string
     */
    public function initActivation($model): string;

    /**
     * @param $code
     * @return mixed
     */
    public function activateByCode($code);

    /**
     * @return array
     */
    public function registrationValidationExtend(): array;

    /**
     * @return array
     */
    public function loginValidationExtend(): array;
  
    public function initActivation($model): string;

    public function activateByCode($code);
}
