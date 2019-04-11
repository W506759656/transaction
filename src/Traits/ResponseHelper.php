<?php

namespace Wding\Transcation\Traits;

use App\Exceptions\Exception;
use Illuminate\Http\Response;

trait ResponseHelper
{
    protected function null()
    {
        return self::array();
    }

    protected function array(array $data = null)
    {
        return new Response([
            'code' => 0,
            'message' => 'OK',
            'data' => $data,
        ]);
    }

    protected function error($code)
    {
        if (!config('trans_error.#' . $code)) {
            $code = 1;
        }

        throw new Exception(
            $code,
            config('error.#' . $code . '.message'),
            config('error.#' . $code . '.status_code')
        );
    }
}