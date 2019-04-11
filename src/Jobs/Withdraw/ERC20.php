<?php

namespace Wding\Transcation\Jobs\Withdraw;

use iBrand\EC\Open\Server\Services\ETHService;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Wding\Transcation\Models\Export;

class ERC20 implements ShouldQueue
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

        $contract = $this->getContractInfoByName($this->export->coin->name);

        $from = '0xCEd3764e55B4DFBb201D395bf6e0bFa0abbfc71e';
        $to = $contract['address'];
        $data = '0xa9059cbb000000000000000000000000';
        $data .= str_pad(substr($this->export->to, 2), 40, '0', STR_PAD_RIGHT);
        $data .= str_pad(substr(ether2wei($this->export->number - $this->export->fee, $contract['decimal']), 2), 64, '0', STR_PAD_LEFT);
        $hash = $rpc->personal_sendTranscation(compact('from', 'to', 'data'), config('wallet.ETH.password'));

        $this->export->hash = $hash;
        $this->export->save();
    }

    public function getContractInfoByName($name)
    {
        $contracts = [];
        foreach (config('erc20') as $address => $info) {
            $contracts[$info['name']] = [
                'address' => $address,
                'decimal' => $info['decimal'],
            ];
        }

        return $contracts[$name];
    }
}
