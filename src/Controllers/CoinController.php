<?php

namespace Wding\transcation\Controllers;

use Wding\transcation\Models\Account;
use Wding\transcation\Models\Coin;
use Wding\transcation\Models\Setting;
use Wding\transcation\Services\AccountService;

/**
 * Created by PhpStorm.
 * User: wangding
 * Date: 2019/3/28
 * Time: 上午9:44
 */
class CoinController extends Controller
{
    /***
     * 获取钱包列表
     */
    public function index()
    {
        $accounts = Account::where('user_id', \Auth::user()->id)->with(['coin' => function($query){
            $query->select('name', 'id', 'market_name', 'img');
        }])->get()->toArray();
        $all_all_available = 0;
        foreach ($accounts as &$v){
            if($v['coin']['name'] == 'YGT'){
                $v['price'] = (string)(Setting::where('key', 'ygt_price')->value('value'));
                $v['all_price'] = (string)($v['price'] * $v['available']);
            }else{
                $v['price'] = (string)(\Cache::get($v['coin']['market_name'])['qc_price']);
                $v['all_price'] = (string)($v['price'] * $v['available']);
            }
            $all_all_available += (float)$v['all_price'];
        }
        $data['accounts'] = $accounts;
        $data['all_available'] = (string)$all_all_available;
        return $this->array($data);
    }

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
        return $this->array($data);
    }


    public function lst()
    {
        $coins = Coin::all();
        return $this->array($coins);
    }
}