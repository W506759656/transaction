<?php

namespace Wding\Transcation\Resources;

class ImportResource extends Collection
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
            $data[$k]['coin'] = $v->coin->name;
            $data[$k]['number'] = $v->number;
            $data[$k]['hash'] = $v->hash;
            $data[$k]['from'] = $v->from;
            $data[$k]['time'] = $v->created_at->toDateTimeString();
        }
        return $data;
    }
}
