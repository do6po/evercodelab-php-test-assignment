<?php
/**
 * Created by PhpStorm.
 * User: box
 * Date: 24.01.19
 * Time: 19:03
 */

namespace tests\Unit\models\auth;

use app\helpers\HashHelper;
use app\models\auth\User;
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
            'token' => HashHelper::generate(),
        ];

        $this->assertDatabaseMissing(User::TABLE_NAME, $data);

        User::create($data);

        $this->assertDatabaseHas(User::TABLE_NAME, $data);
    }

    public function testDelete()
    {
        $data = [
            'username' => 'username1',
            'password' => 'NewVeryHardPassword1',
        ];

        $this->assertDatabaseHas(User::TABLE_NAME, $data);

        $user = User::where('username', 'username1')->first();
        $user->delete();

        $this->assertDatabaseMissing(User::TABLE_NAME, $data);
    }
}