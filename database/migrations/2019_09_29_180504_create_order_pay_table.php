<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderPayTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_pay', function (Blueprint $table) {
            $table->increments('id');

            $table->string('auth_no')->nullable()->comment('支付宝资金授权订单号');
            $table->string('out_trade_no')->nullable()->comment('交易流水号');

            $table->string('ali_trade_no')->nullable()->comment('支付宝交易流水号');

            $table->string('subject')->nullable()->comment('解冻转支付标题');
            $table->integer('pay_amount')->default(0)->comment('结算支付金额');

            $table->string('sellerId')->nullable()->comment('卖家支付宝账户pid');
            $table->string('buyerid')->nullable()->comment('买家支付宝账户pid');

            $table->string('body')->nullable()->comment('可填写备注信息');

            $table->string('status')->default('init')->comment('状态 init 初始化 error 错误 wait 等待异步通知 success 成功');

            $table->string('buyerloginid')->nullable()->comment('买家支付宝登录帐号');
            $table->timestamp('gmt_payment')->nullable()->comment('交易处理时间');


            $table->integer('invoice_amount')->default(0)->comment('');
            $table->integer('point_amount')->default(0)->comment('');
            $table->integer('receipt_amount')->default(0)->comment('');
            $table->integer('total_amount')->default(0)->comment('');

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
        Schema::dropIfExists('order_pay');
    }
}
