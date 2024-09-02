<?php

namespace Pkg6\Laravel\EasyRPC\Managers;

use Illuminate\Support\Arr;
use Pkg6\EasyRPC\Contracts\CHandle;
use Pkg6\EasyRPC\Contracts\Client;
use Pkg6\Laravel\EasyRPC\RPC;
use RuntimeException;

class ClientManager
{
    /**
     * @var string
     */
    protected $name;
    /**
     * @var array
     */
    protected $config = [];

    /**
     * @var string
     */
    protected $runName = '';
    /**
     * @var array
     */
    protected $runConfig = [];

    /**
     * @var CHandle|null
     */
    protected $handle = null;

    /**
     * ClientManager constructor.
     */
    public function __construct()
    {
        $this->name = config('easy-rpc.client', 'default');
        $this->config = config('easy-rpc.clients', []);
    }

    /**
     * @param Client $client
     * @param $url
     * @param string $username
     * @param string $password
     * @return Client
     */
    public function newClient(Client $client, $url, $username = "", $password = "")
    {
        $class = get_class($client);
        $this->runConfig = compact('class', 'url', 'url', 'password');
        $client->withURL($url);
        if ($username && $password) {
            $client->withAuthentication($username, $password);
        }

        if ($handle = $this->getHandle()) {
            $client->withHandle($handle);
        }
        return $client;
    }

    /**
     * @param $url
     * @param string $username
     * @param string $password
     * @return Client
     */
    public function newJSONClient($url, $username = "", $password = "")
    {
        $client = new \Pkg6\EasyRPC\JsonRPCHttp\Client;
        return $this->newClient($client, $url, $username, $password);
    }

    /**
     * @param $url
     * @param string $username
     * @param string $password
     * @return Client
     */
    public function newHproseClient($url, $username = "", $password = "")
    {
        $client = new  \Pkg6\EasyRPC\HproseHttp\Client;
        return $this->newClient($client, $url, $username, $password);
    }


    /**
     * @param string $name
     * @return Client
     */
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
        $typeOrObject = $this->getTypeClass($config);
        if (is_string($typeOrObject)) {
            throw new RuntimeException("Undefined " . $typeOrObject);
        }
        $this->initHandleByConfig($config);
        $this->name = $name;
        $this->runName = $name;
        return $this->newClient($typeOrObject,
            Arr::get($config, 'url', ''),
            Arr::get($config, 'username', ''),
            Arr::get($config, 'password', ''));
    }

    /**
     * @param $config
     * @return array|\ArrayAccess|mixed
     */
    protected function getTypeClass($config)
    {
        $type = Arr::get($config, 'type');
        if (is_string($type) && class_exists($type)) {
            return new $type();
        } elseif (isset(RPC::$clientTypes[$type])) {
            return new RPC::$clientTypes[$type];
        }
        return $type;
    }

    /**
     * @return CHandle|null
     */
    protected function getHandle()
    {
        $handle = $this->handle;
        if (!is_null($handle)) {
            if (method_exists($handle, 'withRpcName')) {
                $handle->withRpcName($this->runName);
            }
            if (method_exists($handle, 'withRpcConfig')) {
                $handle->withRpcConfig($this->runConfig);
            }
            return $handle;
        }
        return null;
    }

    /**
     * @param $config
     */
    protected function initHandleByConfig($config)
    {
        if (!empty($config['handle'])) {
            if ($config['handle'] instanceof CHandle) {
                $this->handle = $config['handle'];
            } elseif (is_string($config['handle']) && class_exists($config['handle'])) {
                $this->handle = new $config['handle']();
            } elseif (isset(RPC::$cHandles[$config['handle']])) {
                $this->handle = RPC::$cHandles[$config['handle']];
            }
        }
    }

    /**
     * @param $name
     * @param array $arguments
     * @return mixed
     */
    public function __call($name, array $arguments)
    {
        return $this->client()->{$name}(...$arguments);
    }
}
