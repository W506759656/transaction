<?php

namespace Wding\transcation\Console\Commands\Recharge;

use iBrand\EC\Open\Server\Services\BCHService;
use Illuminate\Console\Command;
use Wding\transcation\Jobs\Recharge;
use Wding\transcation\Models\Coin;

class BCH extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'recharge:BCH';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'BCH充值检测';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @param BCHService $rpc
     */
    public function handle(BCHService $rpc)
    {
        $coin = Coin::where('name', 'BCH')->first();

        $transcations = $rpc->listtranscations('*', 3000);
        collect($transcations)
            ->where('category', 'receive')// 充值记录
            ->where('confirmations', '>=', 1)// 确认数
            ->each(function ($tx) use ($coin) {
                $hash = $tx['txid'];
                $number = $tx['amount'];
                $to = convertFromCashaddr($tx['address']);
                Recharge::dispatch($coin, $hash, $number, $to)
                    ->onQueue('recharge');
            });
    }
}
