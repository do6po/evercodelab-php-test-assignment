<?php
/**
 * Created by PhpStorm.
 * User: box
 * Date: 31.01.19
 * Time: 17:36
 */

namespace app\exceptions\validations;


use app\exceptions\ApiException;

class RequestValidationException extends ApiException
{
    public function __construct(array $messages, string $message = "", int $code = 422)
    {
        parent::__construct($messages, $message, $code);
    }
}