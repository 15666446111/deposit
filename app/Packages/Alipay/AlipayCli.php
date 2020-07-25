<?php
/**
 * ZNHGJ - A PHP Project For Web Artisans
 * @version  [1.0.0] [<description>]
 * @package  Laravel
 * @link     www.lianshuopay.com
 * @author   Pudding <755969423.com>
 * @param    [type] [name] [<description>]
 */
namespace App\Packages\Alipay;

use App\Packages\Alipay\Aop\AopClient;


use App\Packages\Alipay\Aop\request\AlipayTradePayRequest; // 预授权转支付接口
use App\Packages\Alipay\Aop\request\AlipaySystemOauthTokenRequest; // AuthCode 换取Token
use App\Packages\Alipay\Aop\request\AlipayUserUserinfoShareRequest; // token 获取用户信息
use App\Packages\Alipay\Aop\request\AlipayFundAuthOrderUnfreezeRequest;  // 用户资金预授权解冻
use App\Packages\Alipay\Aop\request\AlipayFundAuthOrderAppFreezeRequest; // 用户资金预授权冻结
use App\Packages\Alipay\Aop\request\AlipayFundAuthOperationDetailQueryRequest;
use App\User;
use App\Zfconfig;
use Illuminate\Support\Facades\Log;

class AlipayCli
{

    protected $aop;

    /**
     * [__construct description]
     * @author Pudding 2019-09-24
     */
    public function __construct(Zfconfig $config)
    {
        $this->aop                      = new AopClient();
        $this->aop->appId               = $config->app_id;
        $this->aop->gatewayUrl          = $config->gatewayUrl;
        $this->aop->alipayrsaPublicKey  = $config->alipay_pub_key;
        $this->aop->rsaPrivateKey       = $config->private_key;
    }

    /**
     * [getUserInfo 授权获取用户信息]
     * @author Pudding 2019-09-24
     * @param  [type] $auth_code [description]
     * @return [type]            [description]
     */
    public function getUserInfo($auth_code)
    {
        $token = $this->requestToken( $auth_code );

        if (isset ( $token->alipay_system_oauth_token_response )) {

            $token_str = $token->alipay_system_oauth_token_response->access_token;

            $user_info = $this->requestUserInfo ( $token_str );

            if (isset ( $user_info->alipay_user_userinfo_share_response )) {

                return $user_info;

            }else
                return ['code' => -100002, 'msg' => '用户信息获取失败!'];
        }else
            return ['code' => -100001, 'msg' => 'token获取失败!'];
    }

    /**
     * [getAuthOrder 创建预授权冻结资金订单]
     * @author Pudding 2019-09-24
     * @param  [type] $order [description]
     * @return [type]        [description]
     */
    public function getAuthOrder($order)
    {
        $AlipayFundAuthOrderAppFreezeRequest = new AlipayFundAuthOrderAppFreezeRequest ();
        $AlipayFundAuthOrderAppFreezeRequest->setBizContent("{" .
            "\"out_order_no\":\"".$order->order_no."\"," .
            "\"out_request_no\":\"".$order->order_request_no."\"," .
            "\"order_title\":\"".$order->order_title."\"," .
            "\"amount\":".($order->order_amount / 100)."," .
            "\"product_code\":\"PRE_AUTH_ONLINE\"," .
            "\"payee_logon_id\":\"".$order->alipay_payee_logon."\"," .
            "\"extra_param\":\"{\\\"category\\\":\\\"RENT_DIGITAL\\\",\\\"outStoreCode\\\":\\\"code0011\\\",\\\"outStoreAlias\\\":\\\"".$order->extra_param_outStoreAlias."\\\"}\"".
        "}");
        $AlipayFundAuthOrderAppFreezeRequest->setNotifyUrl("http://deposit.lswlpay.com/Ali/notify");
        $result = $this->aop->sdkExecute($AlipayFundAuthOrderAppFreezeRequest);
        //dd($result)
        Log::info(json_encode($result));
        return $result;
    }

