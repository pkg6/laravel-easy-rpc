<?php


if (!function_exists('rpcc')) {
    /**
     * @param $name
     * @return \Pkg6\Laravel\EasyRPC\Managers\ClientManager|\Pkg6\EasyRPC\Contracts\Client
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    function rpcc($name = "")
    {
        if ($name == "") {
            return app()->get(Pkg6\Laravel\EasyRPC\RPC::EASY_RPC_CLIENT);
        }
        return app()->get(Pkg6\Laravel\EasyRPC\RPC::EASY_RPC_CLIENT)->client($name);
    }
}

if (!function_exists('rpcs')) {
    /**
     * @param $name
     * @return \Pkg6\Laravel\EasyRPC\Managers\ServerManager|\Pkg6\EasyRPC\Contracts\Server
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    function rpcs($name = "")
    {
        if ($name == "") {
            return app()->get(Pkg6\Laravel\EasyRPC\RPC::EASY_RPC_SERVER);
        }
        return app()->get(Pkg6\Laravel\EasyRPC\RPC::EASY_RPC_SERVER)->server($name);
    }
}