<?php
/**
 * Created by PhpStorm.
 * User: wangding
 * Date: 2019/3/28
 * Time: 上午11:29
 */

//提现
Route::post('do_export', 'ExportController@doExport');
//取消提现
Route::get('cancel_export/{export}', 'ExportController@cancelExport');
//充值记录
Route::get('imports', 'ExportController@imports');
//提现记录
Route::get('exports', 'ExportController@exports');
//币种列表
Route::get('coins', 'CoinController@lst');
//获取充值地址
Route::get('account/get_address/{coin_id}', 'CoinController@getAddress')->name('api.accounts.address');
//钱包列表
Route::get('account/list', 'CoinController@index')->name('api.accounts.list');

Route::group(['prefix' => 'export_address'], function () {
    //列表
    Route::get('list', 'ExportAddressController@lst');
    //添加地址
    Route::post('add', 'ExportAddressController@add');
    //删除地址
    Route::delete('del/{address}', 'ExportAddressController@del');
    //更新地址
    Route::post('update', 'ExportAddressController@update');

});