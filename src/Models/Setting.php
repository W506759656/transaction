<?php
/**
 * Created by PhpStorm.
 * User: wangding
 * Date: 2019/3/28
 * Time: 上午10:32
 */

namespace Wding\Transaction\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Wding\Transaction\Models\Setting
 *
 * @property int $id
 * @property string $key 键
 * @property string $remark 字段用途
 * @property string $value 值
 * @property string $explain 解释说明
 * @method static \Illuminate\Database\Eloquent\Builder|\Wding\Transaction\Models\Setting newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Wding\Transaction\Models\Setting newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Wding\Transaction\Models\Setting query()
 * @method static \Illuminate\Database\Eloquent\Builder|\Wding\Transaction\Models\Setting whereExplain($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Wding\Transaction\Models\Setting whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Wding\Transaction\Models\Setting whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Wding\Transaction\Models\Setting whereRemark($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Wding\Transaction\Models\Setting whereValue($value)
 * @mixin \Eloquent
 */
class Setting extends Model
{
    public $timestamps = false;
}