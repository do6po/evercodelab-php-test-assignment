<?php
/**
 * Created by PhpStorm.
 * User: box
 * Date: 28.01.19
 * Time: 19:24
 */

namespace Tests\Unit\repositories\auth;


use app\repositories\auth\UserRepository;
use Tests\Fixtures\models\UserFixture;
use Tests\TestCase;

class UserRepositoryTest extends TestCase
{
    /**
     * @var UserRepository
     */
    private $repository;

    /**
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function setUp()
    {
        parent::setUp();

        $this->repository = app()->make(UserRepository::class);
    }

    public function fixtures(): array
    {
        return [
            UserFixture::class,
        ];
    }

    /**
     * @param $username
     * @param $token
     * @dataProvider findByUsernameOrTokenDataProvider
     */
    public function testFindByUsername($username, $token)
    {
        $user = $this->repository->findByUsername($username);

        $this->assertEquals($token, $user->token);
    }

    /**
     * @param $username
     * @param $token
     * @dataProvider findByUsernameOrTokenDataProvider
     */
    public function testFindByToken($username, $token)
    {
        $user = $this->repository->findByToken($token);

        $this->assertEquals($username, $user->username);
    }

    public function findByUsernameOrTokenDataProvider()
    {
        return [
            ['username1', 'ASDFGHJKLzxcvbnmqwertyuiop'],
            ['username2', 'ZXCVBNMlkjhgfdsa0987654321'],
        ];
    }
}