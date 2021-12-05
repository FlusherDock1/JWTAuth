<?php
declare(strict_types=1);

namespace ReaZzon\JWTAuth\Http\Resources;

use Illuminate\Container\Container;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Resources\Json\JsonResource;
use October\Rain\Extension\ExtendableTrait;

/**
 *
 */
abstract class ExtendableResource extends JsonResource
{
    use ExtendableTrait;

    /**
     * @var array Extensions implemented by this class.
     */
    public array $implement = [];

    /**
     * Constructor
     * @throws \Exception
     */
    public function __construct($resource)
    {
        parent::__construct($resource);
        $this->extendableConstruct();
    }

    /**
     * @param null $request
     * @return array
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function resolve($request = null)
    {
        $request = $request ?: Container::getInstance()->make('request');
        $data = $this->extendableCall('toArray', [$request]);

        if ($data instanceof Arrayable) {
            $data = $data->toArray();
        } elseif ($data instanceof \JsonSerializable) {
            $data = $data->jsonSerialize();
        }

        return $this->filter((array) $data);
    }

    /**
     * Customize the response for a request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Http\JsonResponse  $response
     * @return void
     */
    public function withResponse($request, $response)
    {
        $this->extendableCall('withResponse', [$request, $response]);
    }

    /**
     * @param string $name
     * @return mixed|string
     */
    public function __get($name)
    {
        return $this->extendableGet($name);
    }

    /**
     * @param $name
     * @param $value
     */
    public function __set($name, $value)
    {
        $this->extendableSet($name, $value);
    }

    /**
     * @param string $name
     * @param array $params
     * @return mixed
     */
    public function __call($name, $params)
    {
        return $this->extendableCall($name, $params);
    }

    /**
     * @param $name
     * @param $params
     * @return mixed
     * @throws \Exception
     */
    public static function __callStatic($name, $params)
    {
        return static::extendableCallStatic($name, $params);
    }

    /**
     * @param callable $callback
     */
    public static function extend(callable $callback)
    {
        static::extendableExtendCallback($callback);
    }
}
