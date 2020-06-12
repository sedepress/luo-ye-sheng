<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use EasyWeChat\Factory;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Str;

class IndexController extends Controller
{
    protected $userService;

    public function __construct()
    {
        $this->userService = new UserService();
    }

    const USER_INSTRUCTION = 'user_instruction:';
    const MENU = "欢迎来到落叶生\n可以直接在输入框输入邀请码哦\n输入nc+昵称可以设置您的昵称哦！\n输入以下指令编号执行相关操作\n0、重置指令\n1、打怪\n2、锻造\n3、挖矿\n4、领取疲劳\n5、商店|装备|邀请\n官方QQ群：1023380085";

    public function index()
    {
        $app = Factory::officialAccount(config('wechat.official_account.default'));
        $app->server->push(function ($message) {
            $key = self::USER_INSTRUCTION . $message['FromUserName'];
            switch ($message['MsgType']) {
                case 'event':
                    if (Redis::hSetnx($key, 'openid', $message['FromUserName'])) {
                        $this->userService->register($message);
                    }

                    return self::MENU;
                    break;
                case 'text':
                    if (Str::startsWith(strtolower($message['Content']), 'nc')) {
                        return $this->userService->setNickname($message['Content'], $message['FromUserName']);
                    }

                    if (Str::startsWith(strtolower($message['Content']), 'yqm')) {
                        return $this->userService->setiInvitationCode($message['FromUserName'], $message['Content']);
                    }

                    switch (intval($message['Content'])) {
                        case 0:
                            return self::MENU;
                    }

                    if (Redis::hSetnx($key, 'content', $message['Content'])) {

                    } else {

                    }
                    return self::MENU;
                    break;
                default:
                    return '亲，只接受字符回复哦！';
                    break;
            }
        });
        $response = $app->server->serve();

        return $response;
    }
}
