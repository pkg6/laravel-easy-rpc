<?php

namespace Pkg6\Laravel\EasyRPC\Traits;

trait CHandleTrait
{
    protected $rpcName = 'easy-rpc';
    protected $rpcConfig = [];

    public function withRpcName(string $rpcName): void
    {
        $this->rpcName = $rpcName;
    }

    public function withRpcConfig(array $rpcConfig): void
    {
        $this->rpcConfig = $rpcConfig;
    }
}
