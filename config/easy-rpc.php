<?php

return [
    "route" => 'easy-rpc/start',

    "server" => 'json',
    "servers" => [
        'json' => [
            'type' => 'json',
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
            'type' => 'hprose',
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
            'type' => 'json',
            "url" => "http://127.0.0.1:8000/easy-rpc/start",
            "username" => "user1",
            "password" => "password1",
            "handle" => 'orm',
        ],
        'hprose' => [
            'type' => 'hprose',
            "url" => "http://127.0.0.1:8000/easy-rpc/start",
            "handle" => 'log',
        ]
    ]
];
