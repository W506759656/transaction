<?php

namespace Wding\Transaction\Jobs\Withdraw;

use iBrand\EC\Open\Server\Services\BCHService;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Wding\Transaction\Models\Export;

class BCH implements ShouldQueue
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
     * @param BCHService $rpc
     * @return void
     */
    public function handle(BCHService $rpc)
    {
        if (in_array($this->export->status, [0, 2])) {
            return;
        }
        if ($this->export->hash !== null) {
            return;
        }

        $this->export->hash = 'pending';
        $this->export->save();

        $address = $this->export->to;
        $number = $this->export->number - $this->export->fee;
        $hash = $rpc->sendtoaddress($address, (string)$number);

        $this->export->hash = $hash;
        $this->export->save();
    }
}
