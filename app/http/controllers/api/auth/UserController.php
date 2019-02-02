<?php
/**
 * Created by PhpStorm.
 * User: box
 * Date: 28.01.19
 * Time: 17:51
 */

namespace app\http\controllers\api\auth;

use app\http\controllers\Controller;
use app\http\requests\auth\AuthRequest;
use app\services\auth\AuthService;

class UserController extends Controller
{
    /**
     * @var AuthService
     */
    private $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * @param AuthRequest $request
     * @return string
     * @throws \app\exceptions\auth\AuthException
     */
    public function login(AuthRequest $request)
    {
        $response = $this->authService->login(
            $request->get('username'),
            $request->get('password')
        );

        return $this->toJson($response);
    }

    /**
     * @return string
     */
    public function logout()
    {
        return $this->toJson($this->authService->logout());
    }
}