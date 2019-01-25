<?php
/**
 * Created by PhpStorm.
 * User: box
 * Date: 24.01.19
 * Time: 18:36
 */

use app\helpers\DbInit;

return new DbInit(require  __DIR__ . '/../config/db_test.php');