<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('account_logs', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id')->comment('用户ID');
            $table->unsignedInteger('coin_id')->comment('币种ID');
            $table->string('action')->comment('操作');
            $table->unsignedInteger('action_id')->comment('操作对应记录ID');
            $table->enum('account_type',['available', 'disabled', 'static', 'dynamic'])->comment('钱包类型');
            $table->unsignedDecimal('before', 20, 8)->comment('操作前余额');
            $table->decimal('number', 20, 8)->comment('操作数量：正数代表增加，负数代表减少');
            $table->unsignedDecimal('after', 20, 8)->comment('操作后余额');
            $table->timestamp('created_at')->comment('时间');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('account_logs');
    }
}
