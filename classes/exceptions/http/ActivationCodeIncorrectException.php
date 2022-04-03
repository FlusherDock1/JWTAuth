<?php
declare(strict_types=1);

namespace ReaZzon\JWTAuth\Classes\Exceptions\Http;

use Symfony\Component\HttpFoundation\Response;

/**
 * Class ActivationCodeIncorrectException.
 * @package ReaZzon\JWTAuth\Classes\Exceptions\Http
 */
class ActivationCodeIncorrectException extends JWTHttpException
{
    /**
     * @var int
     */
    protected $httpCode = Response::HTTP_NOT_FOUND;

    /**
     * @var string
     */
    protected $message = 'Activation code is incorrect';
}
