<?php
declare(strict_types=1);

namespace ReaZzon\JWTAuth\Classes\Dto;

use October\Rain\Argon\Argon;
use October\Rain\Auth\Models\User;
use Spatie\DataTransferObject\DataTransferObject;

/**
 *
 */
final class PluginDto extends DataTransferObject
{
    /**
     * @var string
     */
    public string $name;

    /**
     * @var string
     */
    public string $model;

    /**
     * @var string
     */
    public string $resolver;

    /**
     * @var string
     */
    public string $provider;
}
