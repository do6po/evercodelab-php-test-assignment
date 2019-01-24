<?php
/**
 * Created by PhpStorm.
 * User: box
 * Date: 24.01.19
 * Time: 18:30
 */

use Illuminate\Container\Container;

$app = Container::getInstance();
$app->singleton('app', Container::class);

return $app;