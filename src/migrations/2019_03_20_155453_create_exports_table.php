<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exports', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id')->comment('用户ID');
            $table->unsignedInteger('coin_id')->comment('币种ID');
            $table->string('hash')->nullable()->default(null)->comment('交易hash');
            $table->unsignedDecimal('number', 20, 8)->comment('数量');
            $table->unsignedDecimal('fee', 20, 8)->comment('手续费');
            $table->string('to')->comment('接收方');
            $table->string('note')->nullable()->default(null)->comment('备注');
            $table->unsignedTinyInteger('status')->nullable()->default(0)->comment('状态：0.审核中 1.已完成 2.撤销');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('exports');
    }
}
