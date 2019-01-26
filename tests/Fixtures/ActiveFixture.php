<?php
/**
 * Created by PhpStorm.
 * User: box
 * Date: 25.01.19
 * Time: 18:51
 */

namespace Tests\Fixtures;

use Illuminate\Database\Capsule\Manager as Capsule;

/**
 * Class ActiveFixture
 *
 * @property Capsule $db
 *
 * @package Tests\Fixtures
 */
class ActiveFixture
{
    /**
     * @var string
     */
    public $tableName;

    /**
     * @var string
     */
    public $dataFile;

    /**
     * @var ActiveFixture[]
     */
    public $dependencies = [];

    /**
     * @return mixed
     */
    public function getData()
    {
        return require $this->dataFile;
    }

    public function getDependencies(): array
    {
        return $this->dependencies;
    }
}