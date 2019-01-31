<?php
/**
 * Created by PhpStorm.
 * User: box
 * Date: 31.01.19
 * Time: 17:26
 */

namespace app\exceptions;


abstract class AbstractApiException extends \Exception
{
    protected $messages = [];

    protected $statusCode = 0;

    public function __construct(array $messages, string $message = "")
    {
        parent::__construct($message);

        $this->messages = $messages;
    }

    public function getMessages(): array
    {
        return $this->messages;
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }
}