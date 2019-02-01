<?php
/**
 * Created by PhpStorm.
 * User: box
 * Date: 01.02.19
 * Time: 19:57
 */

namespace Tests\Unit\http\controllers\products;


use app\http\controllers\products\ProductCrudController;
use app\models\products\Product;
use app\models\products\ProductsCategories;
use Tests\Fixtures\models\ProductsCategoriesFixture;
use Tests\Helpers\traits\RequestGenerator;
use Tests\TestCase;

class ProductsCrudControllerTest extends TestCase
{
    use RequestGenerator;

    public function fixtures(): array
    {
        return [
            ProductsCategoriesFixture::class
        ];
    }

    /**
     * @param $id
     * @dataProvider deleteDataProvider
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @throws \app\exceptions\http\NotFoundHttpException
     */
    public function testDelete($id)
    {
        $controller = $this->makeController();

        $this->assertDatabaseHas(Product::TABLE_NAME, [
            'id' => $id
        ]);

        $this->assertDatabaseHas(ProductsCategories::TABLE_NAME, [
            'product_id' => $id
        ]);

        $result = $controller->delete($id);
        $this->assertJsonStringEqualsJsonString(json_encode(true), $result);

        $this->assertDatabaseMissing(Product::TABLE_NAME, [
            'id' => $id
        ]);

        $this->assertDatabaseMissing(ProductsCategories::TABLE_NAME, [
            'product_id' => $id
        ]);
    }

    public function deleteDataProvider()
    {
        return [
            [1],
            [2],
            [3],
            [4],
        ];
    }

    /**
     * @return mixed
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    protected function makeController(): ProductCrudController
    {
        $controller = app()->make(ProductCrudController::class);
        return $controller;
    }
}