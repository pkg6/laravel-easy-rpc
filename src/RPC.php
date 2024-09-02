<?php

namespace Pkg6\Laravel\EasyRPC;


final class RPC
{
    const EASY_RPC_CLIENT = 'laravel.easy.rpc.client';
    const EASY_RPC_SERVER = 'laravel.easy.rpc.server';
    public static $clientTypes = [
        'hprose' => \Pkg6\EasyRPC\HproseHttp\Client::class,
        'json' => \Pkg6\EasyRPC\JsonRPCHttp\Client::class,
    ];

    public static $serverTypes = [
        'hprose' => \Pkg6\EasyRPC\HproseHttp\Server::class,
        'json' => \Pkg6\EasyRPC\JsonRPCHttp\Server::class,
    ];

    public static $cHandles = [
        'log' => \Pkg6\Laravel\EasyRPC\Handles\C\LogHandle::class,
        'orm' => \Pkg6\Laravel\EasyRPC\Handles\C\ORMHandle::class,
    ];


    public static $sHandles = [
        'log' => \Pkg6\Laravel\EasyRPC\Handles\S\LogHandle::class,
        'orm' => \Pkg6\Laravel\EasyRPC\Handles\S\ORMHandle::class,
    ];
}
