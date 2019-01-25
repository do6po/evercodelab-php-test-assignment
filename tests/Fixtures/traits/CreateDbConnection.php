<?php
/**
 * Created by PhpStorm.
 * User: box
 * Date: 25.01.19
 * Time: 13:03
 */

namespace Tests\Fixtures\traits;

use Illuminate\Database\Capsule\Manager as Capsule;

trait CreateDbConnection
{
    /**
     * @return Capsule
     */
    public function createDbConnection()
    {
        return require_once(__DIR__ . '/../../../bootstrap/db_test.php');
    }
}