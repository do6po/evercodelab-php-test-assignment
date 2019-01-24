<?php
/**
 * Created by PhpStorm.
 * User: box
 * Date: 24.01.19
 * Time: 12:37
 */

include __DIR__ . '/../vendor/autoload.php';

use app\helpers\DbInit;
use Illuminate\Container\Container;
use Illuminate\Events\Dispatcher;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Routing\Router;
use Illuminate\Routing\UrlGenerator;

ini_set('display_errors',1);

$db = new DbInit(require  __DIR__ . '/../config/db.php');

$container = new Container;
$container->singleton('app', Container::class);

$request = Request::capture();
$container->instance(Request::class, $request);

$events = new Dispatcher($container);
$router = new Router($events, $container);

require_once __DIR__ . '/../config/routes.php';

$redirect = new Redirector(new UrlGenerator($router->getRoutes(), $request));
$response = $router->dispatch($request);
$response->send();
