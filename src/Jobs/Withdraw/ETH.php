<?php

namespace Wding\transcation\Jobs\Withdraw;

use iBrand\EC\Open\Server\Services\ETHService;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Wding\transcation\Models\Export;

class ETH implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $export;

    /**
     * Create a new job instance.
     *
     * @param Export $export
     */
    public function __construct(Export $export)
    {
        $this->export = $export;
    }

    /**
     * Execute the job.
     *
     * @param ETHService $rpc
     * @return void
     */
    public function handle(ETHService $rpc)
    {
        if (in_array($this->export->status, [0, 2])) {
            return;
        }
        if ($this->export->hash !== null) {
            return;
        }

        $this->export->hash = 'pending';
        $this->export->save();

        $from = '0xCEd3764e55B4DFBb201D395bf6e0bFa0abbfc71e';
        $to = $this->export->to;
        $value = ether2wei($this->export->number - $this->export->fee);
        $hash = $rpc->personal_sendtranscation(compact('from', 'to', 'value'), config('wallet.ETH.password'));

        $this->export->hash = $hash;
        $this->export->save();
    }
}
