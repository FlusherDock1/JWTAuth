<?php
declare(strict_types=1);

namespace ReaZzon\JWTAuth\Classes\Exceptions;

use Illuminate\Validation\Validator;
use October\Rain\Exception\ApplicationException;

/**
 * Class ValidationException
 */
class ValidationException extends ApplicationException
{
    /**
     * @var int
     */
    protected $statusCode = 422;

    /**
     * @var Validator
     */
    protected $validation;

    /**
     * @var array
     */
    protected $response = [
        'errors' => []
    ];

    /**
     * ValidationException constructor.
     *
     * @param Validator $validator
     */
    public function __construct(Validator $validator) {
        parent::__construct();
        $this->validation = $validator;
    }

    /**
     *
     */
    protected function parseErrors(): void
    {
        foreach($this->validation->errors()->toArray() as $field => $message) {
            $this->addErrorToResponse($field, $message);
        }
    }

    /**
     * @param $field
     * @param $message
     *
     * @return $this
     */
    protected function addErrorToResponse($field, $message): self
    {
        $this->response['errors'][] = [
            'source' => [
                'pointer' => "/data/attributes/". $field,
                'field'   => $field
            ],
            'title' => 'invalid attribute',
            'detail'=> (string) array_shift($message)
        ];

        return $this;
    }

    /**
     * @return array
     */
    public function response(): array
    {
        $this->parseErrors();
        return $this->response;
    }
}
