<?php
/**
 * Created by PhpStorm.
 * User: Boiko Sergii
 * Date: 28.01.2019
 * Time: 0:31
 */

/**
 * @param string $controllerClass
 * @param string $controllerMethod
 * @return string
 */
function action(string $controllerClass, string $controllerMethod)
{
    return sprintf('%s@%s', $controllerClass, $controllerMethod);
}