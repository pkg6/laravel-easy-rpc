<?php

namespace Pkg6\Laravel\EasyRPC;

use Illuminate\Support\ServiceProvider;
use Pkg6\Laravel\EasyRPC\Facades\RPCS;
use Pkg6\Laravel\EasyRPC\Managers\ClientManager;
use Pkg6\Laravel\EasyRPC\Managers\ServerManager;

class EasyRPCServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            realpath(__DIR__ . '/../config/easy-rpc.php') => config_path('easy-rpc.php'),
            __DIR__ . '/../database/migrations' => database_path('migrations'),
        ],'easy-rpc');

        $this->bootRoute();
    }

    public function bootRoute()
    {
        $route = config('easy-rpc.route', 'easy-rpc/start');
        if ($route) {
            $this->app->router->any($route, function () {
                return RPCS::start();
            });
        }
    }

    public function register()
    {
        $this->app->singleton(RPC::EASY_RPC_CLIENT, function () {
            return new ClientManager();
        });
        $this->app->singleton(RPC::EASY_RPC_SERVER, function () {
            return new ServerManager();
        });
    }
}
