<?php
/**
 * Created by PhpStorm.
 * User: Boiko Sergii
 * Date: 26.01.2019
 * Time: 1:30
 */

namespace Tests\Unit\models\products;

use app\models\products\ProductCategory;
use Tests\Fixtures\models\ProductCategoryFixture;
use Tests\TestCase;

class ProductCategoryTest extends TestCase
{
    public function fixtures(): array
    {
        return [
            ProductCategoryFixture::class,
        ];
    }

    public function testCreate()
    {
        $data = [
            'name' => 'product category 5',
        ];

        $this->assertDatabaseMissing(ProductCategory::TABLE_NAME, $data);

        ProductCategory::create($data);

        $this->assertDatabaseHas(ProductCategory::TABLE_NAME, $data);
    }

    public function testDelete()
    {
        $data = [
            'name' => 'product category 1',
        ];

        $this->assertDatabaseHas(ProductCategory::TABLE_NAME, $data);

        $productCategory = ProductCategory::where('name', 'product category 1')->first();
        $productCategory->delete();

        $this->assertDatabaseMissing(ProductCategory::TABLE_NAME, $data);
    }
}