<?php

namespace Wding\transcation\Console\Commands\Recharge;

use iBrand\EC\Open\Server\Services\USDTService;
use Illuminate\Console\Command;
use Wding\transcation\Jobs\Recharge;
use Wding\transcation\Models\Coin;

class USDT extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'recharge:USDT';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'USDT充值检测';

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
     * @param USDTService $rpc
     */
    public function handle(USDTService $rpc)
    {
        $coin = Coin::where('name', 'USDT')->first();

        $transcations = $rpc->omni_listtranscations('*', 3000);
        collect($transcations)
            ->where('confirmations', '>=', 1)// 确认数
            ->each(function ($tx) use ($coin) {
                $hash = $tx['txid'];
                $number = $tx['amount'];
                $to = $tx['referenceaddress'];
                $from = $tx['sendingaddress'];
                Recharge::dispatch($coin, $hash, $number, $to, $from)
                    ->onQueue('recharge');
            });
    }
}
