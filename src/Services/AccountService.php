<?php

namespace Wding\transcation\Services;
use Wding\Transcatin\Services\BCHService;
use Wding\Transcatin\Services\BTCService;
use Wding\Transcatin\Services\ETHService;
use Wding\Transcatin\Services\LTCService;
use Wding\Transcatin\Services\USDTService;

/**
 * Created by PhpStorm.
 * User: wangding
 * Date: 2019/3/28
 * Time: 上午10:13
 */
class AccountService
{
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