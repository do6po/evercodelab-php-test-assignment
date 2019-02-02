<?php
/**
 * Created by PhpStorm.
 * User: box
 * Date: 30.01.19
 * Time: 12:26
 */

namespace Tests\Unit\services\auth;


use app\exceptions\auth\AuthException;
use app\models\auth\User;
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
     * @expectedException \app\exceptions\auth\UnauthorizedHttpException
     * @expectedExceptionMessage You unauthorized!
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
     * @throws \app\exceptions\auth\AuthException
     * @runInSeparateProcess
     * @dataProvider loginDataProvider
     */
    public function testLogin($username, $password)
    {
        $result = $this->service->login($username, $password);
        /** @var User $user */
        $user = User::where('username', $username)->first();

        $this->assertEquals(['token' => $user->getToken()], $result);
    }

    public function loginDataProvider()
    {
        return [
            ['username1', 'NewVeryHardPassword1'],
            ['username2', 'NewVeryHardPassword2'],
        ];
    }

    /**
     * @throws \app\exceptions\auth\AuthException
     * @expectedException \app\exceptions\auth\AuthException
     */
    public function testLoginWithWrongData()
    {
        $this->service->login('username3', 'IncorrectPassword');
    }

    /**
     * @runInSeparateProcess
     */
    public function testLoginForAlreadyAuthorized()
    {
        $this->login();

        $this->assertDatabaseHas(User::TABLE_NAME, [
            'token' => 'ZXCVBNMlkjhgfdsa0987654321'
        ]);
        try {
            $this->assertFalse($this->service->login('username1', 'NewVeryHardPassword1'));
        } catch (AuthException $exception) {
            $this->assertEquals(['username' => 'Incorrect credentials!'], $exception->getMessages());
        }

        $this->assertDatabaseHas(User::TABLE_NAME, [
            'token' => 'ZXCVBNMlkjhgfdsa0987654321'
        ]);
    }

    /**
     * @runInSeparateProcess
     */
    public function testLoginForUserWithoutToken()
    {
        $username = 'username3';
        /** @var User $user */
        $user = User::where('username', $username)->first();
        $this->assertEmpty($user->token);

        $response = $this->service->login($username, 'NewVeryHardPassword3');
        $user = User::where('username', $username)->first();

        $this->assertEquals(
            ['token' => $user->getToken()],
            $response
        );

        /** @var User $user */
        $this->assertNotEmpty($user->token);
    }

    /**
     * @runInSeparateProcess
     */
    public function testLogout()
    {
        $this->login();

        $this->assertEquals(
            ['message' => 'Successfully logged out'],
            $this->service->logout()
        );
    }

    public function testLogoutForNotAuthorized()
    {
        $this->assertFalse($this->service->logout());
    }
}