<?php

namespace Wding\Transcation\Jobs\Withdraw;

use iBrand\EC\Open\Server\Services\USDTService;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Wding\Transcation\Models\Export;

class USDT implements ShouldQueue
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
     * @param USDTService $rpc
     * @return void
     */
    public function handle(USDTService $rpc)
    {
        if (in_array($this->export->status, [0, 2])) {
            return;
        }
        if ($this->export->hash !== null) {
            return;
        }

        $this->export->hash = 'pending';
        $this->export->save();

        $fromAddress = '1Gifs2Bnc4Pr8HfZ72f4xQo6WMcbTX56fT';
        $toAddress = $this->export->to;
        $id = 31;
        $number = $this->export->number - $this->export->fee;
        $feeAddress = $fromAddress;
        $hash = $rpc->omni_funded_send($fromAddress, $toAddress, $id, (string)$number, $feeAddress);

        $this->export->hash = $hash;
        $this->export->save();
    }
}
