### laravel-easy-rpc
~~~
"repositories": [
    {"type": "vcs", "url": "https://github.com/pkg6/laravel-easy-rpc.git" }
],
~~~


### 安装

~~~
composer require pkg6/laravel-easy-rpc
~~~

### 在 `config/app.php` 注册

~~~
'providers' => [
    .....
    \Pkg6\Laravel\EasyRPC\EasyRPCServiceProvider::class
]

php artisan vendor:publish --provider="\Pkg6\Laravel\EasyRPC\EasyRPCServiceProvider::class"
~~~

### 启动http服务

~~~
Pkg6\Laravel\EasyRPC\Facades\RPCS::start();
~~~



### 客户端使用

~~~
\Pkg6\Laravel\EasyRPC\Facades\RPCC::testAdd(1,2);
\Pkg6\Laravel\EasyRPC\Facades\RPCC::testSubtraction(1,2);
\Pkg6\Laravel\EasyRPC\Facades\RPCC::testMultiplication(1,2);
\Pkg6\Laravel\EasyRPC\Facades\RPCC::client("default")->testAdd(1,2);
~~~

