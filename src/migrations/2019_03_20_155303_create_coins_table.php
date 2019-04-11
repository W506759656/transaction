<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoinsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coins', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->comment('币种名称');
            $table->string('icon')->comment('币种图标');
            $table->boolean('is_import')->nullable()->default(false)->comment('是否可充值');
            $table->boolean('is_export')->nullable()->default(false)->comment('是否可提现');
            $table->unsignedDecimal('export_min', 20, 8)->comment('提现最小量');
            $table->unsignedDecimal('export_max', 20, 8)->comment('提箱最大量');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('coins');
    }
}
