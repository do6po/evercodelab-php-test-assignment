<?php

namespace Tests;

use PHPUnit\Framework\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected $app;

    public function setUp()
    {
        parent::setUp();

        $this->app = $this->createApplication();
    }
}
