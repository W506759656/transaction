<?php
/**
 * Created by PhpStorm.
 * User: wangding
 * Date: 2019/3/20
 * Time: 下午4:00
 */

namespace Wding\transcation\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Wding\transcation\Models\Account
 *
 * @property int $id
 * @property int $user_id 用户ID
 * @property int $coin_id 币种ID
 * @property float|null $available 可用余额
 * @property float|null $disabled 冻结余额
 * @property string|null $address 钱包地址
 * @property-read \Wding\transcation\Models\Coin $coin
 * @method static \Illuminate\Database\Eloquent\Builder|\Wding\transcation\Models\Account newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Wding\transcation\Models\Account newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Wding\transcation\Models\Account query()
 * @method static \Illuminate\Database\Eloquent\Builder|\Wding\transcation\Models\Account whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Wding\transcation\Models\Account whereAvailable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Wding\transcation\Models\Account whereCoinId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Wding\transcation\Models\Account whereDisabled($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Wding\transcation\Models\Account whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Wding\transcation\Models\Account whereUserId($value)
 * @mixin \Eloquent
 */
class Account extends Model
{
    public $timestamps = false;
    public function coin()
    {
        return $this->belongsTo(Coin::class);
    }

    //开启白名单字段
    protected $fillable = ['user_id', 'coin_id'];
}