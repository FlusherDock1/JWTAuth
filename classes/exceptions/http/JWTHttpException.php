<?php
declare(strict_types=1);

namespace ReaZzon\JWTAuth\Classes\Exceptions\Http;

use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class JWTHttpException.
 * @package ReaZzon\JWTAuth\Classes\Exceptions\Http
 */
abstract class JWTHttpException extends HttpException
{
    /**
     * @var int
     */
    protected $httpCode = Response::HTTP_BAD_REQUEST;

    /**
     * @param string $message
     * @param int|null $statusCode
     * @param \Throwable|null $previous
     * @param array $headers
     * @param int|null $code
     */
    public function __construct(string $message = '', ?int $statusCode = null, \Throwable $previous = null, array $headers = [], ?int $code = 0)
    {
        if (empty($message)) {
            $message = $this->getMessage();
        }

        if (empty($statusCode)) {
            $statusCode = $this->httpCode;
        }

        parent::__construct($statusCode, $message, $previous, $headers, $code);
    }
}
