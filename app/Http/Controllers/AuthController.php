<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Validator;
use Hash;

class AuthController extends Controller {
    public function register(Request $request)
    {
        $input = $request->input();

        $validator = Validator::make($input, [
            'name' => 'required|max:191',
            'email' => 'required|unique:users,email|email|max:191',
            'password' => 'required|min:6|max:191'
        ]);

        if ($validator->fails())
        {
            return response()->json($validator->errors(), 400);
        }

        // salted password encryption before saving
        $input['password'] = Hash::make($input['password']);

        $user = (new User())->fill($input);
        $user->save();

        // $token = AuthService::loginUserAndGetToken($user);

        return response()->json([
            'msg' => 'registered'
        ]);
    }

    public function login(Request $request)
    {
        $input = $request->input();

        $validator = Validator::make($input, [
            'email' => 'required|email|max:191|exists:users',
            'password' => 'required|min:6|max:191'
        ]);

        if ($validator->fails())
        {
            return response()->json($validator->errors(), 400);
        }

        $user = User::where('email', $input['email'])->first();
        $success = Hash::check($input['password'], $user->password);

        if ($success)
        {
            // $token = AuthService::loginUserAndGetToken($user);

            return response()->json([
                'msg' => 'logged in'
            ]);
        }
        else
        {
            return response()->json([
                'msg' => 'invalid email/password'
            ], 400);
        }
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