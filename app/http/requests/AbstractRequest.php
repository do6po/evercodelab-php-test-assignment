<?php
/**
 * Created by PhpStorm.
 * User: box
 * Date: 29.01.19
 * Time: 13:05
 */

namespace app\http\requests;


use Illuminate\Http\Request;
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

    public function __construct(Request $request, ValidatorFactory $validatorFactory)
    {
        $this->validatorFactory = $validatorFactory;

        $this->request = $request;

        $this->init();
    }

    protected function init()
    {
        $this->validator = $this->validatorFactory
            ->make($this->data(), $this->rules());
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