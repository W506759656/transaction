<?php

namespace Wding\Transcation\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider as IlluminateServiceProvider;
use Wding\Transcation\Console\Commands\Recharge\BCH;
use Wding\Transcation\Console\Commands\Recharge\BTC;
use Wding\Transcation\Console\Commands\Recharge\ERC20;
use Wding\Transcation\Console\Commands\Recharge\ETH;
use Wding\Transcation\Console\Commands\Recharge\LTC;
use Wding\Transcation\Console\Commands\Recharge\USDT;

class ServiceProvider extends IlluminateServiceProvider
{
    public function register()
    {

    }

    public function boot()
    {
        $this->apiRoutes();
        $this->loadCommand();
        $this->loadConfig();
        $this->loadMigration();
    }

    protected function apiRoutes()
    {
        Route::group([
            'prefix' => 'api',
            'namespace' => 'Wding\\Transcation\\Controllers',
            'middleware' => ['auth:api'],
        ], function ($router) {
            require __DIR__ . '/../Routes/api.php';
        });
    }

    protected function loadCommand()
    {
        $this->commands([
            BTC::class, BCH::class, ERC20::class, ETH::class, LTC::class, USDT::class
        ]);
    }

    public function loadConfig()
    {
        $this->publishes([
            __DIR__ . '/../config/wallet.php' => config_path('wallet.php'),
            __DIR__ . '/../config/erc20.php' => config_path('erc20.php'),
            __DIR__ . '/../config/trans_error.php' => config_path('trans_error.php'),
        ]);
    }

    public function loadMigration()
    {
        $this->publishes([
            __DIR__.'/../migrations/' => database_path('migrations')
        ], 'migrations');
    }
}