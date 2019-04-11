<?php
/**
 * Created by PhpStorm.
 * User: wangding
 * Date: 2019/3/28
 * Time: 上午10:44
 */

namespace Wding\transcation\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Wding\transcation\Models\Import
 *
 * @property int $id
 * @property int $user_id 用户ID
 * @property int $coin_id 币种ID
 * @property string $hash 交易hash
 * @property float $number 数量
 * @property string $from 发送方
 * @property string $to 接收方
 * @property string|null $tag 备注
 * @property int $status 状态：0.待确认 1.已确认
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\Wding\transcation\Models\Import newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Wding\transcation\Models\Import newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Wding\transcation\Models\Import query()
 * @method static \Illuminate\Database\Eloquent\Builder|\Wding\transcation\Models\Import whereCoinId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Wding\transcation\Models\Import whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Wding\transcation\Models\Import whereFrom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Wding\transcation\Models\Import whereHash($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Wding\transcation\Models\Import whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Wding\transcation\Models\Import whereNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Wding\transcation\Models\Import whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Wding\transcation\Models\Import whereTag($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Wding\transcation\Models\Import whereTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Wding\transcation\Models\Import whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Wding\transcation\Models\Import whereUserId($value)
 * @mixin \Eloquent
 */
class Import extends Model
{

    public function coin()
    {
        return $this->belongsTo(Coin::class, 'coin_id');
    }
}