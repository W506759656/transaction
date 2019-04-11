<?php
/**
 * Created by PhpStorm.
 * User: wangding
 * Date: 2019/3/28
 * Time: 上午10:11
 */

namespace Wding\Transaction\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Wding\Transaction\Models\ExportAddress
 *
 * @property int $id 地址ID
 * @property int $user_id 用户ID
 * @property int $coin_id 币种ID
 * @property string $address 地址
 * @property string|null $tag 备注
 * @property string|null $note 标签
 * @method static \Illuminate\Database\Eloquent\Builder|\Wding\Transaction\Models\ExportAddress newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Wding\Transaction\Models\ExportAddress newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Wding\Transaction\Models\ExportAddress query()
 * @method static \Illuminate\Database\Eloquent\Builder|\Wding\Transaction\Models\ExportAddress whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Wding\Transaction\Models\ExportAddress whereCoinId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Wding\Transaction\Models\ExportAddress whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Wding\Transaction\Models\ExportAddress whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Wding\Transaction\Models\ExportAddress whereTag($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Wding\Transaction\Models\ExportAddress whereUserId($value)
 * @mixin \Eloquent
 */
class ExportAddress extends Model
{
    public $timestamps = false;
}