<?php

namespace Tests\Fixtures\traits;

use Illuminate\Container\Container;

trait CreatesApplication
{
    /**
     * @return Container
     */
    public function createApplication()
    {
        return require __DIR__ . '/../../../bootstrap/app.php';
    }
}