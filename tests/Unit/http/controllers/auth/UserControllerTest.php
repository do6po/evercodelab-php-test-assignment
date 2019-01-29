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
     * @runInSeparateProcess
     */
    public function testLogin()
    {
        $postData = [
            'username' => 'username1',
            'password' => 'NewVeryHardPassword1',
        ];

        $request = Request::capture();
        $request->setMethod('post');
        $request->replace($postData);

        $result = $this->controller->login(new AuthRequest($request, new ValidatorFactory()));

        $this->assertJson($result);
        $this->assertJsonStringEqualsJsonString(json_encode(true), $result);
    }
}