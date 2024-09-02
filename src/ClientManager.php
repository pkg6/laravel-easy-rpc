<?php

namespace Pkg6\Laravel\EasyRPC;

use Illuminate\Support\Arr;
use Pkg6\EasyRPC\Contracts\Client;
use RuntimeException;

class ClientManager
{
    protected $types = [
        'hprose' => \Pkg6\EasyRPC\HproseHttp\Client::class,
        'json' => \Pkg6\EasyRPC\JsonRPCHttp\Client::class,
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

    public function newClient(Client $client, $username = "", $password = "")
    {
        if ($username && $password) {
            $client->withAuthentication($username, $password);
        }
        return $client;
    }

    public function client($name = "")
    {
        if ($name === "") {
            $name = $this->name;
        }
        if (!isset($this->config[$name])) {
            throw new \InvalidArgumentException("not find config key $name");
        }
        $config = $this->config[$name];
        if (empty($config['url'])) {
            throw new \InvalidArgumentException("not find config key url");
        }
        $type = Arr::get($config, 'type');
        if (class_exists($type)) {
            $clientObject = new $type();
        } elseif (isset($this->types[$type])) {
            $clientObject = new $this->types[$type];
        }
        if (!isset($clientObject)) {
            throw new RuntimeException("Undefined " . $type);
        }
        $clientObject->withURL($config['url']);
        return $this->newClient($clientObject, Arr::get($config, 'username', ''), Arr::get($config, 'password', ''));
    }

    public function __call($name, array $arguments)
    {
        return $this->client()->{$name}(...$arguments);
    }
}