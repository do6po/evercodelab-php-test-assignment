<?php

namespace Tests;

use LaravelFlux\Fixture\Traits\FixtureTrait;
use PHPUnit\Framework\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, CreateDbConnection, FixtureTrait;

    protected $app;
    protected $db;

    /**
     * @throws \LaravelFlux\Fixture\Exceptions\InvalidConfigException
     */
    public function setUp()
    {
        parent::setUp();

        $this->app = $this->createApplication();
        $this->db = $this->createDbConnection();
        $this->initFixtures();
    }
}
