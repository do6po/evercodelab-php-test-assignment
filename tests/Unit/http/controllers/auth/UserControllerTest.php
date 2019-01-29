<?php
/**
 * Created by PhpStorm.
 * User: box
 * Date: 28.01.19
 * Time: 17:51
 */

namespace Tests\Unit\http\controllers\auth;


use app\http\controllers\auth\UserController;
use app\models\auth\User;
use Illuminate\Http\Request;
use Tests\Fixtures\models\UserFixture;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    /**
     * @var UserController
     */
    private $controller;

    /**
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function setUp()
    {
        parent::setUp();

        $this->controller = app()->make(UserController::class);
    }

    public function fixtures(): array
    {
        return [
            UserFixture::class,
        ];
    }

    public function testIndex()
    {
        $result = $this->controller->index();

        $this->assertJson($result);
        $this->assertJsonStringEqualsJsonString($result, User::all()->toJson());
    }

    /**
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function testLogin()
    {
        $username = 'username1';
        $password = 'NewVeryHardPassword1';
        $postData = [
            'username' => $username,
            'password' => $password,
        ];


        $request = app()->make(Request::class);
        $request->setMethod('post');
        $request->replace($postData);

        $result = $this->controller->login($request);

        $this->assertJson($result);

        $this->assertJsonStringEqualsJsonString(
            json_encode(['token' => 'ASDFGHJKLzxcvbnmqwertyuiop']),
            $result
        );
    }
}