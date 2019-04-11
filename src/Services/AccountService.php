<?php

namespace Wding\Transaction\Services;
use iBrand\EC\Open\Server\Services\BCHService;
use iBrand\EC\Open\Server\Services\BTCService;
use iBrand\EC\Open\Server\Services\ETHService;
use iBrand\EC\Open\Server\Services\LTCService;
use iBrand\EC\Open\Server\Services\USDTService;

/**
 * Created by PhpStorm.
 * User: wangding
 * Date: 2019/3/28
 * Time: 上午10:13
 */
class AccountService
{
    use \Wding\Transaction\Traits\Response;

    /***
     * @param $account
     * @param $number
     * @return mixed
     */
    public function exportCheck($account, $number)
    {
        if(!$account->coin->is_export)
        {
            return $this->failed('该币种不支持提现');
        }
        $this->accountCheck($account, $number);
    }


    /***
     * @param $account
     * @param $number
     */
    public function accountCheck($account, $number)
    {
        if($number <= 0){
            return $this->failed('提现金额不能小于0');
        }
        if($account->available < $number){
            return $this->failed('钱包金额不足');
        }
        if($account->user_id != \Auth::user()->id){
            return $this->failed('网络异常');
        }
    }

    /***
     * @param $export
     */
    public function cancelExportCheck($export)
    {
        if($export->status != 0)
        {
            return $this->failed('网络异常');
        }
        if($export->user_id != \Auth::user()->id){
            return $this->failed('网络异常');
        }
    }

    /***
     * 获取地址
     * @param $coin
     * @return null|string
     */
    public function getAddress($coin)
    {
        $user = \Auth::user();
        switch ($coin) {
            case 'BTC':
                $address = (new BTCService())->getnewaddress((string)$user->id);
                break;
            case 'USDT':
                $address = (new USDTService())->getnewaddress((string)$user->id);
                break;
            case 'BCH':
                $address = (new BCHService())->getnewaddress((string)$user->id);
                $address = convertFromCashaddr($address);
                break;
            case 'LTC':
                $address = (new LTCService())->getnewaddress((string)$user->id);
                break;
            case 'ETH':
            case 'YGT':
                $address = (new ETHService())->personal_newAccount(config('wallet.ETH.password'));
                break;
            default:
                $address = null;
                break;
        }
        return $address;
    }



}