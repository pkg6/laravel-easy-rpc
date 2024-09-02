<?php

return [
    "server" => 'json',
    "servers" => [
        'json' => [
            'type' => \Pkg6\EasyRPC\JsonRPCHttp\Server::class,
            "objects" => [
                'testAdd' => function ($a, $b) {
                    return $a + $b;
                },
            ],
            "authentication" => [
                'user1' => 'password1',
                'user2' => 'password2'
            ]
        ],
        'hprose' => [
            'type' => \Pkg6\EasyRPC\HproseHttp\Server::class,
            "objects" => [
                'testAdd' => function ($a, $b) {
                    return $a + $b;
                },
            ],
        ],
    ],
    'client' => 'json',
    'clients' => [
        'json' => [
            'type' => \Pkg6\EasyRPC\JsonRPCHttp\Client::class,
            "url" => "http://127.0.0.1:8000/api/rpc/json",
            "username" => "user1",
            "password" => "password1",
        ],
        'hprose' => [
            'type' => \Pkg6\EasyRPC\HproseHttp\Client::class,
            "url" => "http://127.0.0.1:8000/api/rpc/json",
        ]
    ]
];