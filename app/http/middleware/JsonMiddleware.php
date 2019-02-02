<?php
/**
 * Created by PhpStorm.
 * User: Boiko Sergii
 * Date: 02.02.2019
 * Time: 23:26
 */

namespace app\http\middleware;

use app\exceptions\http\ContentTypeException;
use Closure;
use Illuminate\Http\Request;

class JsonMiddleware
{
    /**
     * @param Request $request
     * @param Closure $next
     * @return mixed
     * @throws ContentTypeException
     */
    public function handle(Request $request, Closure $next)
    {
        if (!$request->isJson()) {
            throw new ContentTypeException(
                ['error' => $message = 'Content-Type must be json'],
                $message
            );
        }

        return $next($request);
    }
}