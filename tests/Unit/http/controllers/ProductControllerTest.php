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
use Tests\Fixtures\models\ProductFixture;
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
            ProductFixture::class,
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
}