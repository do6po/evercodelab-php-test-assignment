<?php
/**
 * Created by PhpStorm.
 * User: box
 * Date: 24.01.19
 * Time: 17:31
 */

use app\exceptions\http\PageNotFoundException;
use app\http\controllers\auth\UserController;
use app\http\controllers\HomeController;
use app\http\controllers\products\ProductController;
use app\http\controllers\products\ProductCrudController;
use Illuminate\Routing\Router;

/** @var $router Router */
#index
$router->get('/', action(HomeController::class, 'index'));

#authorisation
$router->get('/users', action(UserController::class, 'index'));
$router->post('/login', action(UserController::class, 'login'));
$router->post('/logout', action(UserController::class, 'logout'));

#read
$router->get('/categories', action(ProductController::class, 'categories'));
$router->get('/category/{id}/products', action(ProductController::class, 'productsByCategoryId'));

#crud
$router->post('/product/add', action(ProductCrudController::class, 'add'));




$router->any('{all}', function () {
    throw new PageNotFoundException([
        'error' => $message = 'Page not found!'
    ], $message);
});