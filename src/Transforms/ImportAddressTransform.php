<?php
namespace Wding\Transaction\Transforms;
/**
 * Created by PhpStorm.
 * User: wangding
 * Date: 2019/3/28
 * Time: 上午11:23
 */
class ImportAddressTransform extends BaseTransformer
{
    protected $type;

    public function transformData($model)
    {
        return $model->toArray();
    }

}