<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redis;

class WeChatController extends Controller
{
    const WECHAT_DEBUG_ACCESS_TOKEN = 'wechat_debug_access_token';

    public static function getAccessToken()
    {
        $access_token = Redis::get(self::WECHAT_DEBUG_ACCESS_TOKEN);
        if (!$access_token) {
            $config = config('wechat.official_account');
            $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid={$config['default']['app_id']}&secret={$config['default']['secret']}";
            $response = Http::get($url);
            $res = $response->json();
            if (isset($res['errcode'])) {
                logger()->error('微信调用access_token失败：' . $response->body());
                return;
            }
            Redis::set(self::WECHAT_DEBUG_ACCESS_TOKEN, $res['access_token']);
            Redis::expire(self::WECHAT_DEBUG_ACCESS_TOKEN, $res['expires_in'] - 5);
            $access_token = $response['access_token'];
        }

        return $access_token;
    }
}
