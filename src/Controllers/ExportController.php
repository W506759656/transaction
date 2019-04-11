<?php

namespace Wding\Transaction\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Wding\Transaction\Models\Account;
use Wding\Transaction\Models\Export;
use Wding\Transaction\Models\ExportAddress;
use Wding\Transaction\Models\Import;
use Wding\Transaction\Models\Setting;
use Wding\Transaction\Requests\ExportRequest;
use Wding\Transaction\Services\AccountService;
use Wding\Transaction\Services\LogService;
use Wding\Transaction\Transforms\ExportTransform;
use Wding\Transaction\Transforms\ImportTransform;

/**
 * Created by PhpStorm.
 * User: wangding
 * Date: 2019/3/28
 * Time: 上午9:44
 */
class ExportController extends Controller
{
    /***
     * 提现
     * @param ExportRequest $request
     * @return \Illuminate\Http\Response
     */
    public function doExport(ExportRequest $request)
    {
        $number = $request->input('number');
        if (!\Hash::check($request->input('pay_password'), Auth::user()->pay_password)) {
            return $this->failed('交易密码错误');
        }
        $address_id = $request->input('address_id');
        $address = ExportAddress::find($address_id);
        $coin_id = $request->input('coin_id');
        $account = Account::where('user_id', Auth::user()->id)->where('coin_id', $coin_id)->first();
        if (!$account) {
            return $this->failed('钱包不存在');
        }
        if (!$account->coin->is_export) {
            return $this->failed('该币种不支持提现');
        }
        if ($number <= 0) {
            return $this->failed('提现金额不能小于0');
        }
        if ($account->available < $number) {
            return $this->failed('钱包金额不足');
        }
        if ($account->user_id != \Auth::user()->id) {
            return $this->failed('网络异常');
        }
        $export_rate = Setting::where('key', 'export_rate')->value('value');
        $fee = $export_rate * $number; // 计算提现手续费
        try {
            \DB::transaction(
                function () use ($account, $address, $number, $coin_id, $fee) {
                    $export = new Export();
                    $export->user_id = Auth::user()->id;
                    $export->coin_id = $coin_id;
                    $export->number = $number;
                    $export->fee = $fee;
                    $export->to = $address->address;
                    $export->status = 0;
                    $export->save();
                    (new LogService())->exportLog($account, $number);
                    $account->available -= $number;
                    $account->disabled += $number;
                    $account->save();
                });
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return $this->failed('网络异常');
        }
        return $this->success();
    }

    /***
     * 取消提现
     * @param Export $export
     * @return \Illuminate\Http\Response
     */
    public function cancelExport($export)
    {
        $export = Export::find($export);
        //撤销提现验证
        (new AccountService())->cancelExportCheck($export);
        $account = Account::where('user_id', $export->user_id)->where('coin_id', $export->coin_id)->first();
        if ($export->status != 0) {
            return $this->failed('提现状态错误');
        }
        try {
            \DB::transaction(function () use ($account, $export) {
                $export->status = 2;
                $export->save();
                //钱包日志
                (new LogService())->cancelExportLog($account, $export->number);
                //钱包金额返回
                $account->available += $export->number;
                $account->disabled -= $export->number;
                $account->save();
            });
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return $this->failed('网络异常');
        }
        return $this->success();
    }

    /***
     * 充值列表
     * @param Request $request
     * @return \Dingo\Api\Http\Response
     */
    public function imports(Request $request)
    {
        $imports = Import::where('user_id', Auth::user()->id)->with('coin')->orderBy('id', 'desc')->paginate($request->per_page ?? 16);
        return $this->response()->paginator($imports, new ImportTransform());
    }

    /***
     * 提现列表
     * @param Request $request
     * @return \Dingo\Api\Http\Response
     */
    public function exports(Request $request)
    {
        $exports = Export::where('user_id', Auth::user()->id)->with('coin')->orderBy('id', 'desc')->paginate($request->per_page ?? 16);
        return $this->response()->paginator($exports, new ExportTransform());
    }

}