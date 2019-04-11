<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('imports', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id')->comment('用户ID');
            $table->unsignedInteger('coin_id')->comment('币种ID');
            $table->string('hash')->comment('交易hash');
            $table->unsignedDecimal('number', 20, 8)->comment('数量');
            $table->string('from')->comment('发送方');
            $table->string('to')->comment('接收方');
            $table->string('tag')->nullable()->default(null)->comment('备注');
            $table->unsignedTinyInteger('status')->comment('状态：0.待确认 1.已确认');
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
        Schema::dropIfExists('imports');
    }
}
