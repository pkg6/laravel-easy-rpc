<?php

namespace Pkg6\Laravel\EasyRPC\Handles\C;

use Pkg6\EasyRPC\Contracts\CHandle;
use Pkg6\EasyRPC\Contracts\Client;
use Pkg6\Laravel\EasyRPC\Handles\EasyRpcCallHistory;
use Pkg6\Laravel\EasyRPC\Traits\CHandleTrait;

class ORMHandle implements CHandle
{
    use CHandleTrait;

    public function handle(Client $client, $method, array $params, $result)
    {
        return EasyRpcCallHistory::cWrite($this->rpcName, $this->rpcConfig, $method, $params, $result);
    }
}
