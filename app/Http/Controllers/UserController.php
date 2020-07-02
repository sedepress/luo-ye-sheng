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
            'equiped_ids' => [
                'equip_weapon_id'  => $user->equip_weapon_id,
                'equip_armor_id'   => $user->equip_armor_id,
                'equip_shoes_id'   => $user->equip_shoes_id,
                'equip_hoe_id'     => $user->equip_hoe_id,
                'equip_forging_id' => $user->equip_forging_id,
                'equip_drup_id'    => $user->equip_drup_id,
            ]
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

        $upgradeUser = $this->userService->upgrade($user, $data['level_type']);
        if ($upgradeUser) {
            $res = $this->userService->constructUserInfo($upgradeUser);

            return self::success($res);
        }

        abort(500);
    }
}
