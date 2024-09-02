<?php

namespace Pkg6\Laravel\EasyRPC;

use Illuminate\Support\ServiceProvider;

class RPCServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $configSource = realpath(__DIR__ . '/../config/easy-rpc.php');
        $this->publishes([$configSource => config_path('easy-rpc.php')]);
    }

    public function register()
    {
        $this->app->singleton('laravel.open.rpc.client', function () {
            return new ClientManager(config('easy-rpc.client', 'default'), config('easy-rpc.clients', []));
        });
        $this->app->singleton('laravel.open.rpc.server', function () {
            return new ClientManager(config('easy-rpc.server', 'default'), config('easy-rpc.servers', []));
        });
    }
}