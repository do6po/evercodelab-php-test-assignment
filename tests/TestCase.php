<?php

namespace Tests;

use Illuminate\Database\Capsule\Manager as Capsule;
use PHPUnit\Framework\TestCase as BaseTestCase;
use Tests\Fixtures\traits\AssertsDbTrait;
use Tests\Fixtures\traits\CreateDbConnection;
use Tests\Fixtures\traits\CreateApplication;
use Tests\Fixtures\traits\FixtureTrait;

abstract class TestCase extends BaseTestCase
{
    use CreateApplication, CreateDbConnection, FixtureTrait, AssertsDbTrait;

    protected $app;

    /**
     * @var Capsule
     */
    protected $connection;

    public function setUp()
    {
        parent::setUp();

        $this->initApplication();
        $this->initFixtures();
    }

    protected function initApplication()
    {
        $this->app = $this->createApplication();
        $capsule = $this->createDb();
        $capsule->setContainer($this->app);
        $this->app->instance('db', $capsule);

        $this->connection = $capsule->getConnection();
    }

    public function tearDown()
    {
        parent::tearDown();

        $this->destroyFixtures();
    }
}
