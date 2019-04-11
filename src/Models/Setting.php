<?php
/**
 * Created by PhpStorm.
 * User: wangding
 * Date: 2019/3/28
 * Time: 上午10:32
 */

namespace Wding\transcation\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Wding\transcation\Models\Setting
 *
 * @property int $id
 * @property string $key 键
 * @property string $remark 字段用途
 * @property string $value 值
 * @property string $explain 解释说明
 * @method static \Illuminate\Database\Eloquent\Builder|\Wding\transcation\Models\Setting newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Wding\transcation\Models\Setting newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Wding\transcation\Models\Setting query()
 * @method static \Illuminate\Database\Eloquent\Builder|\Wding\transcation\Models\Setting whereExplain($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Wding\transcation\Models\Setting whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Wding\transcation\Models\Setting whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Wding\transcation\Models\Setting whereRemark($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Wding\transcation\Models\Setting whereValue($value)
 * @mixin \Eloquent
 */
class Setting extends Model
{
    public $timestamps = false;
}