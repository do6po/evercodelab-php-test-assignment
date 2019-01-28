<?php
/**
 * Created by PhpStorm.
 * User: box
 * Date: 28.01.19
 * Time: 17:24
 */

namespace Tests\Unit\http\controllers;


use app\http\controllers\products\ProductCategoryController;
use app\models\products\ProductCategory;
use Tests\Fixtures\models\ProductsCategoriesFixture;
use Tests\TestCase;

class ProductCategoryControllerTest extends TestCase
{
    /**
     * @var ProductCategoryController
     */
    private $controller;

    /**
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function setUp()
    {
        parent::setUp();
        $this->controller = app()->make(ProductCategoryController::class);
    }

    public function fixtures(): array
    {
        return [
            ProductsCategoriesFixture::class,
        ];
    }

    public function testIndex()
    {
        $result = $this->controller->index();

        $this->assertJson($result);

        $categories = ProductCategory::all();
        $this->assertJsonStringEqualsJsonString($categories->toJson(), $result);
    }
}