<?php

namespace Pkg6\Laravel\EasyRPC;


use Illuminate\Support\Arr;
use Pkg6\EasyRPC\Contracts\Server;
use RuntimeException;

class ServerManager
{
    protected $types = [
        'hprose' => \Pkg6\EasyRPC\HproseHttp\Server::class,
        'json' => \Pkg6\EasyRPC\JsonRPCHttp\Server::class,
    ];
    /**
     * @var mixed
     */
    protected $name;
    /**
     * @var mixed
     */
    protected $config = [];

    public function __construct($name, $config)
    {
        $this->name = $name;
        $this->config = array_merge($this->config, $config);
    }

    public function newServer(Server $server, $config)
    {
        if (!empty($config['authentications'])) {
            $server->withAuthentications($config['authentications']);
        }
        if (!empty($config['hosts'])) {
            $server->allowHosts($config['hosts']);
        }
        if (isset($config['objects'])) {
            foreach (Arr::wrap($config['objects']) as $method => $object) {
                if (is_callable($object)) {
                    $server->addCallback($method, $object);
                }
                if (is_string($object) && class_exists($object)) {
                    $server->addObjectClass($object);
                }
            }
        }
        return $server;
    }

    public function server($name = "")
    {
        if ($name === "") {
            $name = $this->name;
        }
        if (!isset($this->config[$name])) {
            throw new \InvalidArgumentException("not find config key $name");
        }
        $config = $this->config[$name];
        $type = Arr::get($config, 'type');
        if (class_exists($type)) {
            $serverObject = new $type();
        } elseif (isset($this->types[$type])) {
            $serverObject = new $this->types[$type];
        }
        if (!isset($serverObject)) {
            throw new RuntimeException("Undefined " . $type);
        }
        return $this->newServer($serverObject, $config);
    }
    public function __call($name, array $arguments)
    {
        return $this->server()->{$name}(...$arguments);
    }
}