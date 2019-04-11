<?php

namespace Wding\Transcation\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Wding\Transcation\Models\Account;
use Wding\Transcation\Models\Export;
use Wding\Transcation\Models\ExportAddress;
use Wding\Transcation\Models\Import;
use Wding\Transcation\Models\Setting;
use Wding\Transcation\Requests\ExportRequest;
use Wding\Transcation\Resources\ExportResource;
use Wding\Transcation\Resources\ImportResource;
use Wding\Transcation\Services\AccountService;
use Wding\Transcation\Services\LogService;

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
            return $this->error(9003);
        }
        $address_id = $request->input('address_id');
        $address = ExportAddress::find($address_id);
        $coin_id = $request->input('coin_id');
        $account = Account::where('user_id', Auth::user()->id)->where('coin_id', $coin_id)->first();
        if (!$account) {
            return $this->error(9004);
        }
        if (!$account->coin->is_export) {
            return $this->error(9005);
        }
        if ($number <= 0) {
            return $this->error(9006);
        }
        if ($account->available < $number) {
            return $this->error(9007);
        }
        if ($account->user_id != \Auth::user()->id) {
            return $this->error(1);
        }
        $export_rate = Setting::where('key', 'export_rate')->value('value');
        $fee = $export_rate * $number; // 计算提现手续费
        try {
            \DB::Transcation(
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
            return $this->error(1);
        }
        return $this->null();
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
            return $this->error(9008);
        }
        try {
            \DB::Transcation(function () use ($account, $export) {
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
            return $this->error(1);
        }
        return $this->null();
    }

    /***
     * 充值列表
     * @param Request $request
     * @return ImportResource
     */
    public function imports(Request $request)
    {
        $imports = Import::where('user_id', Auth::user()->id)->with('coin')->orderBy('id', 'desc')->paginate($request->per_page ?? 16);
        return new ImportResource($imports);
    }

    /***
     * 提现列表
     * @param Request $request
     * @return ExportResource
     */
    public function exports(Request $request)
    {
        $exports = Export::where('user_id', Auth::user()->id)->with('coin')->orderBy('id', 'desc')->paginate($request->per_page ?? 16);
        return new ExportResource($exports);
    }

}