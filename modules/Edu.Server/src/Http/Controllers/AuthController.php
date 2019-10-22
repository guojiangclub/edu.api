<?php

/*
 * This file is part of ibrand/edu-server.
 *
 * (c) iBrand <https://www.ibrand.cc>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace iBrand\Edu\Server\Http\Controllers;

use iBrand\Component\User\Models\User;
use iBrand\Component\User\Repository\UserBindRepository;
use iBrand\Component\User\Repository\UserRepository;
use iBrand\Component\User\UserService;
use iBrand\Sms\Facade as Sms;
use iBrand\Common\Controllers\Controller;

class AuthController extends Controller
{
    protected $userRepository;
    protected $userBindRepository;
    protected $userService;

    public function __construct(UserRepository $userRepository, UserBindRepository $userBindRepository, UserService $userService)
    {
        $this->userRepository = $userRepository;
        $this->userBindRepository = $userBindRepository;
        $this->userService = $userService;
    }

    public function smsLogin()
    {
        $mobile = request('mobile');
        $code = request('code');

        if (!Sms::checkCode($mobile, $code)) {
            return $this->failed('验证码错误');
        }

        $is_new = false;

        if (!$user = $this->userRepository->getUserByCredentials(['mobile' => $mobile])) {
            $data = ['mobile' => $mobile];
            $user = $this->userRepository->create($data);
            $is_new = true;
        }

        if (User::STATUS_FORBIDDEN == $user->status) {
            return $this->failed('您的账号已被禁用，联系网站管理员或客服！');
        }

        //1. create user token.
        $token = $user->createToken($mobile)->accessToken;

        //2. bind user bind data to user.
        //$this->userService->bindPlatform($user->id, request('open_id'), config('wechat.mini_program.default.app_id'), 'miniprogram');

        return $this->success(['token_type' => 'Bearer', 'access_token' => $token, 'is_new_user' => false]);
    }
}
