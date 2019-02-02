<?php
/**
 * Created by PhpStorm.
 * User: box
 * Date: 28.01.19
 * Time: 19:20
 */

namespace app\services\auth;

use app\exceptions\auth\AuthException;
use app\exceptions\auth\UnauthorizedHttpException;
use app\repositories\auth\UserRepository;
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
     * @return array
     * @throws AuthException
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

        throw new AuthException(
            ['username' => $message = 'Incorrect credentials!'],
            $message
        );
    }

    /**
     * @return bool|array
     */
    public function logout()
    {
        if ($this->isAuth()) {
            $user = $this->user();
            $user->eraseToken();
            if ($user->save()) {
                header(sprintf('%s:', $this->headerAuthKey));

                return ['message' => 'Successfully logged out'];
            }
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
     * @throws UnauthorizedHttpException
     */
    public function guard()
    {
        if (!$this->isAuth()) {
            throw new UnauthorizedHttpException([
                'error' => $message = 'You unauthorized!'
            ], $message);
        }
    }
}