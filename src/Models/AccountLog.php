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
 * Wding\transcation\Models\AccountLog
 *
 * @property int $id
 * @property int $user_id 用户ID
 * @property int $coin_id 币种ID
 * @property string $action 操作类型：充值,提现申请,管理员提现驳回,管理员提现通过,管理员手动更新,锁仓,静态收益,锁仓释放完成清零,直推收益,业绩奖励,平级收益,签到任务奖励,阅读任务奖励,评论任务奖励,分享任务奖励
 * @property int $action_id 操作对应记录ID
 * @property string $account_type 钱包类型
 * @property float $before 操作前余额
 * @property float $number 操作数量：正数代表增加，负数代表减少
 * @property float $after 操作后余额
 * @property string $created_at 时间
 * @method static \Illuminate\Database\Eloquent\Builder|\Wding\transcation\Models\AccountLog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Wding\transcation\Models\AccountLog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Wding\transcation\Models\AccountLog query()
 * @method static \Illuminate\Database\Eloquent\Builder|\Wding\transcation\Models\AccountLog whereAccountType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Wding\transcation\Models\AccountLog whereAction($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Wding\transcation\Models\AccountLog whereActionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Wding\transcation\Models\AccountLog whereAfter($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Wding\transcation\Models\AccountLog whereBefore($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Wding\transcation\Models\AccountLog whereCoinId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Wding\transcation\Models\AccountLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Wding\transcation\Models\AccountLog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Wding\transcation\Models\AccountLog whereNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Wding\transcation\Models\AccountLog whereUserId($value)
 * @mixin \Eloquent
 */
class AccountLog extends Model
{
    public $timestamps = false;

}