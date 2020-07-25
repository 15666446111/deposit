<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use App\Packages\Alipay\AlipayCli;

class OrderPay extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'order:pay';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'The Auto Pay For Order Exp 30 Days';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // 获得30天之前的日期
        $time = Carbon::parse('-3 days')->toDateTimeString(); //2015-10-15 20:49:53
        // == 获取到30天之外的订单
        $order = \App\Order::with('toBind')->where('alipay_status', 'SUCCESS')->where('rest_amount', '>', '0')->whereNotNull('alipay_payee_user')->where('total_pay_amount', '<=', '0')->where('created_at', '<=', $time)->whereHas('toBind', function($Query) use ($time){
            $Query->where('created_at', '<=', $time);
        })->get();

        // == 如果有订单
        if(!empty($order) and $order!= null)
        {
            foreach ($order as $key => $value)
            {
                // == 获得订单信息
                $orderCurr = \App\Order::with('toBind')->where('id', $value->id)->first();
                // == 创建预授权转支付订单
                $pay = \App\OrderPay::create([
                    'auth_no'   =>  $orderCurr->alipay_auth_no,
                    'out_trade_no'  =>  'OrderToPay'.time().substr(md5(time()), 0, 8),
                    'subject'   =>  '产品过期未激活使用扣款',
                    'pay_amount'=>  $orderCurr->amount,
                    'body'      =>  '产品未激活扣款',
                    'sellerId'  =>  $orderCurr->alipay_payee_user,
                    'buyerid'   =>  $orderCurr->alipay_payer_user
                ]);

                // -- 调用客户端
                ##获取该用户对应的配置信息
                $user =
                $reponse = new AlipayCli($value->configs());
                // -- 预授权资金解冻
                $PayReponse  = $reponse->PayOrder($pay);
                $pay->bak = json_encode($PayReponse);
                $pay->save();
                // 预授权转支付失败
                if($PayReponse->code != 10000)
                {
                    $pay->status = 'error';
                    $pay->gmt_payment = date('Y-m-d H:i:s', time());
                    $pay->save();
                    continue;
                // 授权转支付成功
                }else{
                    $pay->ali_trade_no = $PayReponse->trade_no;

                    $pay->buyerloginid = $PayReponse->buyer_logon_id;

                    $pay->gmt_payment  = $PayReponse->gmt_payment;

                    $pay->invoice_amount = $PayReponse->invoice_amount * 100; // 可给用户开具发票的金额

                    $pay->point_amount   = $PayReponse->point_amount * 100; // 集分宝付款金额

                    $pay->receipt_amount = $PayReponse->receipt_amount * 100; // 实收金额

                    $pay->total_amount   = $PayReponse->total_amount * 100; // 总金额

                    $pay->status         = $PayReponse->msg;

                    $pay->save();

                    /**
                     * @var [type] [< 修改订单 累积支付金额 >]
                     */
                    $orderCurr->total_pay_amount = $PayReponse->receipt_amount * 100;

                    $orderCurr->rest_amount      = $orderCurr->rest_amount - ($PayReponse->receipt_amount * 100);

                    $orderCurr->save();

                    continue;
                }
            }
        }

    }
}
