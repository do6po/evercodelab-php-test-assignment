<?php
/**
 * Created by PhpStorm.
 * User: box
 * Date: 31.01.19
 * Time: 19:36
 */

namespace app\exceptions\auth;


use app\exceptions\AbstractApiException;

class ForbiddenHttpException extends AbstractApiException
{
    protected $statusCode = 403;
}