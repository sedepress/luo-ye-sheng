<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use App\Services\ShopService;
use App\Services\UserService;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    protected $userService;
    protected $shopService;

    public function __construct()
    {
        $this->userService = new UserService();
        $this->shopService = new ShopService();
    }

    public function index()
    {
        return view('shop.index');
    }

    public function list(Request $request)
    {
        $data = $request->only(['page', 'type', 'rating', 'order', 'price_type', 'token']);
        $query = (new Shop)->newQuery();
        try {
            decrypt($data['token']);
        } catch (\Exception $exception) {
            abort(403);
        }

        if ($data['type']) {
            $query->where('type', $data['type']);
        }

        if ($data['rating']) {
            $query->where('rating', $data['rating']);
        }

        if ($data['order']) {
            $query->orderByRaw($data['order'] . ',id');
        }

        if ($data['price_type']) {
            $query->where('price_type', $data['price_type']);
        }

        $offset = ($data['page'] - 1) * 10;
        $total = 0;
        if ($data['page'] == 1) {
            $total  = $query->count();
        }
        $res    = $query->select(['id', 'name', 'price', 'type', 'price_type', 'lower', 'upper'])->offset($offset)->limit(10)->get();
        $res->each->append('shop_desc');

        return response()->json([
            'code'  => 0,
            'data'  => $res,
            'msg'   => 'ok',
            'total' => $total
        ]);
    }

    public function pay(Request $request)
    {
        $data = $request->only(['token', 'shop_id']);
        try {
            $openid = decrypt($data['token']);
        } catch (\Exception $exception) {
            abort(403);
        }

        $user = $this->userService->getUserByOpenid($openid);
        if (!$user) {
            abort(403);
        }

        $result = $this->shopService->buyShopResult($user, $data['shop_id']);
        if ($result) {
            return response()->json([
                'code'  => 0,
                'data'  => [],
                'msg'   => '购买成功',
            ]);
        }

        return response()->json([
            'code'  => 0,
            'data'  => [],
            'msg'   => '您的余额不足',
        ]);
    }
}
