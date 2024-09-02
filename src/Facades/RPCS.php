<?php

namespace Pkg6\Laravel\EasyRPC\Facades;

use Illuminate\Support\Facades\Facade;
use Pkg6\Laravel\EasyRPC\RPC;

/**
 * @method static mixed start()
 */
class RPCS extends Facade
{
    protected static function getFacadeAccessor()
    {
        return RPC::EASY_RPC_SERVER;
    }
}
