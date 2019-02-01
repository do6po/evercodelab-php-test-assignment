<?php
/**
 * Created by PhpStorm.
 * User: box
 * Date: 01.02.19
 * Time: 17:57
 */

namespace Tests\Unit\http\requests\product;


use app\exceptions\AbstractApiException;
use app\http\requests\products\ProductRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\DatabasePresenceVerifier;
use JeffOchoa\ValidatorFactory;
use Tests\Fixtures\models\ProductsCategoriesFixture;
use Tests\Helpers\traits\RequestGenerator;
use Tests\TestCase;

class ProductRequestTest extends TestCase
{
    use RequestGenerator;

    public function fixtures(): array
    {
        return [
            ProductsCategoriesFixture::class
        ];
    }

    /**
     * @param $data
     * @param $expectMessages
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @dataProvider validationDataProvider
     */
    public function testValidation($data, $expectMessages)
    {
        $request = $this->genRequest($data);

        $factory = app()->make(ValidatorFactory::class);

        try {
            new ProductRequest($request, $factory);
        } catch (AbstractApiException $exception) {
            $this->assertEquals($expectMessages, $exception->getMessages());
        }
    }

    public function validationDataProvider()
    {
        return [
            [['name' => '',], ['name' => ['The name field is required.']]],
            [['name' => 'Pr',], ['name' => ['The name must be at least 3 characters.']]],
            [
                [
                    'name' => 'Product name 10',
                    'categoryIds' => [1, 2, 3, 10],
                ],
                [
                    'categoryIds' => ['The selected category ids is invalid.'],
                ]
            ]
        ];
    }
}