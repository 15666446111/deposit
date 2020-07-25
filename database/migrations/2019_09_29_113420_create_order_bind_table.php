<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderBindTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_bind', function (Blueprint $table) {
            $table->increments('id');
            $table->string('bind_no')->unique()->comment('订单号');
            $table->string('bind_title')->nullable()->comment('机器标题');
            $table->string('bind_sn')->nullable()->comment('机器SN');
            $table->string('bind_merch')->nullable()->comment('机器商编');
            $table->integer('bind_active')->default(0)->comment('是否激活!');
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
        Schema::dropIfExists('order_bind');
    }
}
