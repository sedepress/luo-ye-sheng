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
        $data = $request->only(['page', 'type', 'rating', 'order']);
        $query = (new Shop)->newQuery();

        if ($data['type']) {
            $query->where('type', $data['type']);
        }

        if ($data['rating']) {
            $query->where('rating', $data['rating']);
        }

        if ($data['order']) {
            $query->orderByRaw($data['order']);
        }

        $offset = ($data['page'] - 1) * 10;
        $total  = $query->count();
        $res    = $query->offset($offset)->limit(10)->get();
        $res->each->append('shop_desc');

        return response()->json([
            'code'  => 0,
            'data'  => $res,
            'msg'   => 'ok',
            'total' => $total
        ]);
    }

    public function pay()
    {
        $data = 0;
    }
}
