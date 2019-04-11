<?php

namespace Wding\Transcation\Resources;

class AddressResource extends Collection
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
            $data[$k]['address'] = $v->address;
            $data[$k]['note'] = $v->note;
        }
        return $data;
    }
}
