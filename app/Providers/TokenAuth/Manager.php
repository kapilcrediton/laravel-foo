<?php

namespace App\Providers\TokenAuth;

use App\User;
use Illuminate\Http\Request;
use Str;
use Cache;
use Config;

class Manager
{
    public function loginUserAndGetToken(User $user)
    {
        $token = Str::random(72);
        Cache::put($token, $user->id, Config::get('auth.token_lifetime'));
        return $token;
    }

    public function authenticateRequest(Request $request)
    {
        $token = $request->header('auth-token');
        $userId = Cache::get($token, null);
        $user = $userId ? User::where('id', $userId)->first() : null;

        if ($user) {
            $request->setUserResolver(function () use ($user) {
                return $user;
            });
        }
    }

    public function logoutAuthenticatedRequest(Request $request)
    {
        $token = $request->header('auth-token');
        Cache::forget($token);
    }
}