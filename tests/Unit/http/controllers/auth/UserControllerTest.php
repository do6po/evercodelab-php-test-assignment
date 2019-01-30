<?php
/**
 * Created by PhpStorm.
 * User: box
 * Date: 28.01.19
 * Time: 17:51
 */

namespace Tests\Unit\http\controllers\auth;


use app\http\controllers\auth\UserController;
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
     * @throws \Chiron\Http\Exception\Client\ForbiddenHttpException
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function testIndex()
    {
        $this->login();
        $this->createControllerInstance();
        $result = $this->controller->index();

        $this->assertJson($result);
        $this->assertJsonStringEqualsJsonString($result, User::all()->toJson());
    }

    /**
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @runInSeparateProcess
     */
    public function testLogin()
    {
        $postData = [
            'username' => 'username1',
            'password' => 'NewVeryHardPassword1',
        ];

        $this->request->setMethod('post');
        $this->request->replace($postData);

        $this->createControllerInstance();
        $result = $this->controller->login(new AuthRequest($this->request, new ValidatorFactory()));

        $this->assertJson($result);
        $this->assertJsonStringEqualsJsonString(json_encode(true), $result);
    }

    /**
     * @throws \Chiron\Http\Exception\Client\ForbiddenHttpException
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function testLogout()
    {
        $this->login();
        $this->createControllerInstance();
        $result = $this->controller->logout();
        $this->assertJson($result);

        $this->assertJsonStringEqualsJsonString(json_encode(true), $result);
    }

    /**
     * @throws \Chiron\Http\Exception\Client\ForbiddenHttpException
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @expectedException  \Chiron\Http\Exception\Client\ForbiddenHttpException
     * @runInSeparateProcess
     */
    public function testLogoutForNotAuthorized()
    {
        $this->createControllerInstance();
        $this->controller->logout();
    }

    /**
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    private function createControllerInstance()
    {
        $this->controller = app()->make(UserController::class);
    }
}