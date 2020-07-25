<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>订单申请成功</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <link rel="stylesheet" href="https://cdn.bootcss.com/weui/1.1.3/style/weui.min.css">
        <link rel="stylesheet" href="https://cdn.bootcss.com/jquery-weui/1.2.1/css/jquery-weui.min.css">
        <style>
            .weui-cell__bd p{font-size: 14px;}
            .weui-cell__ft{float: right; color: #00cdb7; font-size: 14px;}
            .m{padding: 3px 8px; border:1px solid #00cdb7; }
            .weui-cell__ft e{color:#666; text-decoration: line-through;}
            .weui-msg__text-area{padding: 0 15px;}
            .weui-icon-success{color:#108ee9;}
            .weui-btn_primary{background-color: #108ee9;}
            .weui-btn_primary:not(.weui-btn_disabled):active{background-color: #108ee9;}
        </style>
        <script src="https://gw.alipayobjects.com/as/g/h5-lib/alipayjsapi/3.1.1/alipayjsapi.inc.min.js"></script>
    </head>
    <body>
        <div class="weui-msg">
          <div class="weui-msg__icon-area"><i class="weui-icon-success weui-icon_msg"></i></div>
          <div class="weui-msg__text-area">
            <h2 class="weui-msg__title">订单申请成功!</h2>
            <p class="weui-msg__desc">请联系您的客服经理进行后续操作<!-- <a href="javascript:void(0);">文字链接</a> --></p>
          </div>
          <div class="weui-msg__opr-area">
            <p class="weui-btn-area">
              <a href="javascript:;" onclick="window.history.back()" class="weui-btn weui-btn_primary">回到首页</a>
              <!-- <a href="javascript:;" class="weui-btn weui-btn_default">辅助操作</a> -->
            </p>
          </div>
          <div class="weui-msg__extra-area">
            <div class="weui-footer">
              <p class="weui-footer__links">
                <a href="http://ls.baifeidianzi.com/wap/download/down" class="weui-footer__link">智能惠管家</a>
              </p>
              <p class="weui-footer__text">Copyright © 2019-2022 山东联硕支付有限公司</p>
            </div>
          </div>
        </div>
        <script src="https://cdn.bootcss.com/jquery/1.11.0/jquery.min.js"></script>
        <script src="https://cdn.bootcss.com/jquery-weui/1.2.1/js/jquery-weui.min.js"></script>
    </body>
</html>