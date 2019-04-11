<?php
namespace Wding\Transaction\Traits;
/**
 * Created by PhpStorm.
 * User: wangding
 * Date: 2019/3/28
 * Time: 上午10:20
 */
use Dingo\Api\Http\Response as DingGoResponse;

Trait Response{

    /***
     * @param array $data
     * @param int $code
     * @param bool $status
     * @return DingGoResponse
     */
    public function success($data = [], $code = DingGoResponse::HTTP_OK, $status = true)
    {
        return new DingGoResponse(['status' => $status, 'code' => $code, 'data' => empty($data) ? null : $data]);
    }

    /**
     * @param      $message
     * @param int  $code
     * @param bool $status
     *
     * @return mixed
     */
    public function failed($message, $code = DingGoResponse::HTTP_BAD_REQUEST, $status = false)
    {
        return new DingGoResponse(['status' => $status, 'code' => $code, 'message' => $message]
        );
    }
}