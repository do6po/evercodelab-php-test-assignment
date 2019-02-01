<?php
/**
 * Created by PhpStorm.
 * User: box
 * Date: 01.02.19
 * Time: 18:00
 */

namespace Tests\Helpers\traits;


use Illuminate\Http\Request;

trait RequestGenerator
{
    /**
     * @param $data
     * @return Request
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    protected function genRequest(array $data)
    {
        /** @var Request $request */
        $request = app()->make(Request::class);
        return $request->replace($data);
    }
}