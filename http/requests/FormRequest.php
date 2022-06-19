<?php
declare(strict_types=1);

namespace ReaZzon\JWTAuth\Http\Requests;

use Illuminate\Contracts\Validation\Factory as ValidationFactory;
use Illuminate\Foundation\Http\FormRequest as BaseFormRequest;
use October\Rain\Extension\ExtendableTrait;
use ReaZzon\JWTAuth\Classes\Exceptions\ValidationException;
use Illuminate\Contracts\Validation\Validator;

/**
 * Class FormRequest.
 * @package ReaZzon\JWTAuth\Http\Requests
 */
abstract class FormRequest extends BaseFormRequest
{
    use ExtendableTrait;

    /**
     *
     */
    private const EXTEND_RULES_METHOD = 'extendRules';
    /**
     *
     */
    private const EXTEND_MESSAGES_METHOD = 'extendMessages';
    /**
     *
     */
    private const EXTEND_ATTRIBUTES_METHOD = 'extendAttributes';

    /**
     * Constructor
     * @throws \Exception
     */
    public function __construct(
        array $query = [],
        array $request = [],
        array $attributes = [],
        array $cookies = [],
        array $files = [],
        array $server = [], $content = null
    )
    {
        parent::__construct($query, $request, $attributes, $cookies, $files, $server, $content);
        $this->extendableConstruct();
    }

    /**
     * Create the default validator instance.
     *
     * @param  \Illuminate\Contracts\Validation\Factory  $factory
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function createDefaultValidator(ValidationFactory $factory)
    {
        $extendRules      = $this->getExtendRequestByMethod(self::EXTEND_RULES_METHOD);
        $extendMessages   = $this->getExtendRequestByMethod(self::EXTEND_MESSAGES_METHOD);
        $extendAttributes = $this->getExtendRequestByMethod(self::EXTEND_ATTRIBUTES_METHOD);

        return $factory->make(
            $this->validationData(),
            array_merge_recursive($this->container->call([$this, 'rules']), $extendRules),
            array_merge_recursive($this->messages(), $extendMessages),
            array_merge_recursive($this->attributes(), $extendAttributes)
        );
    }

    /**
     * @param string $name
     * @return array
     */
    private function getExtendRequestByMethod(string $name): array
    {
        return $this->methodExists($name) ?
            $this->extendableCall($name) : [];
    }

    /**
     * @param Validator $validator
     * @return void
     * @throws ValidationException
     */
    protected function failedValidation(Validator $validator)
    {
        throw new ValidationException($validator);
    }
}
