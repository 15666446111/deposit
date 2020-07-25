<?php
namespace App\Http\Controllers;

use App\Order;
use App\User;
use App\Zfconfig;
use Illuminate\Http\Request;
use App\Packages\Alipay\AlipayCli;
use App\Packages\Alipay\Aop\AopClient;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Mockery\Exception;

class AliController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        try{
            /**
             * @var [type] [< 定义回调页面>]
             */
            $HTTP_URL  = "http://". $_SERVER['HTTP_HOST'] . "/auth/" . $request->path();

            //dd($HTTP_URL);

            /**
             * @var [type] [< 定义回调页面>]
             */
            $return_url = urlencode($HTTP_URL);

            // 构造URL 授权
            ## 通过传过来的用户获取相关用户的平台参数
            $user = User::where('username',decrypt($request->route('user')))->firstOrFail();

            $Url = "https://openauth.alipay.com/oauth2/publicAppAuthorize.htm?app_id=".$user->configs->app_id."&scope=auth_userinfo&redirect_uri=".$return_url;
            Log::info('step0'.$Url);
            return redirect($Url);
        }catch(Exception $e){
            ## 防止失败，返回系统
            $Url = "https://openauth.alipay.com/oauth2/publicAppAuthorize.htm?app_id=".config('Alipay.app_id')."&scope=auth_userinfo&redirect_uri=".$return_url;
            return redirect($Url);
        }
    }



    /**
     * [getToken 授权后 获取AccessToken]
     * @author Pudding 2019-09-23
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function getUserInfo(Request $request)
    {
        $username   = decrypt(basename($request->path()));
        
        $user_info  = User::where('username', $username)->first();

        $reponse    = new AlipayCli($user_info->configs);

        $UserInfo   = $reponse->getUserInfo($request->auth_code);

        $User = \App\Zfbuser::where('openid', $UserInfo->alipay_user_userinfo_share_response->user_id)->first();
        if(empty($User) or !$User)
        {
            $User = \App\Zfbuser::create([
                'openid'    =>  $UserInfo->alipay_user_userinfo_share_response->user_id,
                'nickname'  =>  isset($UserInfo->alipay_user_userinfo_share_response->nick_name) ? $UserInfo->alipay_user_userinfo_share_response->nick_name : '',
                'province'  =>  isset($UserInfo->alipay_user_userinfo_share_response->province) ? $UserInfo->alipay_user_userinfo_share_response->province : '',
                'city'      =>  isset($UserInfo->alipay_user_userinfo_share_response->city) ? $UserInfo->alipay_user_userinfo_share_response->city : '',
                'avatar'    =>  isset($UserInfo->alipay_user_userinfo_share_response->avatar)?$UserInfo->alipay_user_userinfo_share_response->avatar:"",
                'gender'    =>  isset($UserInfo->alipay_user_userinfo_share_response->gender)?$UserInfo->alipay_user_userinfo_share_response->gender:"",
                'user_type' =>  isset($UserInfo->alipay_user_userinfo_share_response->user_type_value)?$UserInfo->alipay_user_userinfo_share_response->user_type_value:"",
                'alipayid'  =>  isset($UserInfo->alipay_user_userinfo_share_response->alipay_user_id)?$UserInfo->alipay_user_userinfo_share_response->alipay_user_id:"",
                'user_status'   =>  isset($UserInfo->alipay_user_userinfo_share_response->user_status)?$UserInfo->alipay_user_userinfo_share_response->user_status:"",
                'is_certified'  =>  isset($UserInfo->alipay_user_userinfo_share_response->is_certified)?$UserInfo->alipay_user_userinfo_share_response->is_certified:"",
                'is_student_certified' => isset($UserInfo->alipay_user_userinfo_share_response->is_student_certified)?$UserInfo->alipay_user_userinfo_share_response->is_student_certified:"",
                'platform'=>$user_info->configs->platform_code
            ]);
        }
        // 用户最后一次扫码时间
        $User->login_time = date("Y-m-d H:i:s", time());
        $User->save();
        // -- 使用客户信息 创建预授权订单 等待用户唤起收银台支付
        $time   = $request->route('time');  // 客户扫的二维码创建时间
        $parent = decrypt($request->route('user'));  // 客户的邀请人信息
        ## 如果是 一下手机号 押金金额修改 为1

        // 创建预授权订单
        $order  =  \App\Order::create([
            'order_no'          => "HGJ".$this->build_rand_no(),      //预授权订单号
            'order_request_no'  => "ZNHGJ".$this->build_rand_no(),    //预授权资金流水号
            'order_title'       => "Apply for Probation",            //订单标题
            'order_amount'      =>  9900,                           //订单金额
            'order_user'        =>  $User->openid,                  //订单会员
            'order_user_name'   =>  $User->nickname,                //订单会员名称
            'order_parent'      =>  $parent,                        //邀请人帐号
            'extra_param_outStoreAlias'    => '领取成功!',           //支付宝信息展示页展示的说明
            'alipay_payee_logon'=>  $user_info->configs->account,              //收款方支付宝登录帐号
            'platform'=>  $user_info->configs->platform_code,              //收款方支付宝登录帐号

        ]);
        // -- 生成预冻结资金订单
        // Log::info(json_encode($order));
        $key = 'Alipay.amounts.'.$user_info->configs->platform_code;
        $amounts = config($key)?config($key):'100';
        Log::info("key:".$key);
        Log::info("amounts:".$amounts);
        $FundAuthOrder  = $reponse->getAuthOrder($order);
        return view('Aliorder', compact('User', 'order', 'parent', 'FundAuthOrder','amounts'));
    }






    ## 扣款
    public function payments(Request $request){
        // == 获取到30天之外的订单
        ## 2019-11-22
        //HGJ2019102502666 臧坤坤
        //HGJ2019103092631  邵亚
        //HGJ2019103061785  曹攀
        //HGJ2019103120500 李洋
        //HGJ2019103161664 张文革
        //HGJ2019103110352  何跃
        //HGJ2019110774522 白礼明
        //HGJ2019103033355 刘厚珍
        ##2019-11-23
        //HGJ2019111876513 李斌斌
        //HGJ2019111585054 李良建
        //HGJ2019111507396 曾旖志
        //HGJ2019111408296 代久炼
        $orders = [
            'HGJ2019111876513','HGJ2019111585054','HGJ2019111507396','HGJ2019111408296'
        ];
        $order = Order::whereIN('order_no',$orders)->get();
        // == 如果有订单
        if(!empty($order) and $order!= null)
        {
            foreach ($order as $key => $value)
            {
                // == 获得订单信息
                $orderCurr = \App\Order::with('toBind')->where('id', $value->id)->first();
                // == 创建预授权转支付订单
                $config = $value->configs;
                Log::info(json_encode($config));
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
                //$user =
                $reponse = new AlipayCli($value->configs);
                // -- 预授权资金解冻
                $PayReponse  = $reponse->PayOrder($pay);
                Log::info(json_encode($PayReponse));
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



    /**
     * [orderStatus 展示支付结果页面]
     * @author Pudding 2019-09-25
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function orderStatus(Request $request)
    {
        $orderNo =  $request->route('orderNo');

        // 获得订单信息
        $order = \App\Order::where('order_no', $orderNo)->first();

        //if(!$order or empty($order)) abort('404');

        return view('Success', compact('order'));
    }


    /**
     * [orderNotify 支付宝预授权订单支付异步回调]
     * @author Pudding 2019-09-25
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function orderNotify(Request $request)
    {
        try{
            file_put_contents("./1.txt", json_encode($_POST));
            // 如果不存在 订单号  返回fail
            if(!isset($_POST['out_order_no'])) die('Fail');
            // 如果不存在资金流水号 返回fail
            //file_put_contents("./2.txt", $_POST['out_order_no']);
            if(!isset($_POST['out_request_no'])) die('Fail');
            // 查询订单 如果订单不存在 返回fail
            $order = \App\Order::where('order_no', $_POST['out_order_no'])->where('order_request_no', $_POST['out_request_no'])->first();
            // 如果该笔订单不存在  返回fail
            if(!$order or empty($order)) die('failorder');

            $order->alipay_pay_return = json_encode($_POST);
            // 支付宝资金授权订单号
            $order->alipay_auth_no = $_POST['auth_no'];
            // 支付宝的资金操作流水号
            $order->alipay_operation_id = $_POST['operation_id'];
            // 资金操作类型
            $order->alipay_operation_type = $_POST['operation_type'];
            // 本次操作 处理的金额
            $order->amount = $_POST['amount'] * 100;
            // 资金预授权明细状态
            $order->alipay_status = $_POST['status'];
            // 操作创建时间
            $order->alipay_gmt_create = $_POST['gmt_create'];
            // 操作处理时间
            $order->alipay_gmt_trans  = $_POST['gmt_trans'];
            //付款方支付宝帐号登录帐号
            $order->alipay_payer_logon = $_POST['payer_logon_id'];
            // 付款方支付宝帐号UID
            $order->alipay_payer_user  = $_POST['payer_user_id'];
            // 收款方UID
            $order->alipay_payee_user = $_POST['payee_user_id'];
            // 累积冻结金额
            $order->total_freeze_amount = $_POST['total_freeze_amount'] * 100;
            // 累积解冻金额
            $order->total_unfreeze_amount =  $_POST['total_unfreeze_amount'] * 100;
            // 累积支付金额
            $order->total_pay_amount   = $_POST['total_pay_amount'] * 100;
            // 剩余冻结金额
            $order->rest_amount = $_POST['rest_amount'] * 100;
            // 保存订单
            $order->save();
            return "SUCCESS";
            // {"auth_app_id":"2017122001013151","notify_type":"fund_auth_freeze","notify_time":"2019-09-25 14:39:49","app_id":"2017122001013151","notify_id":"2019092500222143949099290564365870"}
        } catch (\Exception $e) {
            return "FAIL".$e->getMessage();
        }
    }

    /**
     * [setName 更改支付宝订单姓名]
     * @author Pudding 2019-09-25
     * @param  Request $request [description]
     */
    public function setName(Request $request)
    {
        \App\Order::where('id', $request->order)->update(['order_user_name' => $request->name,'order_mobile'=> $request->mobile]);
    }

    /**
     * [build_rand_no 生成订单号]
     * @author Pudding 2019-09-25
     * @return [type] [description]
     */
    public function build_rand_no()
    {
        mt_srand((double) microtime() * 1000000);
        return date('Ymd') . str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);
    }

    /**
     * [Gateway 支付宝生活号网关验证]
     * @author Pudding 2019-09-23
     * @param  Request $request [description]
     */
    public function Gateway(Request $request)
    {
        try{
            $data = file_get_contents('php://input');
            Log::info($_REQUEST);
            ## 获取系统参数
            $platform_code = $request->route('platform');
            $config = Zfconfig::where('platform_code',$platform_code)->firstOrFail();
            parse_str($data, $data);
            if (empty($data['sign']) || empty($data['sign_type']) || empty($data['biz_content'])|| empty($data['service']) || empty($data['charset'])) {
                $this->verifygw(false, $config);
            }
            $as = new AopClient();
            $as->alipayrsaPublicKey=$config->alipay_pub_key;
            $is_sign_success = $as->rsaCheckV2($_REQUEST,$config->alipay_pub_key, $config->sign_type);
            $this->verifygw($is_sign_success, $config);
        }catch(Exception $error){
            Log::info($error->getMessage());
        }
    }
    private function verifygw($is_sign_success,$config){
        $as = new AopClient();
        $as->rsaPrivateKey=$config->private_key;
        if ($is_sign_success) {
            $response_xml = "<success>true</success><biz_content>" . $config->public_key . "</biz_content>";
        } else {
            $response_xml = "<success>false</success><error_code>VERIFY_FAILED</error_code><biz_content>" . $config->public_key . "</biz_content>";
        }
        $mysign=$as->alonersaSign($response_xml,$config->private_key,$config->sign_type);
        $return_xml = "<?xml version=\"1.0\" encoding=\"".$config->charset."\"?><alipay><response>".$response_xml."</response><sign>".$mysign."</sign><sign_type>".$config->sign_type."</sign_type></alipay>";
        Log::info( "response_xml: " . $return_xml );
        echo $return_xml;
        exit ();
    }
    /**
     * 支付宝支付信息配置
     */
    public function Aliconfig(Request $request)
    {
        $username = $request->route('username');
        $user = User::where('username',$username)->first();
        $zfconfiginfo = \App\Zfconfig::where('username',$username )->first();
        if($request->isMethod('post')){
            $postusername = $request->username;
            $validator = Validator::make($request->all(), [
                'app_id'  => ['required'],
                'private_key'  => ['required',],
                'public_key'      => ['required'],
                'alipay_pub_key'  => ['required'],
                'gatewayUrl'  => ['required',],
                'charset'      => ['required'],
                'sign_type' => ['required'],
                'platform_code' => ['required','unique:zfconfig,platform_code'],
            ], [
                'app_id.required' =>  '请填写app_id!',
                'private_key.required'    =>  '请填写private_key!',
                'public_key.required'  =>  '请填写public_key!',
                'alipay_pub_key.required'   =>  '请填写alipay_pub_key!',
                'gatewayUrl.required'   =>  '请填写gatewayUrl!',
                'charset.required'      =>  '请填写charset!',
                'sign_type.required'     =>  '请填写sign_type!',
                'platform_code.required'     =>  '请填写平台代号（唯一）!',
                'platform_code.unique'     =>  '该平台代号已被使用！',
            ]);
            if($validator->fails())
                return redirect()->route('AliAuthconfig', ['username'=>$postusername])->with(['error'=>$validator->errors()->first()]);
            $zfconfiginfo = \App\Zfconfig::where('username',$postusername )->first();
            if(empty($zfconfiginfo)) {
                // 创建支付配置
                $insertzfconfig = \App\Zfconfig::create([
                    'username' => $postusername,
                    'app_id' => trim($request->app_id),
                    'private_key' => $request->private_key,
                    'public_key' => $request->public_key,
                    'alipay_pub_key' => $request->alipay_pub_key,
                    'gatewayUrl' => $request->gatewayUrl,
                    'charset' => $request->charset,
                    'sign_type' => $request->sign_type,
                    'platform' =>$request->platform,
                    'platform_code'=> $request->platform_code,
                    'account'=> $request->account,
                ]);
            }else{
                $updatezfconfig = \App\Zfconfig::where('username',$postusername)
                    ->update([
                        'username' => $postusername,
                        'app_id' => trim($request->app_id),
                        'private_key' => $request->private_key,
                        'public_key' => $request->public_key,
                        'alipay_pub_key' => $request->alipay_pub_key,
                        'gatewayUrl' => $request->gatewayUrl,
                        'charset' => $request->charset,
                        'sign_type' => $request->sign_type,
                        'platform' =>$request->platform,
                        'platform_code'=>  $request->platform_code,
                        'account'=> $request->account
                    ]);
            }
            return redirect('AccountList')->with(['success'=> '支付信息配置成功!']);
        }
        return view('AliConfig',compact('zfconfiginfo','user'));
    }
}
