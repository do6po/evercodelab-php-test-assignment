<?php
/**
 * Created by PhpStorm.
 * User: box
 * Date: 28.01.19
 * Time: 12:40
 */

namespace app\repositories\products;


use app\models\products\Product;

class ProductRepository
{
    public function all()
    {
        return Product::all();
    }
}