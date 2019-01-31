<?php
/**
 * Created by PhpStorm.
 * User: box
 * Date: 24.01.19
 * Time: 17:31
 */

use app\http\controllers\auth\UserController;
use app\http\controllers\HomeController;
use app\http\controllers\products\ProductController;
use Illuminate\Routing\Router;

/** @var $router Router */
$router->get('/', action(HomeController::class, 'index'));

$router->get('/users', action(UserController::class, 'index'));
$router->post('/login', action(UserController::class, 'login'));
$router->post('/logout', action(UserController::class, 'logout'));