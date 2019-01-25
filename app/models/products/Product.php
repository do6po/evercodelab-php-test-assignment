<?php
/**
 * Created by PhpStorm.
 * User: Boiko Sergii
 * Date: 26.01.2019
 * Time: 0:48
 */

namespace app\models\products;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Product
 *
 * @property int $id
 * @property string $name
 *
 * @package app\models\products
 */
class Product extends Model
{
    protected $fillable = ['name'];

    public $timestamps = false;
}