<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $userService;

    public function __construct()
    {
        $this->userService = new UserService();
    }

    public function show()
    {
        return view('user.show');
    }

    public function prop()
    {
        return view('user.prop');
    }

    public function propList(Request $request)
    {
        $data = $request->only(['token', 'page']);
        try {
            $openid = decrypt($data['token']);
        } catch (\Exception $exception) {
            abort(403);
        }

        $user = $this->userService->getUserByOpenid($openid);
        if (!$user) {
            abort(403);
        }

        list($props, $total) = $this->userService->getUserProps($user, $data['page']);
        $res = [
            'list'        => $props,
            'total'       => $total,
            'equiped_ids' => $this->userService->constructEquipedArr($user),
        ];

        return self::success($res);
    }

    public function equip(Request $request)
    {
        $data = $request->only(['token', 'equip_id', 'r']);
        try {
            $openid = decrypt($data['token']);
        } catch (\Exception $exception) {
            abort(403);
        }

        $user = $this->userService->getUserByOpenid($openid);
        if (!$user) {
            abort(403);
        }

        $result = $this->userService->equip($user, $data['equip_id'], $data['r']);
        if ($result) {
            return self::success($result);
        }

        return abort(500);
    }

    public function detail(Request $request)
    {
        $data = $request->only(['token']);
        try {
            $openid = decrypt($data['token']);
        } catch (\Exception $exception) {
            abort(403);
        }

        $user = $this->userService->getUserByOpenid($openid);
        if (!$user) {
            abort(500);
        }
        $res = $this->userService->constructUserInfo($user);

        return self::success($res);
    }

    public function upgrade(Request $request)
    {
        $data = $request->only(['token', 'level_type']);
        try {
            $openid = decrypt($data['token']);
        } catch (\Exception $exception) {
            abort(403);
        }

        $user = $this->userService->getUserByOpenid($openid);
        if (!$user) {
            abort(500);
        }

        $msg = $this->userService->upgrade($user, $data['level_type']);

        return self::success([], 0, $msg);
    }

    public function fatigue(Request $request)
    {
        try {
            $openid = decrypt($request->input('token'));
        } catch (\Exception $exception) {
            abort(403);
        }

        $user = $this->userService->getUserByOpenid($openid);
        if (!$user) {
            abort(500);
        }

        $result = $this->userService->buyFatigue($user);
        if ($result) {
            return self::success([], 0, '兑换成功');
        }

        return self::error(403, '人力值不足');
    }
}
