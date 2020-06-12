<?php

namespace App\Services;

use App\Models\User;

class UserService extends Service
{
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
            'openid' => $message['FromUserName'],
        ]);

        $user->invitation_code = 'yqm' . (100000 + $user->id);
        $user->save();
    }

    public function setNickname($str, $opeind)
    {
        $nickname = substr($str, 2);
        $user = $this->getUserByOpenid($opeind);
        if ($user->nickname) {
            return '已经设置过昵称请勿再次设置哦！';
        }

        if ($this->findNickname($nickname)) {
            return '该昵称已存在，请重新输入新昵称';
        }

        $user = $this->getUserByOpenid($opeind);
        $user->nickname = $nickname;
        $user->save();

        return '设置成功！';
    }

    public function setiInvitationCode($openid, $str)
    {
        $user = $this->getUserByOpenid($openid);
        if ($user) {
            if ($user->is_used_inv) {
                return '您已绑定过邀请码，请勿重复绑定！';
            }
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

            return '绑定成功！';
        }

        return '系统异常！请入群联系群主。';
    }
}
