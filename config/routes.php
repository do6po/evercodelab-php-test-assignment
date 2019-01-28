<?php
/**
 * Created by PhpStorm.
 * User: box
 * Date: 24.01.19
 * Time: 17:31
 */

use app\http\controllers\products\ProductController;
use Illuminate\Routing\Router;

/** @var $router Router */
$router->get('/', action(ProductController::class, 'index'));

$router->get('/auth', action(ProductController::class, 'index'));
$router->post('/login', action(ProductController::class, 'login'));