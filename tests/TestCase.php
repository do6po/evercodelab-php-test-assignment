<?php

namespace Tests;

use PHPUnit\Framework\TestCase as BaseTestCase;
use Tests\Fixtures\traits\AssertsDbTrait;
use Tests\Fixtures\traits\CreateDbConnection;
use Tests\Fixtures\traits\CreatesApplication;
use Tests\Fixtures\traits\FixtureTrait;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, CreateDbConnection, FixtureTrait, AssertsDbTrait;

    protected $app;
    protected $db;

    public function setUp()
    {
        parent::setUp();

        $this->app = $this->createApplication();
        $this->db = $this->createDbConnection();
        $this->initFixtures();
    }

    public function tearDown()
    {
        parent::tearDown();

        $this->destroyFixtures();
    }
}
