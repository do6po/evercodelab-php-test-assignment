<?php
/**
 * Created by PhpStorm.
 * User: box
 * Date: 31.01.19
 * Time: 17:48
 */

namespace Tests\Unit\exceptions;


use app\exceptions\validations\RequestValidationException;
use Tests\TestCase;

class ValidationExceptionTest extends TestCase
{
    public function testGetCode()
    {
        $messages = [
            'key1' => 'message1',
            'key2' => 'message2'
        ];

        $exception = new RequestValidationException($messages);

        $this->assertEquals(422, $exception->getStatusCode());
        $this->assertEquals($messages, $exception->getMessages());
    }
}