<?php
/**
 * Created by PhpStorm.
 * User: box
 * Date: 30.01.19
 * Time: 12:26
 */

namespace Tests\Unit\services\auth;


use app\repositories\auth\UserRepository;
use app\services\auth\AuthService;
use Illuminate\Http\Request;
use Tests\Fixtures\models\UserFixture;
use Tests\Helpers\traits\LoginHelper;
use Tests\TestCase;

class AuthServiceTest extends TestCase
{
    use LoginHelper;

    /**
     * @var Request
     */
    private $request;

    /**
     * @var AuthService
     */
    private $service;

    /**
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function setUp()
    {
        parent::setUp();

        $this->request = Request::capture();
        $this->service = new AuthService($this->request, app()->make(UserRepository::class));
    }

    public function fixtures(): array
    {
        return [
            UserFixture::class,
        ];
    }

    public function testUser()
    {
        $this->setAuthUser('ASDFGHJKLzxcvbnmqwertyuiop');

        $user = $this->service->user();
        $this->assertEquals('username1', $user->username);
    }

    public function testIsAuth()
    {
        $this->login();
        $this->assertTrue($this->service->isAuth());
    }

    /**
     * @expectedException \Chiron\Http\Exception\Client\ForbiddenHttpException
     * @expectedExceptionMessage You do not have access to this page.
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function testGuard()
    {
        $service = new AuthService($this->request, app()->make(UserRepository::class));
        $service->guard();
    }

    /**
     * @param $username
     * @param $password
     * @param $expected
     * @dataProvider loginDataProvider
     * @runInSeparateProcess
     */
    public function testLogin($username, $password, $expected)
    {
        $this->assertEquals($expected, $this->service->login($username, $password));
    }

    public function loginDataProvider()
    {
        return [
            ['username1', 'NewVeryHardPassword1', true],
            ['username2', 'NewVeryHardPassword2', true],
            ['username3', 'ASasjdhasljk', false],
        ];
    }

    /**
     * @runInSeparateProcess
     */
    public function testLoginForAlreadyAuthorized()
    {
        $this->login();

        $this->assertFalse($this->service->login('username1', 'NewVeryHardPassword1'));
    }

}