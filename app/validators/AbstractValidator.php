<?php
/**
 * Created by PhpStorm.
 * User: box
 * Date: 29.01.19
 * Time: 13:05
 */

namespace app\validators;


use Illuminate\Http\Request;
use Illuminate\Validation\Validator;
use JeffOchoa\ValidatorFactory;

/**
 * Class AbstractValidator
 *
 * @package app\validators
 */
abstract class AbstractValidator
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
        $this->request = $request;
        $this->validatorFactory = $validatorFactory;

        $this->init();
    }

    protected function init()
    {
        $this->validator = $this->validatorFactory->make($this->data(), $this->rules());
    }

    public function data(): array
    {
        return $this->request->all();
    }

    public abstract function rules(): array;

    public function hasErrors(): bool
    {
        return count($this->errors()) > 0;
    }

    public function errors()
    {
        return $this->validator->errors();
    }
}