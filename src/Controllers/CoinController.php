<?php

namespace Wding\Transaction\Controllers;

use Wding\Transaction\Models\Account;
use Wding\Transaction\Models\Coin;
use Wding\Transaction\Services\AccountService;

/**
 * Created by PhpStorm.
 * User: wangding
 * Date: 2019/3/28
 * Time: 上午9:44
 */
class CoinController extends Controller
{
    /***
     * 获取钱包地址
     * @param $coin_id
     * @return \Dingo\Api\Http\Response|mixed
     */
    public function getAddress($coin_id)
    {
        $account = Account::where('user_id', \Auth::user()->id)->where('coin_id', $coin_id)->first();
        if($account->address == ''){
            try{
                $address = (new AccountService())->getAddress($account->coin->name);
                if($address != ''){
                    $account->address = $address;
                    $account->save();
                }
            }catch (\Exception $e){
                \Log::error($e->getMessage());
            }
        }
        $data['address'] = $account->address;
        return $this->success($data);
    }


    public function lst()
    {
        $coins = Coin::all();
        return $this->success($coins);
    }
}