<?php

namespace Wding\Transcation\Console\Commands\Recharge;

use iBrand\EC\Open\Server\Services\BTCService;
use Illuminate\Console\Command;
use Wding\Transcation\Jobs\Recharge;
use Wding\Transcation\Models\Coin;

class BTC extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'recharge:BTC';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'BTC充值检测';

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
     * @param BTCService $rpc
     */
    public function handle(BTCService $rpc)
    {
        $coin = Coin::where('name', 'BTC')->first();

        $Transcations = $rpc->listTranscations('*', 3000);
        collect($Transcations)
            ->where('category', 'receive')// 充值记录
            ->where('confirmations', '>=', 1)// 确认数
            ->each(function ($tx) use ($coin) {
                Recharge::dispatch($coin, $tx['txid'], $tx['amount'], $tx['address'])
                    ->onQueue('recharge');
            });
    }
}
