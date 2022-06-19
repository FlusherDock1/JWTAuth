<?php
declare(strict_types=1);

namespace ReaZzon\JWTAuth\Classes\Contracts;

use Illuminate\Contracts\Auth\Authenticatable;
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
     * @param Model $user
     * @return Model
     */
    public function initActivation(Model $user): Model;

    /**
     * @param string $code
     * @return Model
     */
    public function activateByCode(string $code): Model;

    /**
     * @return array
     */
    public function registrationValidationExtend(): array;

    /**
     * @return array
     */
    public function loginValidationExtend(): array;
}
