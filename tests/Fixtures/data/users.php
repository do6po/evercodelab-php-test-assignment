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
        'password' => HashHelper::crypt('NewVeryHardPassword1'),
        'token' => 'ASDFGHJKLzxcvbnmqwertyuiop',
    ],
    [
        'username' => 'username2',
        'password' => HashHelper::crypt('NewVeryHardPassword2'),
        'token' => 'ZXCVBNMlkjhgfdsa0987654321',
    ],
];