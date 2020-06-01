<?php

namespace App\Http\Controllers;

use EasyWeChat\Factory;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index(Request $request)
    {
        $app = Factory::officialAccount(config('wechat.official_account.default'));
        $response = $app->server->serve();

        return $response;
    }
}
