<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id')->comment('用户ID');
            $table->unsignedInteger('coin_id')->comment('币种ID');
            $table->unsignedDecimal('available', 20, 8)->nullable()->default(0)->comment('可用余额');
            $table->unsignedDecimal('disabled', 20, 8)->nullable()->default(0)->comment('冻结余额');
            $table->string('address')->nullable()->default(null)->comment('钱包地址');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accounts');
    }
}
