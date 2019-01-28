<?php
/**
 * Created by PhpStorm.
 * User: box
 * Date: 24.01.19
 * Time: 19:40
 */

namespace database\migrations;

use database\traits\DbConfigTrait;
use Phinx\Migration\AbstractMigration;

abstract class MigrationAbstract extends AbstractMigration
{
    use DbConfigTrait;
}