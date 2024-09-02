<?php


namespace Pkg6\Laravel\EasyRPC\Handles\S;


use Illuminate\Support\Facades\Log;
use Pkg6\EasyRPC\Contracts\Server;
use Pkg6\EasyRPC\Contracts\SHandle;

class LogHandle implements SHandle
{

    public function handle(Server $server, $method, array $params, $result)
    {
        Log::debug("【Easy-RPC】Server ", compact('method', 'request', 'response'));
    }
}