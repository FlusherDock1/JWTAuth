<?php
declare(strict_types=1);

namespace ReaZzon\JWTAuth\Classes\Exceptions\Http;

use Symfony\Component\HttpFoundation\Response;

/**
 * Class PasswordWrongException.
 * @package ReaZzon\JWTAuth\Classes\Exceptions\Http
 */
class PasswordWrongException extends JWTHttpException
{
    /**
     * @var int
     */
    protected $httpCode = Response::HTTP_FORBIDDEN;

    /**
     * @var string
     */
    protected $message = 'Login or password incorrect';
}
