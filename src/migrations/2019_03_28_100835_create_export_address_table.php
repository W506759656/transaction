<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExportAddressTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('export_addresses', function (Blueprint $table) {
            $table->increments('id')->comment('地址ID');
            $table->unsignedInteger('user_id')->comment('用户ID');
            $table->unsignedInteger('coin_id')->comment('币种ID');
            $table->string('address')->comment('地址');
            $table->string('tag')->nullable()->default(null)->comment('备注');
            $table->string('note')->nullable()->default(null)->comment('标签');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('export_addresses');
    }
}
