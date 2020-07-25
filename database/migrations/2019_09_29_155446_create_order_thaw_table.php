<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderThawTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_thaw', function (Blueprint $table) {
            $table->increments('id');
            $table->string('auth_no')->nullable()->comment('支付宝资金授权订单号');
            $table->string('out_order_no')->nullable()->comment('商户的授权资金订单号');


            $table->string('operation_id')->nullable()->comment('支付宝资金操作流水号');
            $table->string('out_request_no')->nullable()->comment('支付宝资金授权订单号');
            $table->integer('thaw_amount')->default(0)->comment('本次操作解冻的金额');
            $table->string('remark')->nullable()->comment('解冻附言描述');

            $table->string('status')->nullable()->comment('解冻附言描述');

            $table->timestamp('gmt_trans')->nullable()->comment('授权资金解冻成功时间');

            $table->integer('credit_amount')->default(0)->comment('本次解冻操作中信用解冻金额');
            $table->integer('fund_amount')->default(0)->comment('本次解冻操作中自有资金解冻金额');

            $table->text('bak')->nullable()->comment('支付宝返回的json');

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
        Schema::dropIfExists('order_thaw');
    }
}
