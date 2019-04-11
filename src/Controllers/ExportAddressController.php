<?php
/**
 * Created by PhpStorm.
 * User: wangding
 * Date: 2019/3/29
 * Time: 下午2:37
 */
namespace Wding\transcation\Controllers;

use Illuminate\Http\Request;
use Wding\transcation\Models\ExportAddress;
use Wding\transcation\Requests\AddressRequest;
use Wding\Transcation\Resources\AddressResource;
use Wding\transcation\Transforms\ImportAddressTransform;

class ExportAddressController extends Controller
{
    /***
     * 地址列表
     * @param Request $request
     * @return \Dingo\Api\Http\Response
     */
    public function lst(Request $request)
    {
        $coin_id = $request->input('coin_id');
        $user_id = \Auth::user()->id;
        $addresses = ExportAddress::where('coin_id', $coin_id)->where('user_id', $user_id)->orderBy('id', 'desc')->paginate();
        return new AddressResource($addresses);
    }

    /***
     * 添加地址
     * @param AddressRequest $request
     * @return \Illuminate\Http\Response
     */
    public function add(AddressRequest $request)
    {
        if(!$request->has('coin_id')){
            return $this->error(9001);
        }
        $coin_id = $request->input('coin_id');
        $address = $request->input('address');
        $note = $request->input('note');
        $addressM = new ExportAddress();
        $addressM->user_id = \Auth::user()->id;
        $addressM->coin_id = $coin_id;
        $addressM->address = $address;
        $addressM->note = $note;
        if(!$addressM->save()){
            return $this->error(1);
        };
        return $this->null();
    }

    /***
     * 更新地址
     * @param AddressRequest $request
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function update(AddressRequest $request)
    {
        if(!$request->has('id')){
            return $this->error(9002);
        }
        $id = $request->input('id');
        $address = $request->input('address');
        $note = $request->input('note');
        $addressM = ExportAddress::where('user_id', \Auth::user()->id)->find($id);
        $addressM->address = $address;
        $addressM->note = $note;
        if(!$addressM->save()){
            return $this->error(1);
        };
        return $this->null();
    }

    /***
     * 删除地址
     * @param $address_id
     * @return \Illuminate\Http\Response
     * @internal param $
     */
    public function del($address_id)
    {
        $export_address = ExportAddress::find($address_id);
        if($export_address->user_id != \Auth::user()->id)
        {
            return $this->error(1);
        }
        if(!$export_address->delete()){
            return $this->error(1);
        }
        return $this->null();
    }
}