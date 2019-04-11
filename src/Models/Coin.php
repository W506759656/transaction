<?php

namespace Wding\transcation\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Coin
 *
 * @property int $id 币种ID
 * @property string $name 币种名称
 * @property int|null $is_import 是否可充值
 * @property int|null $is_export 是否可提现
 * @property float $export_min 提现最小量
 * @property float $export_max 提箱最大量
 * @property int $type 类型 1：资产钱包 2：燃料钱包
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Coin newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Coin newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Coin query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Coin whereExportMax($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Coin whereExportMin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Coin whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Coin whereIsExport($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Coin whereIsImport($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Coin whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Coin whereType($value)
 * @mixin \Eloquent
 */
class Coin extends Model
{
    public $timestamps = false;

    protected $hidden = ['market_name', 'is_import', 'is_export', 'export_min', 'export_max'];
}
