<?php
/**
 * Created by PhpStorm.
 * User: box
 * Date: 31.01.19
 * Time: 12:56
 */

namespace app\http\requests\products;


use app\http\requests\AbstractRequest;

class ProductRequest extends AbstractRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'min:3'],
            'categoryIds' => ['array', 'exists:categories,id', 'nullable'],
        ];
    }
}