<?php

namespace Tests\Fixtures\traits;

use Illuminate\Container\Container;

trait CreateApplication
{
    /**
     * @return Container
     */
    public function createApplication()
    {
        return bootstrap('app.php');
    }
}
