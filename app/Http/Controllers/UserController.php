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
        $openid = decrypt($data['token']);
        $user = $this->userService->getUserByOpenid($openid);
        if (!$user) {
            abort(403);
        }

        $res = $this->userService->getUserProps($user, $data['page']);

        return response()->json([
            'code' => 0,
            'data' => $res,
            'msg'  => 'ok',
        ]);
    }
}
