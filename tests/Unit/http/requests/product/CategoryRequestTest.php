<?php
/**
 * Created by PhpStorm.
 * User: box
 * Date: 01.02.19
 * Time: 19:38
 */

namespace Tests\Unit\http\requests\product;


use app\exceptions\AbstractApiException;
use app\http\requests\products\CategoryRequest;
use JeffOchoa\ValidatorFactory;
use Tests\Fixtures\models\ProductsCategoriesFixture;
use Tests\Helpers\traits\RequestGenerator;
use Tests\TestCase;

class CategoryRequestTest extends TestCase
{
    use RequestGenerator;

    public function fixtures(): array
    {
        return [
            ProductsCategoriesFixture::class,
        ];
    }

    /**
     * @param $data
     * @param $expectMessages
     * @dataProvider validationDataProvider
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function testValidation($data, $expectMessages)
    {
        $request = $this->genRequest($data);
        $factory = app()->make(ValidatorFactory::class);

        try {
            new CategoryRequest($request, $factory);
        } catch (AbstractApiException $exception) {
            $this->assertEquals($expectMessages, $exception->getMessages());
        }
    }

    public function validationDataProvider()
    {
        return [
            [
                ['name' => ''],
                ['name' => ['The name field is required.']],
            ],
            [
                ['name' => 'Ca'],
                ['name' => ['The name must be at least 3 characters.']],
            ],
        ];
    }
}