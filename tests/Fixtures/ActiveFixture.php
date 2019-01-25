<?php
/**
 * Created by PhpStorm.
 * User: box
 * Date: 25.01.19
 * Time: 18:51
 */

namespace Tests\Fixtures;


use Illuminate\Database\Eloquent\Model;

class ActiveFixture
{
    /**
     * @var string
     */
    public $dataFile;

    /**
     * @var Model
     */
    public $modelClass;

    public function unload()
    {
        $this->modelClass::truncate();
    }

    public function load()
    {
        $fixtures = require $this->dataFile;

        $this->modelClass::insert($fixtures);
    }
}