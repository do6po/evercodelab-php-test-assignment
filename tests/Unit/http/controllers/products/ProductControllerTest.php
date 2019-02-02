<?php
/**
 * Created by PhpStorm.
 * User: box
 * Date: 28.01.19
 * Time: 12:17
 */

namespace Tests\Unit\http\controllers\products;


use app\http\controllers\api\products\ProductController;
use app\models\products\Product;
use app\models\products\ProductCategory;
use Illuminate\Support\Collection;
use Tests\Fixtures\models\ProductsCategoriesFixture;
use Tests\TestCase;

class ProductControllerTest extends TestCase
{
    /**
     * @var ProductController
     */
    protected $controller;

    public function fixtures(): array
    {
        return [
            ProductsCategoriesFixture::class,
        ];
    }

    /**
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function setUp()
    {
        parent::setUp();
        $this->controller = app()->make(ProductController::class);
    }

    /**
     * @runInSeparateProcess
     */
    public function testCategories()
    {
        $result = $this->controller->categories();
        $this->assertJson($result);

        $this->assertJsonStringEqualsJsonString(ProductCategory::all()->toJson(), $result);
    }

    /**
     * @param $categoryId
     * @dataProvider productsByCategoryIdDataProvider
     * @runInSeparateProcess
     */
    public function testProductsByCategoryId($categoryId)
    {
        $result = $this->controller->productsByCategoryId($categoryId);
        $category = ProductCategory::find($categoryId);

        $this->assertJsonStringEqualsJsonString($category->products->toJson(), $result);
    }

    public function productsByCategoryIdDataProvider()
    {
        return [
            [1],
            [2],
            [3],
            [4],
        ];
    }
}