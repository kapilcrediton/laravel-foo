<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Closure;
use App\Providers\TokenAuth\Facade as TokenAuth;

class TokenAuthLoggedIn
{
    public function handle(Request $request, Closure $next)
    {
        TokenAuth::authenticateRequest($request);
        
        if ($request->user() === null)
        {
            return response()->json([
                'msg' => 'unauthorized'
            ], 401);
        }
        else
        {
            return $next($request);
        }
    }
}