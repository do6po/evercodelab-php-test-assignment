<?php
/**
 * Created by PhpStorm.
 * User: Boiko Sergii
 * Date: 26.01.2019
 * Time: 1:30
 */

namespace Tests\Unit\products;

use app\models\products\ProductCategory;
use Tests\Fixtures\models\ProductCategoryFixture;
use Tests\TestCase;

class ProductCategoryTest extends TestCase
{
    public function fixtures()
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

        $this->assertDatabaseMissing(ProductCategory::class, $data);

        ProductCategory::create($data);

        $this->assertDatabaseHas(ProductCategory::class, $data);
    }

    public function testDelete()
    {
        $data = [
            'name' => 'product category 1',
        ];

        $this->assertDatabaseHas(ProductCategory::class, $data);

        $productCategory = ProductCategory::where('name', 'product category 1')->first();
        $productCategory->delete();

        $this->assertDatabaseMissing(ProductCategory::class, $data);
    }
}