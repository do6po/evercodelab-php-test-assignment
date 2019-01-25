<?php
/**
 * Created by PhpStorm.
 * User: box
 * Date: 24.01.19
 * Time: 19:03
 */

use app\helpers\HashHelper;
use app\models\User;
use Tests\Fixtures\models\UserFixture;
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
        $data = [
            'username' => 'NewUsername',
            'password' => 'NewHardPassword!',
            'key' => HashHelper::random(),
        ];

        $this->assertDatabaseMissing(User::class, $data);

        User::create($data);

        $this->assertDatabaseHas(User::class, $data);
    }

    public function testDelete()
    {
        $data = [
            'username' => 'username1',
            'password' => 'NewVeryHardPassword1',
        ];

        $this->assertDatabaseHas(User::class, $data);

        $user = User::where('username', 'username1')->first();
        $user->delete();

        $this->assertDatabaseMissing(User::class, $data);

    }
}