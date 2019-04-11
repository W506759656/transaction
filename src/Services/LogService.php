<?php
/**
 * Created by PhpStorm.
 * User: wangding
 * Date: 2019/3/28
 * Time: 上午10:38
 */

namespace Wding\Transcation\Services;


use Carbon\Carbon;
use Wding\Transcation\Models\AccountLog;

class LogService
{
    /***
     * 提现记录
     * @param $account
     * @param $number
     */
    public function exportLog($account, $number)
    {
        $log = new AccountLog();
        $log->user_id = $account->user_id;
        $log->coin_id = $account->coin_id;
        $log->action = '提现';
        $log->action_id = $account->id;
        $log->account_type = 'available';
        $log->before = $account->available;
        $log->number = 0 - $number;
        $log->after = $account->available - $number;
        $log->created_at = Carbon::now();
        $log->save();

        $log = new AccountLog();
        $log->user_id = $account->user_id;
        $log->coin_id = $account->coin_id;
        $log->action = '提现';
        $log->action_id = $account->id;
        $log->account_type = 'disabled';
        $log->before = $account->disabled;
        $log->number = $number;
        $log->after = $account->disabled + $number;
        $log->created_at = Carbon::now();
        $log->save();
    }

    /***
     * 取消提现记录
     * @param $account
     * @param $number
     */
    public static function cancelExportLog($account, $number)
    {
        $log = new AccountLog();
        $log->user_id = $account->user_id;
        $log->coin_id = $account->coin_id;
        $log->action = '撤销提现';
        $log->action_id = $account->id;
        $log->account_type = 'available';
        $log->before = $account->available;
        $log->number = $number;
        $log->after = $account->available + $number;
        $log->created_at = Carbon::now();
        $log->save();
    }
}