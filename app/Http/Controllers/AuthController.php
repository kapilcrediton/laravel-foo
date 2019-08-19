<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Validator;
use Hash;
use Str;
use Cache;
use App\Providers\TokenAuth\Facade as TokenAuth;

class AuthController extends Controller {
    public function register(Request $request)
    {
        $input = $request->only(['name', 'email', 'password']);

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

        $token = TokenAuth::loginUserAndGetToken($user);

        return response()->json([
            'msg' => 'registered',
            'token' => $token
        ]);
    }

    public function login(Request $request)
    {
        $input = $request->only(['email', 'password']);

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
            $token = TokenAuth::loginUserAndGetToken($user);

            return response()->json([
                'msg' => 'logged in',
                'token' => $token
            ]);
        }
        else
        {
            return response()->json([
                'msg' => 'invalid email/password'
            ], 400);
        }
    }

    public function account(Request $request)
    {
        // middleware should allow access to this
        // action only when $request is logged-in using token

        $user = TokenAuth::getUserForAuthenticatedRequest($request);

        return response()->json([
            'user' => $user
        ]);
    }

    public function logout(Request $request)
    {
        TokenAuth::logoutAuthenticatedRequest($request);

        return response()->json([
            'msg' => 'done'
        ]);
    }
}