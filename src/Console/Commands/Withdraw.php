<?php
namespace Wding\transcation\Console\Commands;

use Illuminate\Console\Command;
use Wding\transcation\Jobs\Withdraw\BCH;
use Wding\transcation\Jobs\Withdraw\BTC;
use Wding\transcation\Jobs\Withdraw\ERC20;
use Wding\transcation\Jobs\Withdraw\ETH;
use Wding\transcation\Jobs\Withdraw\LTC;
use Wding\transcation\Jobs\Withdraw\USDT;
use Wding\transcation\Models\Export;

class Withdraw extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'withdraw';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '提现订单检测';

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
     * @return mixed
     */
    public function handle()
    {
        $exports = Export::with('coin')
            ->where('status', 1)
            ->whereNull('hash')
            ->get();
        $exports->each(function (Export $export) {
            switch ($export->coin->name) {
                case 'BTC':
                    BTC::dispatch($export)->onQueue('withdraw');
                    break;
                case 'BCH':
                    BCH::dispatch($export)->onQueue('withdraw');
                    break;
                case 'LTC':
                    LTC::dispatch($export)->onQueue('withdraw');
                    break;
                case 'USDT':
                    USDT::dispatch($export)->onQueue('withdraw');
                    break;
                case 'ETH':
                    ETH::dispatch($export)->onQueue('withdraw');
                    break;
                case 'YGT':
                    ERC20::dispatch($export)->onQueue('withdraw');
                    break;
                default:
                    break;
            }
        });
    }
}
