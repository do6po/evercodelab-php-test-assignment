<?php
/**
 * Created by PhpStorm.
 * User: box
 * Date: 28.01.19
 * Time: 12:40
 */

namespace app\repositories\products;


use app\models\products\Product;
use Illuminate\Support\Collection;

class ProductRepository
{
    /**
     * @return Product[]|\Illuminate\Database\Eloquent\Collection
     */
    public function all()
    {
        return Product::all();
    }

    /**
     * @param int $id
     * @return Product|null
     */
    public function getById(int $id)
    {
        return Product::find($id);
    }

    /**
     * @param int $categoryId
     * @return Product[]|Collection
     */
    public function getByCategoryId(int $categoryId): Collection
    {
        return Product::whereHas(
            'categories',
            function ($query) use ($categoryId) {
                $query->whereId($categoryId);
            }
        )->get();
    }
}