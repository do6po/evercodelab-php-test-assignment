<?php
/**
 * Created by PhpStorm.
 * User: box
 * Date: 28.01.19
 * Time: 19:20
 */

namespace app\services\auth;

use app\repositories\auth\UserRepository;
use Chiron\Http\Exception\Client\ForbiddenHttpException;
use Illuminate\Http\Request;

class AuthService
{
    /**
     * @var string
     */
    protected $headerAuthKey = 'Authorization';

    /**
     * @var UserRepository
     */
    protected $userRepository;

    /**
     * @var Request
     */
    protected $request;

    /**
     * AuthService constructor.
     * @param Request $request
     * @param UserRepository $userRepository
     */
    public function __construct(Request $request, UserRepository $userRepository)
    {
        $this->request = $request;
        $this->userRepository = $userRepository;
    }

    /**
     * @param string $username
     * @param string $password
     * @return array|bool
     */
    public function login(string $username, string $password)
    {
        if (!$this->isAuth()) {
            $user = $this->userRepository->findByUsername($username);
            if (!is_null($user) && $user->comparePassword($password)) {
                $user->generateToken();
                $user->save();
                header(sprintf('%s: %s', $this->headerAuthKey, $user->getToken()));

                return ['token' => $user->getToken()];
            }
        }

        return false;
    }

    /**
     * @return bool
     */
    public function logout(): bool
    {
        if ($this->isAuth()) {
            $user = $this->user();
            $user->eraseToken();
            return $user->save();
        }

        return false;
    }

    /**
     * @return \app\models\auth\User|null
     */
    public function user()
    {
        if ($this->request->hasHeader($this->headerAuthKey)) {
            $token = $this->request->header($this->headerAuthKey);
            return $this->userRepository->findByToken($token);
        }

        return null;
    }

    /**
     * @return bool
     */
    public function isAuth(): bool
    {
        return $this->user() !== null;
    }

    /**
     * @throws ForbiddenHttpException
     */
    public function guard()
    {
        if (!$this->isAuth()) {
            throw new ForbiddenHttpException('You do not have access to this page.');
        }
    }
}