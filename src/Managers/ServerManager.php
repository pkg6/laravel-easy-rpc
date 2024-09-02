<?php

namespace Pkg6\Laravel\EasyRPC\Managers;


use Illuminate\Support\Arr;
use Pkg6\EasyRPC\Contracts\Server;
use Pkg6\EasyRPC\Contracts\SHandle;
use Pkg6\Laravel\EasyRPC\RPC;
use RuntimeException;

class ServerManager
{

    /**
     * @var mixed
     */
    protected $name;
    /**
     * @var mixed
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
     * @var SHandle
     */
    protected $handle;

    public function __construct()
    {
        $this->name = config('easy-rpc.server', 'default');
        $this->config = config('easy-rpc.servers', []);
    }

    public function newServer(Server $server, $config)
    {
        if (!empty($config['authentications'])) {
            $server->withAuthentications(Arr::wrap($config['authentications']));
        }
        if (!empty($config['hosts'])) {
            $server->allowHosts(Arr::wrap($config['hosts']));
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
        if ($handle = $this->getHandle()) {
            $server->withHandle($handle);
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
        $typeOrObject = $this->getTypeClass($config);
        if (is_string($typeOrObject)) {
            throw new RuntimeException("Undefined " . $typeOrObject);
        }
        $this->initHandleByConfig($config);
        return $this->newServer($typeOrObject, $config);
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
        } elseif (isset(RPC::$serverTypes[$type])) {
            return new RPC::$serverTypes[$type];
        }
        return $type;
    }

    /**
     * @return SHandle|null
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
            if ($config['handle'] instanceof SHandle) {
                $this->handle = $config['handle'];
            } elseif (is_string($config['handle']) && class_exists($config['handle'])) {
                $this->handle = new $config['handle']();
            } elseif (isset(RPC::$cHandles[$config['handle']])) {
                $this->handle = RPC::$cHandles[$config['handle']];
            }
        }
    }


    public function __call($name, array $arguments)
    {
        return $this->server()->{$name}(...$arguments);
    }
}