    /**
     * [ThawOrder 预授权资金解冻]
     * @author Pudding 2019-09-29
     * @param  [type] $order [description]
     */
    public function ThawOrder($order)
    {
        $AlipayFundAuthOrderUnfreezeRequest  = new AlipayFundAuthOrderUnfreezeRequest();
        $AlipayFundAuthOrderUnfreezeRequest->setBizContent("{" .
            "\"auth_no\":\"".$order->auth_no."\"," .
            "\"out_request_no\":\"".$order->out_request_no."\"," .
            "\"amount\":".($order->thaw_amount / 100)."," .
            "\"remark\":\"".$order->remark."\"," .
            "\"extra_param\":\"{\\\"unfreezeBizInfo\\\": \\\"{\\\\\\\"bizComplete\\\\\\\":\\\\\\\"true\\\\\\\"}\\\"}\"" .
        "}");

        $result = $this->aop->execute ($AlipayFundAuthOrderUnfreezeRequest);

        $responseNode = str_replace(".", "_",$AlipayFundAuthOrderUnfreezeRequest->getApiMethodName())."_response";

        return $result->$responseNode;
    }

    /**
     * [PayOrder 预授权转支付]
     * @author Pudding 2019-09-29
     * @param  [type] $curr [description]
     * @param  [type] $pay  [description]
     */
    public function PayOrder($pay)
    {
        $AlipayTradePayRequest  = new AlipayTradePayRequest();
        $AlipayTradePayRequest->setBizContent("{" .
            "\"out_trade_no\":\"".$pay->out_trade_no."\"," .
            "\"product_code\":\"PRE_AUTH_ONLINE\",".
            "\"subject\":\"".$pay->subject."\"," .
            "\"buyer_id\":\"".$pay->buyerid."\"," .
            "\"seller_id\":\"".$pay->sellerId."\"," .
            "\"total_amount\":".number_format(($pay->pay_amount / 100), 2, '.', '')."," .
            "\"body\":\"".$pay->body."\"," .
            "\"auth_no\":\"".$pay->auth_no."\"," .
            "\"auth_confirm_mode\":\"COMPLETE\"" .
        "}");
        //dd($AlipayTradePayRequest);
        $AlipayTradePayRequest->setNotifyUrl("http://www.baidu.com");

        $result = $this->aop->execute ($AlipayTradePayRequest);

        $responseNode = str_replace(".", "_",$AlipayTradePayRequest->getApiMethodName())."_response";

        return $result->$responseNode;
    }

    /**
     * [SyncOrder 订单同步]
     * @author Pudding
     * @DateTime 2019-10-12T19:30:00+0800
     * @param    [type]                   $order [description]
     */
    public function SyncOrder($order)
    {
        $AlipayTradeQueryRequest = new AlipayFundAuthOperationDetailQueryRequest();

        $AlipayTradeQueryRequest->setBizContent("{" .
            "\"out_order_no\":\"".$order->order_no."\"," .
            "\"out_request_no\":\"".$order->order_request_no."\"" .
        "}");

        $result = $this->aop->execute ($AlipayTradeQueryRequest);

        $responseNode = str_replace(".", "_",$AlipayTradeQueryRequest->getApiMethodName())."_response";

        return $result->$responseNode;
    }


    public function requestUserInfo($token)
    {
        $AlipayUserUserinfoShareRequest = new AlipayUserUserinfoShareRequest ();
        //$AlipayUserUserinfoShareRequest->setProdCode ( $token );
        $result = $this->aop->execute($AlipayUserUserinfoShareRequest, $token);
        return $result;
    }

    /**
     * [requestToken 用auth_code 换区token]
     * @author Pudding 2019-09-24
     * @param  [type] $code [description]
     * @return [type]       [description]
     */
    public function requestToken($code)
    {
        $AlipaySystemOauthTokenRequest = new AlipaySystemOauthTokenRequest ();
        $AlipaySystemOauthTokenRequest->setCode ( $code );
        $AlipaySystemOauthTokenRequest->setGrantType ( "authorization_code" );
        $result = $this->aop->execute($AlipaySystemOauthTokenRequest);
        return $result;
    }
}
