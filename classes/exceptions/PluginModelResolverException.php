<?php
declare(strict_types=1);

namespace ReaZzon\JWTAuth\Classes\Exception;

use October\Rain\Exception\SystemException;

/**
 *
 */
class PluginModelResolverException extends SystemException
{
    /**
     * @var string
     */
    protected $message = 'Model not support in resolver';
}
