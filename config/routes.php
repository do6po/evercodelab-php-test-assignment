<?php
/**
 * Created by PhpStorm.
 * User: box
 * Date: 24.01.19
 * Time: 17:31
 */

use app\exceptions\http\NotFoundHttpException;
use app\http\controllers\api\auth\UserController;
use app\http\controllers\HomeController;
use app\http\controllers\api\products\ProductController;
use app\http\controllers\api\products\ProductCrudController;
use app\http\middleware\JsonMiddleware;
use Illuminate\Routing\Router;

/** @var $router Router */
#index
$router->get('/', action(HomeController::class, 'index'));

#authorisation

$router->middleware([JsonMiddleware::class])->group(function (Router $router) {
    $router->get('/api/users', action(UserController::class, 'index'));
    $router->post('/api/login', action(UserController::class, 'login'));
    $router->post('/api/logout', action(UserController::class, 'logout'));

#read
    $router->get('/api/categories', action(ProductController::class, 'categories'));
    $router->get('/api/category/{id}/products', action(ProductController::class, 'productsByCategoryId'));

#crud
    $router->post('/api/product/add', action(ProductCrudController::class, 'add'));
    $router->post('/api/category/add', action(ProductCrudController::class, 'addCategory'));

    $router->put('/api/product/{id}', action(ProductCrudController::class, 'edit'));
    $router->put('/api/category/{id}', action(ProductCrudController::class, 'editCategory'));

    $router->delete('/api/product/{id}', action(ProductCrudController::class, 'delete'));
    $router->delete('/api/category/{id}', action(ProductCrudController::class, 'deleteCategory'));
});


$router->any('{all}', function () {
    throw new NotFoundHttpException([
        'error' => $message = 'Page not found!'
    ], $message);
});