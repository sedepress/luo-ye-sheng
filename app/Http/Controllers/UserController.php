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
        $user->inv_user_name = $this->userService->getUserById($user->invite_people) ?? '无';
        $characterNeed       = $this->userService->judgeUpgrade($user->character_level, $user->current_character_exp);
        $miningNeed          = $this->userService->judgeUpgrade($user->mining_level, $user->current_mining_exp);
        $forgingNeed         = $this->userService->judgeUpgrade($user->forging_level, $user->current_forging_exp);
        $res                 = [
            'yqm'   => ['title' => '邀请码', 'value' => $user->invitation_code, 'desc' => "点击复制邀请内容，粘贴给你的朋友"],
            'basic' => [
                [
                    'title'          => '打怪等级', 'value' => $user->character_level,
                    'desc'           => $characterNeed >= 0 ? '可以提升等级，点击提升' : sprintf("再需要%d经验可升级",
                        abs($characterNeed)),
                    'is_need_render' => $characterNeed >= 0 ? true : false
                ],
                [
                    'title'          => '挖矿等级', 'value' => $user->mining_level,
                    'desc'           => $miningNeed >= 0 ? '可以提升等级，点击提升' : sprintf("再需要%d经验可升级", abs($miningNeed)),
                    'is_need_render' => $miningNeed >= 0 ? true : false
                ],
                [
                    'title'          => '锻造等级', 'value' => $user->forging_level,
                    'desc'           => $forgingNeed >= 0 ? '可以提升等级，点击提升' : sprintf("再需要%d经验可升级", abs($forgingNeed)),
                    'is_need_render' => $forgingNeed >= 0 ? true : false
                ],
                ['title' => '疲劳值', 'value' => $user->fatigue_value, 'desc' => '点击增加疲劳值'],
                ['title' => '人力值', 'value' => $user->manpower, 'desc' => '每邀请一人，增加1点人力值，等他升到2级再奖励3点人力值，再升到5级再奖励6点人力值'],
                ['title' => '金币数', 'value' => $user->current_gold, 'desc' => '金币通过打怪获得，层数越高金币掉落越高'],
                ['title' => '邀请人', 'value' => $user->inv_user_name, 'desc' => '邀请你的人'],
                ['title' => '邀请人数', 'value' => $user->inv_num, 'desc' => '你邀请的人数'],
            ],
            'attr'  => [
                ['title' => '攻击', 'value' => $user->force, 'desc' => ''],
                ['title' => '魔法', 'value' => $user->intelligence, 'desc' => ''],
                ['title' => '防御', 'value' => $user->defence, 'desc' => ''],
                ['title' => '速度', 'value' => $user->speed, 'desc' => ''],
                ['title' => '当前血量', 'value' => $user->current_blood_volume, 'desc' => ''],
                ['title' => '总血量', 'value' => $user->total_blood_volume, 'desc' => ''],
            ]
        ];

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


    }
}
