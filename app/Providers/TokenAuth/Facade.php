<?php

namespace App\Providers\TokenAuth;

use Illuminate\Support\Facades\Facade as IlluminateFacade;

class Facade extends IlluminateFacade
{
    protected static function getFacadeAccessor()
    {
        return 'app.tokenAuth';
    }
}