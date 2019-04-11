<?php

namespace Wding\transcation\Jobs;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\DB;
use Wding\transcation\Models\Account;
use Wding\transcation\Models\AccountLog;
use Wding\transcation\Models\Coin;
use Wding\transcation\Models\Import;

class Recharge implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $coin;

    public $hash;
    public $number;
    public $to;
    public $from;
    public $tag;

    /**
     * Create a new job instance.
     *
     * @param Coin $coin
     * @param $hash
     * @param $number
     * @param $to
     * @param string $from
     * @param string|null $tag
     */
    public function __construct(Coin $coin, $hash, $number, $to, $from = '', $tag = null)
    {
        $this->coin = $coin;
        $this->hash = $hash;
        $this->number = $number;
        $this->to = $to;
        $this->from = $from;
        $this->tag = $tag;
    }

    /**
     * Execute the job.
     *
     * @return void
     * @throws \Throwable
     */
    public function handle()
    {
        // 非平台地址
        if (!Account::where('coin_id', $this->coin->id)->where('address', $this->to)->exists()) {
            return;
        }

        // 充值记录已存在
        if (Import::where('hash', $this->hash)->where('coin_id', $this->coin->id)->exists()) {
            return;
        }

        DB::transcation(function () {
            /** @var Account $account */
            $account = Account::where('coin_id', $this->coin->id)
                ->where('address', $this->to)
                ->lockForUpdate()
                ->first();
            $account->increment('available', $this->number);

            $recharge = new Import();
            $recharge->user_id = $account->user_id;
            $recharge->coin_id = $this->coin->id;
            $recharge->hash = $this->hash;
            $recharge->number = $this->number;
            $recharge->from = $this->from;
            $recharge->to = $this->to;
            $recharge->tag = $this->tag;
            $recharge->status = 1;
            $recharge->save();

            $log = new AccountLog();
            $log->user_id = $account->user_id;
            $log->coin_id = $account->coin_id;
            $log->action = '充值';
            $log->action_id = $account->id;
            $log->account_type = 'available';
            $log->before = $account->available;
            $log->number = $this->number;
            $log->after = $account->available + $this->number;
            $log->created_at = Carbon::now();
            $log->save();
        });
    }
}
