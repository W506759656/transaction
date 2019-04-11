<?php

namespace Wding\transcation\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Export
 *
 * @property int $id
 * @property int $user_id 用户ID
 * @property int $coin_id 币种ID
 * @property string|null $hash 交易hash
 * @property float $number 数量
 * @property float $fee 手续费
 * @property string $to 接收方
 * @property string|null $tag 备注
 * @property string|null $note 地址标签
 * @property int|null $status 状态：0.审核中 1.已完成 2.撤销
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Coin $coin
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Export newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Export newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Export query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Export whereCoinId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Export whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Export whereFee($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Export whereHash($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Export whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Export whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Export whereNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Export whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Export whereTag($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Export whereTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Export whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Export whereUserId($value)
 * @mixin \Eloquent
 */
class Export extends Model
{
    public function coin()
    {
        return $this->belongsTo(Coin::class, 'coin_id');
    }
}
