<?php

namespace App\Services;

use App\Models\BattleScene;
use App\Models\Monster;
use App\Models\User;
use Illuminate\Support\Facades\Redis;

class UserService extends Service
{
    const USER_INSTRUCTION = 'user_instruction:';
    const BATTLE_VICTORY = "您胜利了,佩戴装备或提升等级能更轻松\n";
    const BATTLE_FAILURE = "您战败了,佩戴装备或提升等级再来挑战吧\n";
    const LIMIT = 10;

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

    public function register($message)
    {
        $user = User::query()->create([
            'openid'       => $message['FromUserName'],
            'current_gold' => 100,
        ]);

        $user->userProfile()->create([
            'invitation_code' => 'yqm'.str_pad((string) $user->id, 6, '0', STR_PAD_LEFT),
        ]);
    }

    public function setNickname($str, $opeind)
    {
        $nickname = substr($str, 2);
        $user     = $this->getUserByOpenid($opeind);
        if ($user->nickname) {
            return '已经设置过昵称请勿再次设置哦！';
        }

        if ($this->findNickname($nickname)) {
            return '该昵称已存在,请重新输入新昵称';
        }

        $user           = $this->getUserByOpenid($opeind);
        $user->nickname = $nickname;
        $user->save();
        Redis::hSet(self::USER_INSTRUCTION.$opeind, 'nickname', $nickname);

        return '设置成功！';
    }

