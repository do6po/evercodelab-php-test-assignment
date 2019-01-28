<?php
/**
 * Created by PhpStorm.
 * User: box
 * Date: 24.01.19
 * Time: 19:40
 */

namespace database\migrations;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Builder;
use Phinx\Migration\AbstractMigration;

abstract class MigrationAbstract extends AbstractMigration
{
    /**
     * @var Capsule
     */
    public $capsule;

    /**
     * @var Builder
     */
    public $schema;

    public function init()
    {
        $this->capsule = new Capsule;
        $this->capsule->addConnection($this->getConfig());

        $this->capsule->bootEloquent();
        $this->capsule->setAsGlobal();
        $this->schema = $this->capsule->schema();
    }

    public function getConfig()
    {
        if ($this->environment === 'test') {
            return require __DIR__ . '/../../config/db_test.php';
        }

        return require __DIR__ . '/../../config/db.php';
    }
}