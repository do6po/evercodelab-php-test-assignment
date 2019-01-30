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
use Symfony\Component\HttpFoundation\HeaderBag;
use Tests\Fixtures\models\UserFixture;
use Tests\TestCase;

class AuthServiceTest extends TestCase
{
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
        $this->setAuthUser('ZXCVBNMlkjhgfdsa0987654321');

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
        $this->setAuthUser('ZXCVBNMlkjhgfdsa0987654321');

        $this->assertFalse($this->service->login('username1', 'NewVeryHardPassword1'));
    }

    private function setAuthUser(string $headerAuthValue)
    {
        $headerAuthKey = 'Authorization';

        $this->request->headers = new HeaderBag([$headerAuthKey => $headerAuthValue,]);
        $this->assertTrue($this->request->hasHeader($headerAuthKey));
    }
}