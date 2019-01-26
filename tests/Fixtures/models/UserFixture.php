<?php
/**
 * Created by PhpStorm.
 * User: box
 * Date: 25.01.19
 * Time: 17:47
 */

namespace Tests\Fixtures\models;

use app\models\auth\User;
use Tests\Fixtures\ActiveFixture;

class UserFixture extends ActiveFixture
{
    public $dataFile = __DIR__.'/../data/users.php';

    public $tableName = User::TABLE_NAME;
}