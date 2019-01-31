<?php
/**
 * Created by PhpStorm.
 * User: box
 * Date: 31.01.19
 * Time: 17:26
 */

namespace app\exceptions;


abstract class ApiException extends \Exception
{
    protected $messages = [];

    protected $statusCode = 0;

    public function __construct(array $messages, string $message = "", int $code = 0)
    {
        parent::__construct($message, $code);

        $this->messages = $messages;
    }

    public function getMessages(): array
    {
        return $this->messages;
    }
}