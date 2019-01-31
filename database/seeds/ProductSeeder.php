<?php

use app\helpers\HashHelper;
use app\models\products\Product;
use app\models\products\ProductCategory;
use app\models\products\ProductsCategories;
use database\traits\DbConfigTrait;
use Phinx\Seed\AbstractSeed;

class ProductSeeder extends AbstractSeed
{
    use DbConfigTrait;

    public function run()
    {
        $products = require __DIR__ . '/../../tests/Fixtures/data/products.php';
        $this->batchFill(Product::TABLE_NAME, $products);

        $categories = require __DIR__ . '/../../tests/Fixtures/data/product_categories.php';
        $this->batchFill(ProductCategory::TABLE_NAME, $categories);

        $productsCategories = require __DIR__ . '/../../tests/Fixtures/data/products_categories.php';
        $this->batchFill(ProductsCategories::TABLE_NAME, $productsCategories);
    }

    protected function batchFill(string $tableName, $fixtures) {
        foreach ($fixtures as $data) {
            $this->fill($tableName, $data);
        }
    }

    protected function fill(string $tableName, array $data)
    {
        $this->capsule->getConnection()
            ->table($tableName)
            ->insert($data);
    }
}
