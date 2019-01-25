<?php
/**
 * Created by PhpStorm.
 * User: box
 * Date: 25.01.19
 * Time: 17:48
 */

use app\helpers\HashHelper;

return [
    [
        'username' => 'username1',
        'password' => 'NewVeryHardPassword1',
        'key' => HashHelper::generate(),
    ],
    [
        'username' => 'username2',
        'password' => 'NewVeryHardPassword2',
        'key' => HashHelper::generate(),
    ],
];