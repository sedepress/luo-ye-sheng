<?php

namespace App\Services;

use App\Libs\Constant;
use App\Models\BattleScene;
use App\Models\Hero;
use App\Models\Monster;
use App\Models\Shop;
use App\Models\User;
use App\Models\UserProp;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class UserService extends Service
{
    const USER_INSTRUCTION = 'user_instruction:';
    const BATTLE_VICTORY = "您胜利了,佩戴装备或提升等级能更轻松\n";
    const BATTLE_FAILURE = "您战败了,佩戴装备或提升等级再来挑战吧\n";
    const LIMIT = 10;

    public function getLink($openid, $str, $param)
    {
        return '<a href="' . config('app.url') . '/shop?token=' . encrypt($openid) . '#/' . $param . ''
            . '">' . $str . '</a>';
    }

    public function getUserByOpenid($openid)
    {
        return User::query()->where('openid', $openid)->first();
    }

    public function getUserById($id)
    {
        return User::find($id);
    }

    public function findNickname($nickname)
    {
        return User::query()->where('nickname', $nickname)->first();
    }

    public function subscribe($openid, $isSubscribe)
    {
        $user = $this->getUserByOpenid($openid);
        $user->is_subscribe = $isSubscribe;
        $user->save();
    }

    public function register($openid)
    {
        $user = User::query()->create([
            'openid'       => $openid,
            'current_gold' => 100,
        ]);
        $user->invitation_code = 'yqm' . str_pad((string) $user->id, 6, '0', STR_PAD_LEFT);
        $user->nickname = '编号' . (string) (100000 + $user->id);
        $user->save();

        Hero::query()->where('id', 1)->increment('sales_num');
    }

    public function setNickname($str, $opeind)
    {
        $nickname = substr($str, 2);
        $user = $this->getUserByOpenid($opeind);
        if ($user->nickname) {
            return '已经设置过昵称请勿再次设置哦！';
        }

        if ($this->findNickname($nickname)) {
            return '该昵称已存在,请重新输入新昵称';
        }

        $user = $this->getUserByOpenid($opeind);
        $user->nickname = $nickname;
        $user->save();
        Redis::hSet(self::USER_INSTRUCTION . $opeind, 'nickname', $nickname);

        return '设置成功！';
    }

    public function setiInvitationCode($openid, $str)
    {
        $user = $this->getUserByOpenid($openid);
        if ($user) {
            if ($user->is_used_inv) {
                return '您已绑定过邀请码,请勿重复绑定！';
            }

            $invCode = substr($str, 3);
            $userId = intval($invCode);
            if ($invUser = $this->getUserById($userId)) {
                if ($invUser->openid == $openid) {
                    return '无法与自己绑定！';
                }
                $user->is_used_inv = true;
                $user->invite_people = $invUser->id;
                $user->save();
                $invUser->manpower += 1;
                $invUser->inv_num += 1;
                $invUser->save();

                return "设置完毕,对方人气值+1,回复0开始去打怪或者挖矿吧\n\n官方QQ群：1108302208";
            }
        }

        return '邀请码错误请核对';
    }

    public function getFatigue($openid)
    {
        $user = $this->getUserByOpenid($openid);
        if ($user) {
            $user->fatigue_value += 10;

            return $user->save();
        }

        return false;
    }

    public function battleResult(User $user, int $floor)
    {
        $battleScene = BattleScene::find($floor);
        if ($user->character_level < $battleScene->minimum_level_limit) {
            return [3, '你等级还不够哦该层最低需要' . $battleScene->minimum_level_limit . '级', '', '', ''];
        }

        $monster = Monster::find($floor);

        if (($monster->speed + mt_rand(-$floor, $floor)) > ($user->speed + $user->extra_speed)) {
            $type = 1;
            list($fast, $slow) = $this->getFastAndSlow($user, $monster);
        } else {
            $type = 2;
            list($slow, $fast) = $this->getFastAndSlow($user, $monster);
        }

        $battleStr = '';
        $round = 1;
        do {
            $fast_a_res = mt_rand($fast['attack_lower'], $fast['attack_upper']) - $slow['defense'];
            $slow['blood'] -= $fast_a_res > 0 ? $fast_a_res : 0;
            $battleStr .= sprintf("第%d回合,%s对%s造成%d点伤害", $round, $fast['name'], $slow['name'], $fast_a_res);
            if ($slow['blood'] <= 0) {
                $slow['blood'] = 0;
                $battleStr .= sprintf(",%s阵亡了\n", $slow['name']);
                $resultType = true;
                break;
            }

            $slow_a_res = mt_rand($slow['attack_lower'], $slow['attack_upper']) - $fast['defense'];
            $fast['blood'] -= $slow_a_res > 0 ? $slow_a_res : 0;
            $battleStr .= sprintf(",%s对%s造成%d点伤害", $slow['name'], $fast['name'], $slow_a_res);
            if ($fast['blood'] <= 0) {
                $fast['blood'] = 0;
                $battleStr .= sprintf(",%s阵亡了\n", $fast['name']);
                $resultType = false;
                break;
            }
            $battleStr .= "\n";
            $round++;
        } while (true);

        $blood = [
            'fast' => $fast['blood'],
            'slow' => $slow['blood']
        ];

        $reward = [
            'exp'  => $monster->exp,
            'gold' => mt_rand($battleScene->gold_lower, $battleScene->gold_upper),
        ];

        $result = $this->judgeBattleResult($user, $type, $resultType, $blood, $reward);
        $result[1] .= $battleStr;

        return $result;
    }

    public function getFastAndSlow(User $user, Monster $monster)
    {
        list($fast, $slow) = [[], []];

        $fast['blood'] = $monster->blood_volume;
        $slow['blood'] = $user->current_blood_volume;
        $fast['attack_lower'] = $monster->attack_lower;
        $fast['attack_upper'] = $monster->attack_upper;
        $slow['attack_lower'] = $user->attack_lower + $user->extra_attack_lower;
        $slow['attack_upper'] = $user->attack_upper + $user->extra_attack_upper;
        $fast['defense'] = $monster->defense;
        $slow['defense'] = $user->defense + $user->extra_defence;
        $fast['name'] = $monster->name;
        $slow['name'] = '你';

        return [$fast, $slow];
    }

    public function judgeBattleResult(User $user, int $type, bool $resultType, $blood, $reward)
    {
        $fatigueStr = sprintf("疲劳值减少1,当前%d", $user->fatigue_value - 1);
        $rewardStr = '';

        if ($type == 1) {
            $user->current_blood_volume = $blood['slow'];

            if ($resultType) {
                $bloodStr = "\n您当前血量为0";
                $res = [2, self::BATTLE_FAILURE, $fatigueStr, $bloodStr, $rewardStr];
            } else {
                $res = $this->battleVictory($user, $reward, $blood, $fatigueStr);
            }
        } else {
            $user->current_blood_volume = $blood['fast'];

            if ($resultType) {
                $res = $this->battleVictory($user, $reward, $blood, $fatigueStr);
            } else {
                $bloodStr = "\n您当前血量为0";
                $res = [2, self::BATTLE_FAILURE, $fatigueStr, $bloodStr, $rewardStr];
            }
        }

        if ($user->equip_drup_id) {
            list($curBlood, $s) = $this->suppleBlood($user);
            $bloodStr = sprintf("\n您当前血量为%d", $curBlood);
            $res[3] = $s . $bloodStr;
        }

        $user->fatigue_value -= 1;
        $user->save();

        return $res;
    }

    public function battleVictory(User $user, $reward, $blood, $fatigueStr)
    {
        $rewardStr = sprintf("\n经验值增加%d", $reward['exp']);

        $user->current_character_exp += $reward['exp'];
        $user->history_character_exp += $reward['exp'];
        $user->current_gold += $reward['gold'];

        if ($this->judgeUpgrade($user->character_level, $user->current_character_exp) >= 0) {
            $rewardStr .= ',可以升级了,去' . $this->getLink($user->openid, '提升等级', 'user');
        }
        $rewardStr .= sprintf("\n金币增加了%d", $reward['gold']);
        $bloodStr = sprintf("\n您当前血量为%d", $blood['fast']);

        return [1, self::BATTLE_VICTORY, $fatigueStr, $bloodStr, $rewardStr];
    }

    public function judgeUpgrade($currentLevel, $currentExp)
    {
        return $currentExp - User::$levelExpMap[$currentLevel];
    }

    public function getUserProps(User $user, $page)
    {
        $offset = ($page - 1) * self::LIMIT;
        $total = 0;
        if ($page == 1) {
            $total = $user->props()->where('status', true)->count();
        }
        $data = $user->props()->offset($offset)->where('status',
            true)->limit(self::LIMIT)->orderByRaw('rating desc,id desc')->get();
        $data->each->append('prop_desc');

        return [$data->toArray(), $total];
    }

    public function equip(User $user, $equipId, $isEquip)
    {
        $equip = UserProp::query()->find($equipId);
        if ($equip) {
            $equip_weapon_id = $isEquip ? $equip->id : 0;
            $extraLower = $isEquip ? $equip->lower : 0;
            $extraUpper = $isEquip ? $equip->upper : 0;

            switch ($equip->type) {
                case Constant::EQUIP_TYPE_WEAPON:
                    $user->equip_weapon_id = $equip_weapon_id;
                    $user->extra_attack_lower = $extraLower;
                    $user->extra_attack_upper = $extraUpper;
                    break;
                case Constant::EQUIP_TYPE_ARMOR:
                    $user->equip_armor_id = $equip_weapon_id;
                    $user->extra_defence = $extraLower;
                    break;
                case Constant::EQUIP_TYPE_SHOES:
                    $user->equip_shoes_id = $equip_weapon_id;
                    $user->extra_speed = $extraLower;
                    break;
                case Constant::EQUIP_TYPE_BELT:
                    $user->equip_belt_id = $equip_weapon_id;
                    $user->extra_blood = $extraLower;
                    break;
                case Constant::EQUIP_TYPE_HOE:
                    $user->equip_hoe_id = $equip_weapon_id;
                    break;
                case Constant::EQUIP_TYPE_FORGING:
                    $user->equip_forging_id = $equip_weapon_id;
                    break;
                case Constant::EQUIP_TYPE_DRUP:
                    $user->equip_drup_id = $equip_weapon_id;
                    $this->suppleBlood($user);
                    break;
                default:
                    break;
            }
            $user->save();

            return [
                'equiped_ids' => $this->constructEquipedArr($user),
            ];
        }

        return false;
    }

    public function upgrade(User $user, $type)
    {
        if (!$this->judgeEnoughManpower($user, $type)) {
            return [false, '人力值不足'];
        }

        switch ($type) {
            case User::LEVEL_TYPE_CHARACTER:
                [$level, $field, $expField] = [
                    $user->character_level, User::$levelFieldMap[User::LEVEL_TYPE_CHARACTER], 'current_character_exp'
                ];
                break;
            case User::LEVEL_TYPE_MINING:
                [$level, $field, $expField] = [
                    $user->mining_level, User::$levelFieldMap[User::LEVEL_TYPE_MINING], 'current_mining_exp'
                ];
                break;
            case User::LEVEL_TYPE_FORGING:
                [$level, $field, $expField] = [
                    $user->forging_level, User::$levelFieldMap[User::LEVEL_TYPE_FORGING], 'current_forging_exp'
                ];
                break;
            default:
                logger()->error("升级异常：用户ID：{$user->id},升级类型：{$type}");
        }

        $exp = $this->judgeUpgrade($level, $user->$expField);
        if ($exp < 0) {
            return [false, '经验不足'];
        }

        $manpower = $user->manpower;

        if ($field == User::$levelFieldMap[User::LEVEL_TYPE_CHARACTER]) {
            $hero = Hero::query()->find($user->hero_id);
            User::query()->where('id', $user->id)->where('manpower', $manpower)->update([
                $field                 => $level + 1,
                $expField              => $exp,
                'manpower'             => $manpower - User::$levelNeedManpowerMap[$level],
                'attack_lower'         => $user->attack_lower + $hero->attack_growth,
                'attack_upper'         => $user->attack_upper + $hero->attack_growth,
                'intelligence'         => $user->intelligence + $hero->intelligence_growth,
                'defence'              => $user->defence + $hero->defence_growth,
                'speed'                => $user->speed + $hero->speed_growth,
                'current_blood_volume' => $user->current_blood_volume + $hero->blood_growth,
                'total_blood_volume'   => $user->total_blood_volume + $hero->blood_growth,
            ]);
        } else {
            User::query()->where('id', $user->id)->where('manpower', $manpower)->update([
                $field     => $level + 1,
                $expField  => $exp,
                'manpower' => $manpower - User::$levelNeedManpowerMap[$level],
            ]);
        }

        // TODO 给邀请人增加人力值以后放队列
        if ($user->invite_people && in_array($level + 1, [User::INV_LEVEL_THREE, User::INV_LEVEL_FIVE])) {
            $invPeople = User::query()->find($user->invite_people);
            $invPeople->manpower += User::$invLevelMap[$level + 1];
            $invPeople->save();
        }

        return [true, '升级成功'];
    }

    public function constructUserInfo(User $user)
    {
        $user->inv_user_name = $this->getUserById($user->invite_people) ?? '无';
        $characterNeed = $this->judgeUpgrade($user->character_level, $user->current_character_exp);
        $miningNeed = $this->judgeUpgrade($user->mining_level, $user->current_mining_exp);
        $forgingNeed = $this->judgeUpgrade($user->forging_level, $user->current_forging_exp);
        $res = [
            'yqm'   => ['title' => '邀请码', 'value' => $user->invitation_code, 'desc' => "点击复制邀请内容,粘贴给你的朋友"],
            'basic' => [
                [
                    'title'          => '打怪等级', 'value' => $user->character_level,
                    'desc'           => $characterNeed >= 0 ? '可以提升等级,点击提升' : sprintf("再需要%d经验可升级",
                        abs($characterNeed)),
                    'is_need_render' => $characterNeed >= 0 ? true : false
                ],
                [
                    'title'          => '挖矿等级', 'value' => $user->mining_level,
                    'desc'           => $miningNeed >= 0 ? '可以提升等级,点击提升' : sprintf("再需要%d经验可升级", abs($miningNeed)),
                    'is_need_render' => $miningNeed >= 0 ? true : false
                ],
                [
                    'title'          => '锻造等级', 'value' => $user->forging_level,
                    'desc'           => $forgingNeed >= 0 ? '可以提升等级,点击提升' : sprintf("再需要%d经验可升级", abs($forgingNeed)),
                    'is_need_render' => $forgingNeed >= 0 ? true : false
                ],
                ['title' => '疲劳值', 'value' => $user->fatigue_value, 'desc' => '点击增加疲劳值'],
                ['title' => '人力值', 'value' => $user->manpower, 'desc' => '每邀请一人,增加1点人力值,等他升到3级再奖励3点人力值,再升到5级再奖励6点人力值'],
                ['title' => '幸运值', 'value' => $user->lucky_value, 'desc' => '影响特殊事件的发生概率'],
                ['title' => '金币数', 'value' => $user->current_gold, 'desc' => '金币通过打怪获得,层数越高金币掉落越高'],
                ['title' => '邀请人', 'value' => $user->inv_user_name, 'desc' => '邀请你的人'],
                ['title' => '邀请人数', 'value' => $user->inv_num, 'desc' => '你邀请的人数'],
            ],
            'attr'  => [
                ['title' => '攻击上限', 'value' => $user->attack_upper + $user->extra_attack_upper, 'desc' => ''],
                ['title' => '攻击下限', 'value' => $user->attack_lower + $user->extra_attack_lower, 'desc' => ''],
                ['title' => '魔法', 'value' => $user->intelligence + $user->extra_intelligence, 'desc' => ''],
                ['title' => '防御', 'value' => $user->defence + $user->extra_defence, 'desc' => ''],
                ['title' => '速度', 'value' => $user->speed + $user->extra_speed, 'desc' => ''],
                ['title' => '当前血量', 'value' => $user->current_blood_volume, 'desc' => ''],
                ['title' => '总血量', 'value' => $user->total_blood_volume + $user->extra_blood, 'desc' => ''],
            ]
        ];

        return $res;
    }

    public function judgeEnoughManpower(User $user, $type)
    {
        $field = User::$levelFieldMap[$type];

        return $user->manpower - User::$levelNeedManpowerMap[$user->$field] >= 0 ? true : false;
    }

    public function buyFatigue(User $user)
    {
        $manpower = $user->manpower;

        if ($manpower < 1) {
            return false;
        }

        $fatigue = $user->fatigue_value + User::BUY_FATIGUE;
        User::query()->where('id', $user->id)->where('manpower', $manpower)->update([
            'manpower'      => $manpower - 1,
            'fatigue_value' => $fatigue,
        ]);

        return true;
    }

    public function miningResult($ins, $openid)
    {
        $user = $this->getUserByOpenid($openid);
        if (!$user->equip_hoe_id) {
            return '请先装备至少' . $ins . '级锄头,进入' . $this->getLink($openid, '我的装备', 'prop');
        }

        $hoe = UserProp::query()->where('id', $user->equip_hoe_id)->first();
        if (!$hoe->status) {
            return '所装备的锄头已经耗尽,请更换新锄头,进入' . $this->getLink($openid, '我的装备', 'prop');
        }

        if ($hoe->rating < $ins) {
            return '所装备的锄头等级不足,该层需要至少' . $ins . '级锄头,进入' . $this->getLink($openid, '我的装备', 'prop');
        }

        if ($hoe->lower < 1) {
            return '所装备的锄头次数已经用尽,请更换新锄头,进入' . $this->getLink($openid, '我的装备', 'prop');
        }

        $randnum = mt_rand(0, 100);
        $need = 100 - 5 * $ins + ($hoe->rating - $ins) * 5;
        if ($randnum < $need) {
            $name = $ins . '级矿石';
            $rewardStr = '';

            DB::beginTransaction();
            try {
                $user->props()->create([
                    'name'   => $name,
                    'rating' => $ins,
                    'type'   => Constant::EQUIP_TYPE_ORE,
                ]);

                $str = $this->decHoeTimes($hoe, $user);

                $user->current_mining_exp += Constant::$getExpLevelMap[$ins];
                $user->history_mining_exp += Constant::$getExpLevelMap[$ins];
                $user->save();

                DB::commit();

                if ($this->judgeUpgrade($user->mining_level, $user->current_mining_exp) >= 0) {
                    $rewardStr .= ',可以升级了,去' . $this->getLink($openid, '提升等级', 'user');
                }
            } catch (\PDOException $exception) {
                DB::rollBack();
                logger()->error('挖矿异常：用户id = ' . $user->id);

                return '系统异常,请重试';
            }

            return "真幸运,挖到了{$name}" . $str . $rewardStr;
        }
        $str = $this->decHoeTimes($hoe, $user);

        return "糟糕,什么也没挖到,再试试吧不要灰心" . $str;
    }

    public function decHoeTimes(UserProp $userProp, User $user)
    {
        $str = '';
        $userProp->lower -= 1;
        if ($userProp->lower == 0) {
            $user->equip_hoe_id = 0;
            $user->save();
            $userProp->status = false;
            $str .= ',锄头次数已耗尽,快更换一个锄头吧,进入' . $this->getLink($user->openid, '我的装备', 'prop');
        }
        $userProp->save();

        return $str;
    }

    public function forgingResult($ins, $openid)
    {
        $user = $this->getUserByOpenid($openid);
        if (!$user->equip_forging_id) {
            return '请先装备至少' . $ins . '级锻造炉,进入' . $this->getLink($openid, '我的装备', 'prop');
        }

        $forging = UserProp::query()->where('id', $user->equip_forging_id)->first();
        if (!$forging->status) {
            return '所装备的锻造炉已经耗尽,请更换新锻造炉,进入' . $this->getLink($openid, '我的装备', 'prop');
        }

        if ($forging->rating < $ins) {
            return '所装备的锻造炉等级不足,该炉需要至少' . $ins . '级锻造炉,进入' . $this->getLink($openid, '我的装备', 'prop');
        }

        if ($forging->lower < 1) {
            return '所装备的锻造炉次数已经用尽,请更换新锻造炉,进入' . $this->getLink($openid, '我的装备', 'prop');
        }

        $ore = UserProp::query()->where('user_id', $user->id)->where('type', Constant::EQUIP_TYPE_ORE)
            ->where('rating', $ins)->where('status', true)->first();
        if (!$ore) {
            return '背包中没有对应等级的矿石';
        }

        $randnum = mt_rand(0, 100);
        $need = 100 - 5 * $ins + ($forging->rating - $ins) * 5;
        if ($randnum < $need) {
            $randEquipType = mt_rand(1, 4);
            switch ($randEquipType) {
                case Constant::EQUIP_TYPE_WEAPON:
                    $name = '级强化武器';
                    $incLower = mt_rand(1 * $ins, 5 * $ins);
                    $incUpper = mt_rand(1 * $ins, 5 * $ins);
                    $desc = '攻击范围';
                    break;
                case Constant::EQUIP_TYPE_ARMOR:
                    $name = '级强化护甲';
                    $incLower = mt_rand(1 * $ins, 5 * $ins);
                    $incUpper = $incLower;
                    $desc = '防御';
                    break;
                case Constant::EQUIP_TYPE_SHOES:
                    $name = '级强化鞋子';
                    $incLower = mt_rand(1 * $ins, 3 * $ins);
                    $incUpper = $incLower;
                    $desc = '速度';
                    break;
                case Constant::EQUIP_TYPE_BELT:
                    $name = '级强化腰带';
                    $incLower = mt_rand(5 * $ins, 20 * $ins);
                    $incUpper = $incLower;
                    $desc = '血量';
                    break;
            }
            $equip = Shop::query()->where('rating', $ins)->where('type', $randEquipType)->first();
            $rewardStr = '';

            DB::beginTransaction();
            try {
                $name = $ins . $name;
                $lower = $equip->lower + $incLower;
                $upper = $equip->upper + $incUpper;

                $user->props()->create([
                    'name'   => $name,
                    'lower'  => $lower,
                    'upper'  => $upper,
                    'rating' => $ins,
                    'type'   => $randEquipType,
                ]);

                $ore->status = false;
                $ore->save();

                $user->current_forging_exp += Constant::$getExpLevelMap[$ins];
                $user->history_forging_exp += Constant::$getExpLevelMap[$ins];
                $user->save();

                $str = $this->decForgingTimes($forging, $user);
                DB::commit();

                if ($this->judgeUpgrade($user->forging_level, $user->current_forging_exp) >= 0) {
                    $rewardStr .= ',可以升级了,去' . $this->getLink($openid, '提升等级', 'user');
                }
            } catch (\PDOException $exception) {
                DB::rollBack();
                logger()->error('锻造装备异常：用户id = ' . $user->id);

                return '系统异常,请重试';
            }

            if ($randEquipType == 1) {
                $desc .= $lower . ' ~ ' . $upper;
            } else {
                $desc .= $lower;
            }

            return "恭喜你获得了{$name} {$desc}" . $str . $rewardStr;
        }
        $str = $this->decForgingTimes($forging, $user);

        return "糟糕,锻造失败了,再试试吧不要灰心" . $str;
    }

    public function decForgingTimes(UserProp $userProp, User $user)
    {
        $str = '';
        $userProp->lower -= 1;
        if ($userProp->lower == 0) {
            $user->equip_forging_id = 0;
            $user->save();
            $userProp->status = false;
            $str .= ',锻造炉次数已耗尽,快更换一个锻造炉吧,进入' . $this->getLink($user->openid, '我的装备', 'prop');
        }
        $userProp->save();

        return $str;
    }

    public function constructEquipedArr(User $user)
    {
        return [
            'equip_weapon_id'  => $user->equip_weapon_id,
            'equip_armor_id'   => $user->equip_armor_id,
            'equip_shoes_id'   => $user->equip_shoes_id,
            'equip_belt_id'    => $user->equip_belt_id,
            'equip_hoe_id'     => $user->equip_hoe_id,
            'equip_forging_id' => $user->equip_forging_id,
            'equip_drup_id'    => $user->equip_drup_id,
        ];
    }

    public function suppleBlood(User $user)
    {
        $drup = UserProp::query()->find($user->equip_drup_id);
        $supNum = $user->total_blood_volume + $user->extra_blood - $user->current_blood_volume;
        if ($drup->lower <= $supNum) {
            $user->current_blood_volume += $drup->lower;
            $user->equip_drup_id = 0;

            $str = "\n您的红罗羹补充了" . $drup->lower . '点血量';
            $str .= "\n您的红罗羹已经用尽,进入" . $this->getLink($user->openid, '我的装备', 'prop');

            $drup->status = false;
            $drup->lower = 0;
        } else {
            $user->current_blood_volume += $supNum;

            $drup->lower -= $supNum;

            $str = "\n您的红罗羹补充了" . $supNum . '点血量';
        }
        $drup->save();

        return [$user->current_blood_volume, $str];
    }
}
