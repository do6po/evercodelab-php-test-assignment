<?php
/**
 * Created by PhpStorm.
 * User: Boiko Sergii
 * Date: 26.01.2019
 * Time: 0:49
 */

namespace app\models\products;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/**
 * Class ProductCategory
 *
 * @property int $id
 * @property string $name
 *
 * @property Product[]|Collection $products
 *
 * @package app\models\products
 */
class ProductCategory extends Model
{
    const TABLE_NAME = 'product_categories';

    protected $fillable = ['name'];

    protected $visible = ['id', 'name'];

    public $timestamps = false;

    public function products()
    {
        return $this->belongsToMany(
            Product::class,
            ProductsCategories::TABLE_NAME,
            'product_cat_id',
            'product_id'
        );
    }
}