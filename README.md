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
php artisan vendor:publish --tag="easy-rpc"

php artisan migrate --path=database/migrations/2024_12_09_100107_create_easy_rpc_call_histories_table.php
~~~

### 客户端使用

~~~
\Pkg6\Laravel\EasyRPC\Facades\RPCC::testAdd(1,2);
\Pkg6\Laravel\EasyRPC\Facades\RPCC::testSubtraction(1,2);
\Pkg6\Laravel\EasyRPC\Facades\RPCC::testMultiplication(1,2);
\Pkg6\Laravel\EasyRPC\Facades\RPCC::client("default")->testAdd(1,2);


rpcc()->testAdd(1,2);
rpcc()->testSubtraction(1,2);
rpcc()->testMultiplication(1,2);
rpcc("default")->testAdd(1,2);
~~~

