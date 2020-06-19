<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use Carbon\Carbon;
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

    const SYSTEM_ERROR = '系统异常，请加群联系群主！';
    const USER_INSTRUCTION = 'user_info:';
    const IS_FATIGUE = 'is_fatigue:';
    const YES_FATIGUE_MENU = '成功获取 10 点疲劳';
    const NO_FATIGUE_MENU = '你今日已经领取，明天再来领取吧';
    const MENU = "👄欢迎来到落叶生👄\n可以直接在输入框输入邀请码哦\n输入nc+昵称可以设置昵称！\n输入以下指令编号执行相关操作\n0、重置指令\n1、打怪\n2、锻造\n3、挖矿\n4、领取疲劳\n5、商店|装备|邀请\n官方QQ群：1023380085";
    const BATTLE_SCENE_MENU = "谨慎选择，进入更深的洞穴有可能会挂掉\n\n输入以下指令编号执行相关操作\n0、重置指令\n1、进入一层洞穴\n2、进入二层洞穴\n3、进入三层洞穴\n4、进入四层洞穴\n5、进入五层洞穴\n6、进入六层洞穴\n7、进入七层洞穴\n8、进入八层洞穴\n9、进入九层洞穴\n10、进入十层洞穴\n\n官方QQ群：1023380085";
    const FORGING_FURNACE_MENU = "谨慎选择，只能使用当前装备锻造炉等级及以下并不是100%锻造成功哦！佩戴等级越高几率越高！\n\n输入以下指令编号执行相关操作\n0、重置指令\n1、进入一级锻造炉\n2、进入二级锻造炉\n3、进入三级锻造炉\n4、进入四级锻造炉\n5、进入五级锻造炉\n6、进入六级锻造炉\n7、进入七级锻造炉\n8、进入八级锻造炉\n9、进入九级锻造炉\n10、进入十级锻造炉\n\n官方QQ群：1023380085";
    const MINING_MENU = "谨慎选择，只能进入当前装备锄头等级的矿洞及以下并不是100%能挖到矿石哦！佩戴等级越高几率越高！\n\n输入以下指令编号执行相关操作\n0、重置指令\n1、进入一层矿洞\n2、进入二层矿洞\n3、进入三层矿洞\n4、进入四层矿洞\n5、进入五层矿洞\n6、进入六层矿洞\n7、进入七层矿洞\n8、进入八层矿洞\n9、进入九层矿洞\n10、进入十层矿洞\n\n官方QQ群：1023380085";

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

                    if ($nickname = Redis::hGet($key, 'nickname')) {
                        $menu = '👑' . $nickname . "大侠👑\n" . self::MENU;
                    } else {
                        $menu = self::MENU;
                    }

                    $ins = intval($message['Content']);
                    if ($instruction = Redis::hGet($key, 'instruction')) {
                        switch (intval($instruction)) {
                            case 1:
                                return $this->battle($ins, $key, $menu);
                                break;
                            case 2:
                                return $this->forgin($ins, $key, $menu);
                                break;
                            case 3:
                                return $this->mining($ins, $key, $menu);
                                break;
                            default:
                                Redis::hSet($key, 'instruction', '');
                                return $menu;
                        }
                    } else {
                        if (in_array($ins, [1, 2, 3])) {
                            Redis::hSet($key, 'instruction', $ins);
                        }

                        switch ($ins) {
                            case 1:
                                return self::BATTLE_SCENE_MENU;
                                break;
                            case 2:
                                return self::FORGING_FURNACE_MENU;
                                break;
                            case 3:
                                return self::MINING_MENU;
                                break;
                            case 4:
                                if (Redis::setnx(self::IS_FATIGUE . $message['FromUserName'], 1)) {
                                    Redis::expireAt(self::IS_FATIGUE . $message['FromUserName'], Carbon::tomorrow()->timestamp);
                                    if ($this->userService->getFatigue($message['FromUserName'])) {
                                        return self::YES_FATIGUE_MENU;
                                    }

                                    return self::SYSTEM_ERROR;
                                }

                                return self::NO_FATIGUE_MENU;
                                break;
                            case 5:
                                return '这是一个测试的文本消息<a href="http://120.27.145.17">百度</a>';
                                break;
                            default:
                                Redis::hSet($key, 'instruction', '');
                                return $menu;
                        }
                    }
                    break;
                default:
                    return '亲，只接受字符回复哦！';
                    break;
            }
        });
        $response = $app->server->serve();

        return $response;
    }

    protected function battle(int $ins, string $key, string $menu)
    {
        if ($this->judgeIns($ins, $key)) {
            return $menu;
        }

        $res = $this->numberToChinese($ins) . "级洞穴\n打怪完毕，以下是你的战况\n\n";


        return ;
    }

    protected function forgin(int $ins, string $key, string $menu)
    {
        if ($this->judgeIns($ins, $key)) {
            return $menu;
        }

        return $this->numberToChinese($ins) . '级锻造';
    }

    protected function mining(int $ins, string $key, string $menu)
    {
        if ($this->judgeIns($ins, $key)) {
            return $menu;
        }

        return '挖矿';
    }

    protected function judgeIns(int $ins, string $key)
    {
        if ($ins > 10 || $ins < 1) {
            Redis::hSet($key, 'instruction', '');
            return true;
        }

        return false;
    }

    protected function numberToChinese(int $ins)
    {
        $ch = [1 => '一', 2 => '二', 3 => '三', 4 => '四', 5 => '五', 6 => '六', 7 => '七', 8 => '八', 9 => '九', 10 => '十'];

        return $ch[$ins];
    }
}
