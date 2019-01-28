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
            'password' => HashHelper::crypt('NewHardPassword!'),
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
            'password' => HashHelper::crypt('NewVeryHardPassword1'),
        ];

        $this->assertDatabaseHas(User::TABLE_NAME, $data);
        $user = $this->findUserByUsername('username1');
        $user->delete();

        $this->assertDatabaseMissing(User::TABLE_NAME, $data);
    }

    /**
     * @param $username
     * @param $password
     * @param $expected
     * @dataProvider comparePasswordDataProvider
     */
    public function testComparePassword($username, $password, $expected)
    {
        $user = $this->findUserByUsername($username);

        $this->assertEquals($expected, $user->comparePassword($password));
    }

    public function comparePasswordDataProvider()
    {
        return [
            ['username1', 'password1', false],
            ['username1', 'NewVeryHardPassword1', true],
        ];
    }

    /**
     * @param $username
     * @return User|null
     */
    private function findUserByUsername($username)
    {
        return User::where('username', $username)->first();
    }
}