<?php
/**
 * Created by PhpStorm.
 * User: wangding
 * Date: 2019/4/11
 * Time: 下午3:48
 */

namespace Wding\Transcation\Resources;


class ExportResource extends Collection
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $data = [];
        foreach ($this as $k => $v)
        {
            $data[$k]['id'] = $v->id;
            $data[$k]['coin'] = $v->coin->name;
            $data[$k]['hash'] = $v->hash;
            $data[$k]['number'] = $v->number;
            $data[$k]['fee'] = $v->fee;
            $data[$k]['to'] = $v->to;
            $data[$k]['status'] = $v->status; // 0 审核中   1 完成  2 撤销
            $data[$k]['time'] = $v->created_at->toDateTimeString();
        }
        return $data;
    }

}