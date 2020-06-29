<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MyPropController extends Controller
{
    public function index()
    {
        return view('my_prop.index');
    }
}
