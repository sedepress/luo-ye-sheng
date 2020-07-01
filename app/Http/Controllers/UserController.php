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

        list($res, $total) = $this->userService->getUserProps($user, $data['page']);

        return response()->json([
            'code'  => 0,
            'data'  => $res,
            'msg'   => 'ok',
            'total' => $total
        ]);
    }

    public function equip(Request $request)
    {
        $data = $request->only(['token', 'equip_id']);
        try {
            $openid = decrypt($data['token']);
        } catch (\Exception $exception) {
            abort(403);
        }

        $user = $this->userService->getUserByOpenid($openid);
        if (!$user) {
            abort(403);
        }

        $result = $this->userService->equip($user, $data['equip_id']);
        if ($result) {
            return self::success();
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

        return self::success($user->toArray());
    }
}
