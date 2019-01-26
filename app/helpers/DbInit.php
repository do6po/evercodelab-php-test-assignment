<?php
/**
 * Created by PhpStorm.
 * User: box
 * Date: 24.01.19
 * Time: 18:01
 */

namespace app\helpers;

use Illuminate\Database\Capsule\Manager as Capsule;

class DbInit
{
    /**
     * @var array
     */
    private $dbConfig;

    private $capsule;

    public function __construct(array $dbConfig)
    {
        $this->dbConfig = $dbConfig;
        $this->init();
    }

    private function init()
    {
        $this->capsule = new Capsule;
        $this->capsule->addConnection($this->dbConfig);
        $this->capsule->setAsGlobal();
        $this->capsule->bootEloquent();
    }

    public function getCapsule(): Capsule
    {
        return $this->capsule;
    }
}