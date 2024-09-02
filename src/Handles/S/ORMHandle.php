<?php


namespace Pkg6\Laravel\EasyRPC\Handles\S;


use Pkg6\EasyRPC\Contracts\Server;
use Pkg6\EasyRPC\Contracts\SHandle;
use Pkg6\Laravel\EasyRPC\Handles\EasyRpcCallHistory;
use Pkg6\Laravel\EasyRPC\Traits\CHandleTrait;

class ORMHandle implements SHandle
{
    use CHandleTrait;

    public function handle(Server $server, $method, array $params, $result)
    {
        return EasyRpcCallHistory::sWrite($method, $params, $result, $this->rpcName, $this->rpcConfig);
    }
}