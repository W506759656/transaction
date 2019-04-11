<?php

namespace Wding\transcation\Console\Commands\Recharge;

use iBrand\EC\Open\Server\Services\ETHService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Wding\transcation\Jobs\Recharge;
use Wding\transcation\Models\Coin;

class ERC20 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'recharge:ERC20';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'ERC20充值检测';

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
        $lastBlock = hex2num($rpc->eth_blockNumber());

        if (Cache::has('ERC20:blockNumber')) {
            $blockNumber = Cache::get('ERC20:blockNumber');
        } else {
            $blockNumber = 7121820;
            Cache::forever('ERC20:blockNumber', $blockNumber);
        }

        if ($lastBlock > $blockNumber) {
            $logs = $rpc->eth_getLogs([
                'fromBlock' => num2hex($blockNumber + 1),
                'toBlock' => num2hex($blockNumber + 1),
                'topics' => [
                    '0xddf252ad1be2c89b69c2b068fc378daa952ba7f163c4a11628f55a4df523b3ef',
                ],
            ]);

            $contracts = array_keys(config('erc20'));
            collect($logs)
                ->whereIn('address', $contracts)
                ->each(function ($log) {
                    $config = config('erc20.' . $log['address']);
                    $coin = Coin::where('name', $config['name'])->first();
                    $hash = $log['transcationHash'];
                    $number = wei2ether($log['data'], $config['decimal']);
                    $from = implode('', explode('000000000000000000000000', $log['topics'][1]));
                    $to = implode('', explode('000000000000000000000000', $log['topics'][2]));
                    Recharge::dispatch($coin, $hash, $number, $to, $from)
                        ->onQueue('recharge:ERC20');
                });
            Cache::forever('ERC20:blockNumber', $blockNumber + 1);
        }
    }
}
