<?php

namespace App\Services;

use App\Models\BattleScene;
use App\Models\User;
use Illuminate\Support\Facades\Redis;

class UserService extends Service
{
    const USER_INSTRUCTION = 'user_instruction:';

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
            'invitation_code' => 'yqm' . str_pad((string)$user->id, 6, '0', STR_PAD_LEFT),
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
            return '该昵称已存在，请重新输入新昵称';
        }

        $user           = $this->getUserByOpenid($opeind);
        $user->nickname = $nickname;
        $user->save();
        Redis::hSet(self::USER_INSTRUCTION . $opeind, 'nickname', $nickname);

        return '设置成功！';
    }

    public function setiInvitationCode($openid, $str)
    {
        $user = $this->getUserByOpenid($openid);
        if ($user) {
            if ($user->userProfile->is_used_inv) {
                return '您已绑定过邀请码，请勿重复绑定！';
            }

            $invCode = substr($str, 3);
            $userId  = intval($invCode);
            if ($invUser = $this->getUserById($userId)) {
                if ($invUser->openid == $openid) {
                    return '无法与自己绑定！';
                }
                $user->userProfile->is_used_inv = true;
                $user->userProfile->invite_people = $invUser->id;
                $user->userProfile->save();
                $invUser->manpower += 1;
                $invUser->save();
                $invUser->userProfile->inv_num  += 1;
                $invUser->userProfile->save();

                return '绑定成功！';
            }
        }

        return '邀请码错误请核对。';
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
            return '你等级还不够哦该层最低需要几级';
        }


    }
}
