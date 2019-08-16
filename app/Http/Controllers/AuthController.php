<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class AuthController extends Controller {
    public function register(Request $request)
    {
        // todo
        $user = new User()->fill($request->input());
        $user->save();

        return response()->json([
            'action' => 'register'
        ]);
    }

    public function login()
    {
        // todo
        return response()->json([
            'action' => 'login'
        ]);
    }

    public function account()
    {
        // todo
        return response()->json([
            'action' => 'view account'
        ]);
    }

    public function logout()
    {
        // todo
        return response()->json([
            'action' => 'logout'
        ]);
    }
}