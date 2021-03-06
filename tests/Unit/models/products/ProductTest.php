<?php
/**
 * Created by PhpStorm.
 * User: Boiko Sergii
 * Date: 26.01.2019
 * Time: 1:04
 */

namespace Tests\Unit\models\products;

use app\models\products\Product;
use Tests\Fixtures\models\ProductFixture;
use Tests\TestCase;

class ProductTest extends TestCase
{
    public function fixtures(): array
    {
        return [
            ProductFixture::class,
        ];
    }

    public function testCreate()
    {
        $data = [
            'name' => 'product 5',
        ];

        $this->assertDatabaseMissing(Product::TABLE_NAME, $data);

        Product::create($data);

        $this->assertDatabaseHas(Product::TABLE_NAME, $data);
    }

    public function testDelete()
    {
        $data = [
            'name' => 'product 1',
        ];

        $this->assertDatabaseHas(Product::TABLE_NAME, $data);

        $product = Product::where('name', 'product 1')->first();
        $product->delete();

        $this->assertDatabaseMissing(Product::TABLE_NAME, $data);
    }
}