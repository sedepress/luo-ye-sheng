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

    public function props(Request $request)
    {
        $openid = decrypt($request->input(['token']));
        $user = $this->userService->getUserByOpenid($openid);
        if (!$user) {

        }

        return view('user.prop');
    }
}
