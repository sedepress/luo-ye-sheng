<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index()
    {
        return view('shop.index');
    }

    public function list(Request $request)
    {
        $data = $request->all();

        $offset = ($data['page'] - 1) * 10;
        $res    = Shop::query()->offset($offset)->limit(10)->get();
        $res->each->append('shop_desc');
        $total  = Shop::query()->count();

        return response()->json([
            'code'  => 0,
            'data'  => $res,
            'msg'   => 'ok',
            'total' => $total
        ]);
    }
}
