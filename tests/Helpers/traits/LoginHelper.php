<?php
/**
 * Created by PhpStorm.
 * User: box
 * Date: 30.01.19
 * Time: 17:26
 */

namespace Tests\Helpers\traits;


use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\HeaderBag;

/**
 * Trait LoginHelper
 *
 * @property Request $request
 *
 * @package Tests\Helpers\traits
 */
trait LoginHelper
{
    private function login()
    {
        $this->setAuthUser('ZXCVBNMlkjhgfdsa0987654321');
    }

    private function setAuthUser(string $headerAuthValue)
    {
        $headerAuthKey = 'Authorization';

        $this->request->headers = new HeaderBag([$headerAuthKey => $headerAuthValue,]);

        app()->instance(Request::class, $this->request);
    }
}