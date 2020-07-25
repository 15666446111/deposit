<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->string('order_no')->unique()->comment('预授权订单号');
            $table->string('order_request_no')->unique()->comment('预授权请求流水号');
            $table->string('alipay_auth_no')->nullable()->comment('支付宝资金授权订单号');
            $table->string('alipay_operation_id')->nullable()->comment('支付宝的资金操作流水号');
            $table->string('order_title')->nullable()->comment('订单标题');
            $table->integer('order_amount')->default(0)->comment('订单金额');
            $table->string('order_user')->nullable()->comment('订单会员');
            $table->string('order_user_name')->nullable()->comment('订单会员姓名');
            $table->string('order_parent')->nullable()->comment('订单会员的邀请人帐号,可以同一个人扫不同人的二维码');
            $table->string('extra_param_outStoreAlias')->nullable()->comment('业务信息,支付宝信息展示页展示');
            $table->string('alipay_operation_type')->nullable()->comment('资金操作类型FREEZE, UNFREEZE, PAY');
            $table->integer('amount')->default(0)->comment('本次操作冻结的金额');
            $table->string('alipay_status')->nullable()->comment('资金预授权明细的状态 INIT SUCCESS CLOSED');
            $table->timeStamp('alipay_gmt_create')->nullable()->comment('操作创建时间');
            $table->timeStamp('alipay_gmt_trans')->nullable()->comment('操作处理完成时间');
            $table->string('alipay_payer_logon')->nullable()->comment('付款方支付宝账号登录号');
            $table->string('alipay_payer_user')->nullable()->comment('付款方支付宝账号UID');
            $table->string('alipay_payee_logon')->nullable()->comment('收款方支付宝账号登陆号');
            $table->string('alipay_payee_user')->nullable()->comment('收款方支付宝账号UID');

            $table->integer('total_freeze_amount')->default(0)->comment('累计冻结金额');
            $table->integer('total_unfreeze_amount')->default(0)->comment('累计解冻金额');
            $table->integer('total_pay_amount')->default(0)->comment('累计支付金额');
            $table->integer('rest_amount')->default(0)->comment('剩余冻结金额');

            $table->string('pre_auth_type')->nullable()->comment('预授权类型CREDIT_AUTH(信用预授权 没有真实冻结资金)');

            $table->text('alipay_pay_return')->nullable()->comment('支付宝支付返回JSON');
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
        Schema::dropIfExists('orders');
    }
}
