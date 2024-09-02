<?php

namespace Pkg6\Laravel\EasyRPC\Handles;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Pkg6\EasyRPC\Contracts\CHandle;
use Pkg6\EasyRPC\Contracts\Client;
use Pkg6\Laravel\EasyRPC\Traits\CHandleTrait;

class EasyRpcCallHistory extends Model
{
    use HasFactory;
    use CHandleTrait;

    const TERMINAL_CLIENT = 'client';
    const TERMINAL_SERVER = 'server';

    /**
     * @var string[]
     */
    protected $casts = [
        'config' => 'json',
        'request' => 'json',
        'response' => 'json',
    ];

    /**
     * @param $terminal
     * @param $name
     * @param $config
     * @param $method
     * @param $request
     * @param $response
     * @return EasyRpcCallHistory
     */
    public static function write($terminal, $name, $config, $method, $request, $response)
    {
        $db = new EasyRpcCallHistory;
        $db->terminal = $terminal;
        $db->name = $name;
        $db->config = $config;
        $db->method = $method;
        $db->request = $request;
        $db->response = $response;
        $db->save();
        return $db;
    }

    /**
     * @param $name
     * @param array $config
     * @param $method
     * @param array $request
     * @param array $response
     * @return EasyRpcCallHistory
     */
    public static function cWrite($name, array $config, $method, array $request, array $response)
    {
        return self::write(EasyRpcCallHistory::TERMINAL_CLIENT, $name, $config, $method, $request, $response);
    }

    /**
     * @param $method
     * @param array $request
     * @param array $response
     * @param $name
     * @param $config
     * @return EasyRpcCallHistory
     */
    public static function sWrite($method, array $request, array $response, $name = "", $config = [])
    {
        return self::write(EasyRpcCallHistory::TERMINAL_SERVER, $name, $config, $method, $request, $response);
    }
}
