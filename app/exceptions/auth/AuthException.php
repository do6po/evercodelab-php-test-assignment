<?php
/**
 * Created by PhpStorm.
 * User: box
 * Date: 31.01.19
 * Time: 18:21
 */

namespace app\exceptions\auth;


use app\exceptions\AbstractApiException;

class AuthException extends AbstractApiException
{
    protected $statusCode = 422;
}