<?php
/**
 * Created by PhpStorm.
 * User: Boiko Sergii
 * Date: 02.02.2019
 * Time: 23:30
 */

namespace app\exceptions\http;


use app\exceptions\AbstractApiException;

class ContentTypeException extends AbstractApiException
{
    protected $statusCode = 415;
}