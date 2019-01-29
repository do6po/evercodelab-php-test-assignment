<?php
/**
 * Created by PhpStorm.
 * User: box
 * Date: 29.01.19
 * Time: 13:18
 */

namespace Tests\Unit\validators\auth;


use app\http\requests\auth\AuthRequest;
use Illuminate\Http\Request;
use JeffOchoa\ValidatorFactory;
use Tests\TestCase;

class AuthValidatorTest extends TestCase
{
    /**
     * @var AuthRequest
     */
    private $validator;

    /**
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function setUp()
    {
        parent::setUp();

        $this->validator = app()->make(AuthRequest::class);
    }

    /**
     * @param $postData
     * @param $expectedHasErrors
     * @param $expectedMessage
     * @dataProvider validateDataProvider
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function testValidate($postData, $expectedHasErrors, $expectedMessage)
    {
        $request = app()->make(Request::class);

        $request->setMethod('post');
        $request->replace($postData);

        $validator = new AuthRequest($request, new ValidatorFactory());
        $this->assertEquals($expectedHasErrors, $validator->hasErrors());
        $this->assertEquals($expectedMessage, $validator->errors()->toArray());
    }

    public function validateDataProvider()
    {
        return [
            [
                [],
                true,
                [
                    'username' => ['The username field is required.'],
                    'password' => ['The password field is required.'],
                ],
            ],
            [
                [
                    'username' => 'username',
                    'password' => 'password',
                ],
                false,
                []
            ],
            [
                [
                    'username' => 'us',
                    'password' => 'pass',
                ],
                true,
                [
                    'username' => ['The username must be at least 3 characters.'],
                    'password' => ['The password must be at least 8 characters.'],
                ]
            ]
        ];
    }
}