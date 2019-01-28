<?php
/**
 * Created by PhpStorm.
 * User: box
 * Date: 28.01.19
 * Time: 12:33
 */

namespace app\http\controllers;


class Controller
{
    protected function toJson($result)
    {
        return json_encode($result);
    }
}