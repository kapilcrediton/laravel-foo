<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Validator;
use Hash;
use Str;
use Cache;
use Response;
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
            return Response::json($validator->errors(), 400);
        }

        // salted password encryption before saving
        $input['password'] = Hash::make($input['password']);

        $user = (new User())->fill($input);
        $user->save();

        $token = TokenAuth::loginUserAndGetToken($user);

        return Response::json([
            'msg' => 'registered',
            'token' => $token,
            'user' => $user
        ], 200);
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
            return Response::json($validator->errors(), 400);
        }

        $user = User::where('email', $input['email'])->first();
        $success = Hash::check($input['password'], $user->password);

        if ($success)
        {
            $token = TokenAuth::loginUserAndGetToken($user);

            return Response::json([
                'msg' => 'logged in',
                'token' => $token,
                'user' => $user
            ]);
        }
        else
        {
            return Response::json([
                'msg' => 'invalid email/password'
            ], 400);
        }
    }

    public function account(Request $request)
    {
        // $user = TokenAuth::getUserForAuthenticatedRequest($request);
        $user = $request->user();

        return Response::json([
            'user' => $user
        ]);
    }

    public function logout(Request $request)
    {
        // TokenAuth::logoutAuthenticatedRequest($request);
        $user = $request->user();

        return Response::json([
            'msg' => 'done'
        ]);
    }
}