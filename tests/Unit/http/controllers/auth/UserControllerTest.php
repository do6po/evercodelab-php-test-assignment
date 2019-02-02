<?php
/**
 * Created by PhpStorm.
 * User: box
 * Date: 28.01.19
 * Time: 17:51
 */

namespace Tests\Unit\http\controllers\auth;


use app\http\controllers\api\auth\UserController;
use app\http\requests\auth\AuthRequest;
use app\models\auth\User;
use Illuminate\Http\Request;
use JeffOchoa\ValidatorFactory;
use Tests\Fixtures\models\UserFixture;
use Tests\Helpers\traits\LoginHelper;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use LoginHelper;

    /**
     * @var UserController
     */
    private $controller;

    /**
     * @var Request
     */
    private $request;

    /**
     *
     */
    public function setUp()
    {
        parent::setUp();

        $this->request = Request::capture();
    }

    public function fixtures(): array
    {
        return [
            UserFixture::class,
        ];
    }

    /**
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @throws \app\exceptions\auth\AuthException
     * @throws \app\exceptions\validations\RequestValidationException
     * @runInSeparateProcess
     */
    public function testLogin()
    {
        $username = 'username1';
        $postData = [
            'username' => $username,
            'password' => 'NewVeryHardPassword1',
        ];

        $this->request->setMethod('post');
        $this->request->replace($postData);

        $this->createControllerInstance();
        $result = $this->controller->login(new AuthRequest($this->request, new ValidatorFactory()));

        /** @var User $user */
        $user = User::where('username', $username)->first();

        $this->assertJson($result);
        $this->assertJsonStringEqualsJsonString(json_encode(['token' => $user->getToken()]), $result);
    }

    /**
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @runInSeparateProcess
     */
    public function testLogout()
    {
        $this->login();
        $this->createControllerInstance();
        $result = $this->controller->logout();
        $this->assertJson($result);

        $this->assertJsonStringEqualsJsonString(
            json_encode(['message' => 'Successfully logged out']),
            $result
        );
    }

    /**
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    private function createControllerInstance()
    {
        $this->controller = app()->make(UserController::class);
    }
}