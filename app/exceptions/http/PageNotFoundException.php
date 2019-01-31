<?php
/**
 * Created by PhpStorm.
 * User: box
 * Date: 31.01.19
 * Time: 20:06
 */

namespace app\exceptions\http;


use app\exceptions\AbstractApiException;

class PageNotFoundException extends AbstractApiException
{
    protected $statusCode = 404;
}