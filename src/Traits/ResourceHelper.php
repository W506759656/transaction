<?php

namespace Wding\Transcation\Traits;

trait ResourceHelper
{
    /**
     * Get any additional data that should be returned with the resource array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function with($request)
    {
        return [
            'code' => 0,
            'message' => 'OK',
        ];
    }
}