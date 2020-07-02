<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public static function success(array $data = [], $code = 0, $msg = 'result ok')
    {
        return response()->json([
            'code' => $code,
            'data' => $data,
            'msg' => $msg
        ]);
    }

    public static function error(int $code, string $msg = '')
    {
        return response()->json([
            'code' => $code,
            'data' => [],
            'msg' => $msg
        ]);
    }
}
