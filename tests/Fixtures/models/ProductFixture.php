<?php
/**
 * Created by PhpStorm.
 * User: Boiko Sergii
 * Date: 26.01.2019
 * Time: 1:05
 */

namespace Tests\Fixtures\models;

use app\models\products\Product;
use Tests\Fixtures\ActiveFixture;

class ProductFixture extends ActiveFixture
{
    public $dataFile = __DIR__ . '/../data/products.php';

    public $modelClass = Product::class;
}