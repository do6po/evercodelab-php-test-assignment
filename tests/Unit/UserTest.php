<?php
/**
 * Created by PhpStorm.
 * User: box
 * Date: 24.01.19
 * Time: 19:03
 */

use app\models\User;
use Tests\Fixtures\Models\UserFixture;
use Tests\TestCase;


class UserTest extends TestCase
{
    public function fixtures(): array
    {
        return [
            UserFixture::class,
        ];
    }

    public function testCreate()
    {
        $username = 'NewUsername';

        $this->assertDatabaseMissing(User::class, [
            'username' => $username,
        ]);

        $user = new User();
        $user->username = $username;
        $user->password = 'NewHardPassword!';
        $user->generateKey();

        $user->save();

        $this->assertDatabaseHas(User::class, [
            'username' => $username,
        ]);
    }

}