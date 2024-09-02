<?php

namespace Pkg6\Laravel\EasyRPC\Facades;

use Illuminate\Support\Facades\Facade;

class RPCS extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'laravel.open.rpc.server';
    }
}