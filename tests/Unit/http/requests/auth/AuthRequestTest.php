<?php
/**
 * Created by PhpStorm.
 * User: box
 * Date: 29.01.19
 * Time: 13:18
 */

namespace Tests\Unit\validators\auth;


use app\exceptions\validations\RequestValidationException;
use app\http\requests\auth\AuthRequest;
use Illuminate\Http\Request;
use JeffOchoa\ValidatorFactory;
use Tests\Helpers\traits\RequestGenerator;
use Tests\TestCase;

class AuthRequestTest extends TestCase
{
    use RequestGenerator;

    /**
     * @param $postData
     * @param $expectedMessage
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @throws \app\exceptions\validations\RequestValidationException
     * @dataProvider validateDataProvider
     */
    public function testValidateCorrectData($postData, $expectedMessage)
    {
        $request = $this->genRequest($postData);

        $validator = new AuthRequest($request, new ValidatorFactory());
        $this->assertEquals($expectedMessage, $validator->errors()->toArray());
    }

    public function validateDataProvider()
    {
        return [
            [
                [
                    'username' => 'username',
                    'password' => 'password',
                ],
                []
            ],

        ];
    }

    /**
     * @param $postData
     * @param $expectedMessage
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @dataProvider validateWithErrorDataProvider
     */
    public function testValidateWithErrorDataProvider($postData, $expectedMessage)
    {
        $request = $this->genRequest($postData);

        try {
            new AuthRequest($request, new ValidatorFactory());
        } catch (RequestValidationException $exception) {
            $this->assertEquals($expectedMessage, $exception->getMessages());
        }
    }

    public function validateWithErrorDataProvider()
    {
        return [
            [
                [
                    'username' => 'us',
                    'password' => 'pass',
                ],
                [
                    'username' => ['The username must be at least 3 characters.'],
                    'password' => ['The password must be at least 8 characters.'],
                ]
            ],
            [
                [],
                [
                    'username' => ['The username field is required.'],
                    'password' => ['The password field is required.'],
                ],
            ],
        ];
    }


}