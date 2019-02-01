<?php
/**
 * Created by PhpStorm.
 * User: box
 * Date: 25.01.19
 * Time: 13:03
 */

namespace Tests\Fixtures\traits;

use app\helpers\DbInit;
use Illuminate\Database\Capsule\Manager as Capsule;

trait CreateDbConnection
{
    /**
     * @return Capsule
     */
    public function createDb()
    {
        return db('db_test.php');
    }
}