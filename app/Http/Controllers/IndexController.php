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
            return "您好！欢迎使用 EasyWeChat!";
        });
        $response = $app->server->serve();

        return $response;
    }
}
