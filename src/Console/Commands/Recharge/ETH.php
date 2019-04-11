<?php

namespace Wding\Transaction\Console\Commands\Recharge;

use iBrand\EC\Open\Server\Services\ETHService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Wding\Transaction\Jobs\Recharge;
use Wding\Transaction\Models\Coin;

class ETH extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'recharge:ETH';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'ETH充值检测';

    /**
     * Create a new command instance.
     *
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @param ETHService $rpc
     */
    public function handle(ETHService $rpc)
    {
        $coin = Coin::where('name', 'ETH')->first();

        $lastBlock = hex2num($rpc->eth_blockNumber());

        if (Cache::has('ETH:blockNumber')) {
            $blockNumber = Cache::get('ETH:blockNumber');
        } else {
            $blockNumber = 7113171; // 2019-01-23 17:27:14
            Cache::forever('ETH:blockNumber', $blockNumber);
        }

        if ($lastBlock > $blockNumber) {
            $block = $rpc->eth_getBlockByNumber(num2hex($blockNumber + 1), true);
            collect($block['transactions'])
                ->where('to', '!=', null)
                ->where('value', '!=', '0x0')
                ->each(function ($tx) use ($coin) {
                    $number = wei2ether($tx['value']);
                    Recharge::dispatch($coin, $tx['hash'], $number, $tx['to'], $tx['from'])
                        ->onQueue('recharge:ETH');
                });
            Cache::forever('ETH:blockNumber', $blockNumber + 1);
        }
    }
}
