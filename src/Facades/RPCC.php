<?php

namespace Pkg6\Laravel\EasyRPC\Facades;

use Illuminate\Support\Facades\Facade;
use Pkg6\EasyRPC\Contracts\Client;
use Pkg6\Laravel\EasyRPC\RPC;

/**
 * @method static \JsonRPC\Client|Client newJSONClient($url, $username = "", $password = "")
 * @method static \Hprose\Client|Client newHproseClient($url, $username = "", $password = "")
 * @method static Client client($name = "")
 */
class RPCC extends Facade
{
    protected static function getFacadeAccessor()
    {
        return RPC::EASY_RPC_CLIENT;
    }
}
