<?php
/**
 * Created by PhpStorm.
 * User: box
 * Date: 01.02.19
 * Time: 19:05
 */

use Illuminate\Container\Container;
use Illuminate\Validation\DatabasePresenceVerifier;
use JeffOchoa\ValidatorFactory;

$app = app();

$app->bind(ValidatorFactory::class, function (Container $container) {
    $factory = new ValidatorFactory();
    $verifier = $container->make(DatabasePresenceVerifier::class);
    $factory->factory->setPresenceVerifier($verifier);

    return $factory;
});

$app->bind(DatabasePresenceVerifier::class, function (Container $container) {
    $databaseManager = $container->make('db')->getDatabaseManager();
    return new DatabasePresenceVerifier($databaseManager);
});

return $app;