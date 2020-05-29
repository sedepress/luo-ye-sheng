<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index(Request $request)
    {
        $signature = $request->input('signature');
        $timestamp = $request->input('timestamp');
        $nonce = $request->input('nonce');
        $echostr = $request->input('echostr');
        $token = 'luoyesheng';

        $tmpArr = [$nonce, $token, $timestamp];
        sort($tmpArr);

        $str = implode($tmpArr);
        $sign = sha1($str);

        if ($sign == $signature) {
            echo $echostr;
        }
    }
}
