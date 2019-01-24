<?php
/**
 * Created by PhpStorm.
 * User: box
 * Date: 24.01.19
 * Time: 12:37
 */

include __DIR__ . '/../vendor/autoload.php';

use Illuminate\Events\Dispatcher;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Routing\Router;
use Illuminate\Routing\UrlGenerator;

ini_set('display_errors', 1);

/** @var \Illuminate\Container\Container $app */
$app = require_once(__DIR__ . '/../bootstrap/app.php');

/** @var \Illuminate\Database\Capsule\Manager $db */
$db = require_once(__DIR__ . '/../bootstrap/db.php');

$app->singleton('db', $db);

$request = Request::capture();
$app->instance(Request::class, $request);

$events = new Dispatcher($app);
$router = new Router($events, $app);

require_once __DIR__ . '/../config/routes.php';

$redirect = new Redirector(new UrlGenerator($router->getRoutes(), $request));
$response = $router->dispatch($request);
$response->send();
