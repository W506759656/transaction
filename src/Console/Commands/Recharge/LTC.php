<?php

namespace Wding\Transaction\Console\Commands\Recharge;

use iBrand\EC\Open\Server\Services\LTCService;
use Illuminate\Console\Command;
use Wding\Transaction\Jobs\Recharge;
use Wding\Transaction\Models\Coin;

class LTC extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'recharge:LTC';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'LTC充值检测';

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
     * @param LTCService $rpc
     */
    public function handle(LTCService $rpc)
    {
        $coin = Coin::where('name', 'LTC')->first();

        $transactions = $rpc->listtransactions('*', 3000);
        collect($transactions)
            ->where('category', 'receive')// 充值记录
            ->where('confirmations', '>=', 1)// 确认数
            ->each(function ($tx) use ($coin) {
                $hash = $tx['txid'];
                $number = $tx['amount'];
                $to = $tx['address'];
                Recharge::dispatch($coin, $hash, $number, $to)
                    ->onQueue('recharge');
            });
    }
}