    public function setiInvitationCode($openid, $str)
    {
        $user = $this->getUserByOpenid($openid);
        if ($user) {
            if ($user->userProfile->is_used_inv) {
                return '您已绑定过邀请码,请勿重复绑定！';
            }

            $invCode = substr($str, 3);
            $userId  = intval($invCode);
            if ($invUser = $this->getUserById($userId)) {
                if ($invUser->openid == $openid) {
                    return '无法与自己绑定！';
                }
                $user->userProfile->is_used_inv   = true;
                $user->userProfile->invite_people = $invUser->id;
                $user->userProfile->save();
                $invUser->manpower += 1;
                $invUser->save();
                $invUser->userProfile->inv_num += 1;
                $invUser->userProfile->save();

                return "设置完毕,对方人气值+1,回复0开始去打怪或者挖矿吧\n\n官方QQ群：1023380085";
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
        if ($user->userProfile->character_level < $battleScene->minimum_level_limit) {
            return ['你等级还不够哦该层最低需要'.$battleScene->minimum_level_limit.'级', 3, ''];
        }

        $monster = Monster::find($floor);
        [$arm_lower, $arm_upper] = [0, 0];

        if ($user->equip_weapon_id) {
            // 需要增加武器的攻击上下限
            [$arm_lower, $arm_upper] = [0, 0];
        }

        if ($monster->speed > $user->speed) {
            $type = 1;
            [$fast, $slow] = $this->getFastOrSlow($user, $monster, $type, $arm_lower, $arm_upper);
        } else {
            $type = 2;
            [$fast, $slow] = $this->getFastOrSlow($user, $monster, $type, $arm_lower, $arm_upper);
        }

        $battleStr = '';
        $round     = 1;
        do {
            $fast_a_res    = mt_rand($fast['attack_lower'], $fast['attack_upper']) - $slow['defense'] * 2;
            $slow['blood'] -= $fast_a_res > 0 ? $fast_a_res : 0;
            $battleStr     .= sprintf("第%d回合,%s对%s造成%d点伤害", $round, $fast['name'], $slow['name'], $fast_a_res);
            if ($slow['blood'] <= 0) {
                $slow['blood'] = 0;
                $battleStr     .= sprintf(",%s阵亡了\n", $slow['name']);
                $resultType    = 1;
                break;
            }

            $slow_a_res    = mt_rand($slow['attack_lower'], $slow['attack_upper']) - $fast['defense'] * 2;
            $fast['blood'] -= $slow_a_res > 0 ? $slow_a_res : 0;
            $battleStr     .= sprintf(",%s对%s造成%d点伤害", $slow['name'], $fast['name'], $slow_a_res);
            if ($fast['blood'] <= 0) {
                $fast['blood'] = 0;
                $battleStr     .= sprintf(",%s阵亡了\n", $fast['name']);
                $resultType    = 2;
                break;
            }
            $battleStr .= "\n";
            $round++;
        } while (true);

        $result    = $this->judgeBattleResult($user, $type, $resultType, $fast, $slow, $monster->exp,
            mt_rand($battleScene->gold_lower, $battleScene->gold_upper));
        $result[0] .= $battleStr;

        return $result;
    }

    public function getFastOrSlow(User $user, Monster $monster, int $type, int $arm_lower, int $arm_upper)
    {
        [$fast, $slow] = [[], []];

        if ($type == 1) {
            $fast['blood']        = $monster->blood_volume;
            $slow['blood']        = $user->current_blood_volume;
            $fast['attack_lower'] = $monster->attack_lower;
            $fast['attack_upper'] = $monster->attack_upper;
            $slow['attack_lower'] = $user->force + $arm_lower;
            $slow['attack_upper'] = $user->force + $arm_upper;
            $fast['defense']      = $monster->defense;
            $slow['defense']      = $user->defense;
            $fast['name']         = $monster->name;
            $slow['name']         = '你';
        } else {
            $slow['blood']        = $monster->blood_volume;
            $fast['blood']        = $user->current_blood_volume;
            $slow['attack_lower'] = $monster->attack_lower;
            $slow['attack_upper'] = $monster->attack_upper;
            $fast['attack_lower'] = $user->force + $arm_lower;
            $fast['attack_upper'] = $user->force + $arm_upper;
            $slow['defense']      = $monster->defense;
            $fast['defense']      = $user->defense;
            $fast['name']         = '你';
            $slow['name']         = $monster->name;
        }

        return [$fast, $slow];
    }

    public function judgeBattleResult(User $user, int $type, int $resultType, $fast, $slow, $exp, $gold)
    {
        $str = sprintf("疲劳值减少1,当前%d\n经验值增加%d", $user->fatigue_value - 1, $exp);
        if ($type == 1) {
            $user->current_blood_volume = $slow['blood'];

            if ($resultType == 1) {
                $res = [self::BATTLE_FAILURE, 2, ''];
            } else {
                $user->current_exp  += $exp;
                $user->history_exp  += $exp;
                $user->current_gold += $gold;

                if ($this->judgeUpgrade($user->userProfile->character_level, $user->current_exp)) {
                    $str .= ',可以升级了,去提升等级';
                }
                $str .= sprintf("\n金币增加了%d\n", $gold);
                $str .= sprintf("您当前血量为%d", $slow['blood']);

                $res = [self::BATTLE_VICTORY, 1, $str];
            }
        } else {
            $user->current_blood_volume = $fast['blood'];

            if ($resultType == 1) {
                $user->current_exp  += $exp;
                $user->history_exp  += $exp;
                $user->current_gold += $gold;

                if ($this->judgeUpgrade($user->userProfile->character_level, $user->current_exp)) {
                    $str .= ',可以升级了,去提升等级';
                }
                $str .= sprintf("\n金币增加了%d\n", $gold);
                $str .= sprintf("您当前血量为%d", $fast['blood']);

                $res = [self::BATTLE_VICTORY, 1, $str];
            } else {
                $res = [self::BATTLE_FAILURE, 2, ''];
            }
        }
        $user->fatigue_value -= 1;
        $user->save();

        return $res;
    }

    public function judgeUpgrade($currentLevel, $currentExp)
    {
        if ($currentExp >= User::$levelExpMap[$currentLevel]) {
            return true;
        }

        return false;
    }

    public function getUserProps(User $user, $page)
    {
        $offset = ($page - 1) * self::LIMIT;

        return $user->props()->offset($offset)->limit(self::LIMIT)->orderBy('rating', 'desc')->get()->toArray();
    }
}
