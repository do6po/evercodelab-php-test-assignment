<?php
/**
 * Created by PhpStorm.
 * User: box
 * Date: 31.01.19
 * Time: 17:20
 */

namespace app\exceptions;


use Illuminate\Http\Request;
use Illuminate\Routing\Router;

class ExceptionWrapper
{
    /**
     * @var Router
     */
    protected $router;

    /**
     * @var Request
     */
    protected $request;

    public function __construct(Router $router, Request $request)
    {
        $this->router = $router;
        $this->request = $request;
    }


    public function wrap()
    {
        try {
            $response = $this->router->dispatch($this->request);
            $response->send();
        } catch (AbstractApiException $exception) {
            http_response_code($exception->getStatusCode());
            header('Content-Type: application/json');
            echo json_encode($exception->getMessages());
            return;
        } catch (\Exception $exception) {
            http_response_code($exception->getCode());
            header('Content-Type: application/json');
            echo json_encode($exception->getMessage());
        }
    }
}