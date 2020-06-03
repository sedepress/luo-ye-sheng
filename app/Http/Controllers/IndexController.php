<?php

namespace App\Http\Controllers;

use EasyWeChat\Factory;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index(Request $request)
    {
        $app = Factory::officialAccount(config('wechat.official_account.default'));
        $app->server->push(function ($message) {
            switch ($message['MsgType']) {
                case 'event':
                    return "欢迎来到落叶生\n输入以下指令编号执行相关操作\n0、重置指令\n1、打怪\n2、锻造\n3、挖矿\n4、领取疲劳\n5、商店|装备|邀请\n官方QQ群：1023380085";
                    break;
                case 'text':
                    return "欢迎来到落叶生\n输入以下指令编号执行相关操作\n0、重置指令\n1、打怪\n2、锻造\n3、挖矿\n4、领取疲劳\n5、商店|装备|邀请\n官方QQ群：1023380085";
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
