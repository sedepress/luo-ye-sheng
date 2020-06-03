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
                    return '欢迎来到落叶生
                            输入以下指令编号执行相关操作
                            0、重置指令
                            1、打怪
                            2、锻造
                            3、挖矿
                            4、领取疲劳
                            5、商店|装备|邀请
                            官方QQ群：1023380085';
                    break;
                case 'text':
                    return "欢迎来到落叶生\n输入以下指令编号执行相关操作\n0、重置指令\n1、打怪\n2、锻造\n3、挖矿\n4、领取疲劳\n5、商店|装备|邀请\n官方QQ群：1023380085";
                    break;
                case 'image':
                    return '收到图片消息';
                    break;
                case 'voice':
                    return '收到语音消息';
                    break;
                case 'video':
                    return '收到视频消息';
                    break;
                case 'location':
                    return '收到坐标消息';
                    break;
                case 'link':
                    return '收到链接消息';
                    break;
                case 'file':
                    return '收到文件消息';
                // ... 其它消息
                default:
                    return '收到其它消息';
                    break;
            }
        });
        $response = $app->server->serve();

        return $response;
    }
}
