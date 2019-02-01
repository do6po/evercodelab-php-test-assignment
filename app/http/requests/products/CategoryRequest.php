<?php
/**
 * Created by PhpStorm.
 * User: box
 * Date: 01.02.19
 * Time: 19:36
 */

namespace app\http\requests\products;


use app\http\requests\AbstractRequest;

class CategoryRequest extends AbstractRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'min:3',],
        ];
    }
}