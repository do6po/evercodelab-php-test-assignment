<?php
/**
 * Created by PhpStorm.
 * User: box
 * Date: 29.01.19
 * Time: 13:05
 */

namespace app\http\requests;


use app\exceptions\validations\RequestValidationException;
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Http\Request;
use Illuminate\Validation\DatabasePresenceVerifier;
use Illuminate\Validation\Validator;
use JeffOchoa\ValidatorFactory;

/**
 * Class AbstractValidator
 *
 * @package app\validators
 */
abstract class AbstractRequest
{
    /**
     * @var ValidatorFactory
     */
    protected $validatorFactory;

    /**
     * @var Validator
     */
    protected $validator;

    /**
     * @var Request
     */
    protected $request;

    /**
     * AbstractRequest constructor.
     *
     * @param Request $request
     * @param ValidatorFactory $validatorFactory
     * @throws RequestValidationException
     */
    public function __construct(Request $request, ValidatorFactory $validatorFactory)
    {
        $this->validatorFactory = $validatorFactory;

        $this->request = $request;

        $this->init();
        $this->handle();
    }


    protected function init()
    {
        $this->validator = $this->validatorFactory
            ->make($this->data(), $this->rules());
        /** @var Capsule $capsule */
        $capsule = app()->make('db');
        $this->validatorFactory->setPresenceVerifier(
            new DatabasePresenceVerifier(
                $capsule->getDatabaseManager()
            )
        );
    }

    /**
     * @throws RequestValidationException
     */
    public function handle()
    {
        if ($this->hasErrors()) {
            throw new RequestValidationException(
                $this->errors()->toArray(),
                'Request validation error!'
            );
        }
    }

    public function data(): array
    {
        return $this->all();
    }

    public function all(): array
    {
        return $this->request->all();
    }

    public function get($key)
    {
        return $this->request->get($key);
    }

    public function hasErrors(): bool
    {
        return count($this->errors()) > 0;
    }

    public function errors()
    {
        return $this->validator->errors();
    }

    public abstract function rules(): array;
}