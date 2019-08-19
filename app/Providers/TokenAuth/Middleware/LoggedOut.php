<?php

namespace App\Providers\TokenAuth\Middleware;

use Illuminate\Http\Request;
use Closure;
use App\Providers\TokenAuth\Facade as TokenAuth;

class LoggedOut
{
    public function handle(Request $request, Closure $next)
    {
        $user = TokenAuth::getUserForAuthenticatedRequest($request);

        if ($user === null)
        {
            return $next($request);
        }
        else
        {
            return response()->json([
                'msg' => 'already logged in, forbidden'
            ], 403);
        }
    }
}