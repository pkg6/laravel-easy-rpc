<?php


namespace Pkg6\Laravel\EasyRPC\Handles\C;


use Illuminate\Support\Facades\Log;
use Pkg6\EasyRPC\Contracts\CHandle;
use Pkg6\EasyRPC\Contracts\Client;

class LogHandle implements CHandle
{
    public function handle(Client $client, $method, array $request, $response)
    {
        Log::debug("【Easy-RPC】Client", compact('method', 'request', 'response'));
    }
}
