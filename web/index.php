<?php
/**
 * Created by PhpStorm.
 * User: box
 * Date: 24.01.19
 * Time: 12:37
 */

include __DIR__ . '/../vendor/autoload.php';

use app\exceptions\ExceptionWrapper;
use Illuminate\Events\Dispatcher;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Routing\Router;
use Illuminate\Routing\UrlGenerator;

ini_set('display_errors', 1);

$app = bootstrap('app.php');
$app->instance('db', bootstrap('db.php'));

$request = Request::capture();
$app->instance(Request::class, $request);

$events = new Dispatcher($app);
$router = new Router($events, $app);

require_once __DIR__ . '/../config/routes.php';

$redirect = new Redirector(new UrlGenerator($router->getRoutes(), $request));

$wrapper = new ExceptionWrapper($router, $request);
$wrapper->wrap();
