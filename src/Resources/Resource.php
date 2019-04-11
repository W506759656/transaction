<?php

namespace Wding\Transcation\Resources;

use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;
use Wding\Transcation\Traits\ResourceHelper;

class Resource extends JsonResource
{
    use ResourceHelper;

    /**
     * Create new anonymous resource collection.
     *
     * @param  mixed $resource
     * @return AnonymousResourceCollection
     */
    public static function collection($resource)
    {
        return parent::collection($resource)
            ->additional(['code' => 0, 'message' => 'OK']);
    }
}
