<?php
/**
 * Created by PhpStorm.
 * User: box
 * Date: 28.01.19
 * Time: 12:17
 */

namespace Tests\Unit\http\controllers;


use app\http\controllers\products\ProductController;
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

    public function testIndex()
    {
        $result = $this->controller->index();
        $this->assertJson($result);

        $this->assertJsonStringEqualsJsonString(Product::all()->toJson(), $result);
    }

    public function testGetByCategoryId()
    {
        $categoryId = 1;
        $result = $this->controller->getByCategoryId($categoryId);
        $this->assertJson($result);
        $category = ProductCategory::find($categoryId);
        /** @var Collection $products */
        $products = $category->products;
        $this->assertJsonStringEqualsJsonString($products->toJson(), $result);
    }
}