<?php
declare(strict_types=1);

namespace ReaZzon\JWTAuth\Classes\Exceptions\Http;

use Symfony\Component\HttpFoundation\Response;

/**
 * Class RegistrationErrorException.
 * @package ReaZzon\JWTAuth\Classes\Exceptions\Http
 */
class RegistrationErrorException extends JWTHttpException
{
    /**
     * @var int
     */
    protected $httpCode = Response::HTTP_BAD_REQUEST;

    /**
     * @var string
     */
    protected $message = 'Registration failed';
}
