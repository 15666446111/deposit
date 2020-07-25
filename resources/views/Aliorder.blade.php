<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1,user-scalable=no">
        <title>支付宝免押租赁</title>
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
            .weui-btn_primary{background-color: #108ee9;}
            .weui-btn_primary:not(.weui-btn_disabled):active{background-color: #108ee9;}
        </style>
        <script src="https://gw.alipayobjects.com/as/g/h5-lib/alipayjsapi/3.1.1/alipayjsapi.inc.min.js"></script>
    </head>
    <body>
        <img src="{{ asset('images/jq.png') }}" alt="" style="width: 100%;">

        <div class="weui-cells" style="margin-top: -5px;">
            <div class="weui-cell">
                <div class="weui-cell__bd">
                    <p>免押条件</p>
                </div>
                <div class="weui-cell__ft">芝麻分600及以上可免押金</div>
            </div>
            <div class="weui-cell">
                <div class="weui-cell__bd">
                    <p>商品押金</p>
                </div>
                <div class="weui-cell__ft"><span class="m">免押金</span> <e>99.00元</e></div>
            </div>

            {{--<form action="">--}}

                <div class="weui-cell nameIpt">
                    <div class="weui-cell__bd">
                        <p>您的姓名</p>
                    </div>
                    <div class="weui-cell__ft">
                        <input type="text" class="weui-input" style="text-align: center;" name="name" id="name" value="">
                    </div>
                </div>

                <div class="weui-cell phoneIpt">
                    <div class="weui-cell__bd">
                        <p>您的手机号</p>
                    </div>
                    <div class="weui-cell__ft">
                        <input type="text" class="weui-input" style="text-align: center;" name="mobile" id="mobile" value="">
                    </div>
                </div>

                {{--<div class="weui-cell">--}}
                    {{--<div class="weui-cell__bd">--}}
                        {{--<p>销售经理</p>--}}
                    {{--</div>--}}
                    {{--<div class="weui-cell__ft">--}}
                        {{--<input type="text" class="weui-input" style="text-align: right;" name="parent" value="{{ $parent }}" readonly>--}}
                    {{--</div>--}}
                {{--</div>--}}

                <div class="weui-cells weui-cells_checkbox" style="margin-top: 15px;">
                    <label class="weui-cell weui-check__label" for="x11">
                        <div class="weui-cell__bd">
                            <p> 我同意商户查询我的芝麻分或评估结果</p>
                        </div>
                        <div class="weui-cell__ft">
                            <input type="checkbox" class="weui-check" name="checkbox1" id="x11" checked>

                            <span class="weui-icon-checked"></span>
                        </div>
                    </label>
                </div>
                <div class="weui-msg__text-area">
                    <p class="weui-msg__desc">
                        注：该款产品开通服务后，请您于30个自然日内交易一笔 {{ $amounts }} 元以上金额，否则系统将扣除您"信用借还"抵押的99元押金，请您按要求使用产品。
                    </p>
                </div>
                <div class="weui-msg__opr-area">
                    <p class="weui-btn-area">
                        <a href="javascript:;" id="btn" class="weui-btn weui-btn_primary">提交申请</a>
                    </p>
                </div>
            {{--</form>--}}
        </div>

        <script src="https://cdn.bootcss.com/jquery/1.11.0/jquery.min.js"></script>
        <script src="https://cdn.bootcss.com/jquery-weui/1.2.1/js/jquery-weui.min.js"></script>
        <script>
            $(".nameIpt").click(function(){
                $("input[name=name]").focus();
            })
            $(".phoneIpt").click(function(){
                $("input[name=mobile]").focus();
            })


            var btn = document.querySelector('#btn');
            btn.addEventListener('click', function(){
                var radio = $('input:checkbox[name="checkbox1"]:checked').val();
                if(radio == null)
                {
                    $.alert("请勾选服务协议!");
                    return false;
                }

                var name  = $("#name").val();
                if($.trim(name) == "" || name == null)
                {
                    $.alert("请填写您的姓名!");
                    return false;
                }

                var pattern = /^[\u4E00-\u9FA5]{2,10}$/;
                if(!pattern.test(name))
                {
                    $.alert("姓名必须为中文，且在2到10个汉字之间");
                    return false;
                }

                var mobile  = $("#mobile").val();
                var myreg = /^(13[0-9]|14[579]|15[0-3,5-9]|16[6]|17[0135678]|18[0-9]|19[89])\d{8}$/;
                if(mobile == "" || mobile == null)
                {
                    $.alert("请填写您的手机号!");
                    return false;
                }

                if(!myreg.test(mobile))
                {
                    $.alert("请填写有效的手机号码!");
                    return false;
                }
                $.ajax({
                    url: "/setName",
                    data: {name: $("#name").val(),mobile: $("#mobile").val(), order: "{{$order->id}}"},
                    type: "POST",
                    dataType: "json",
                    success: function(data) {}
                });


                ap.tradePay({
                  orderStr: "{!! $FundAuthOrder !!}"
                }, function(res){
                    if (res.resultCode === "9000") {
                        ap.redirectTo("http://deposit.lswlpay.com/Ali/orderStatus/" + "{{$order->order_no}}");
                        //$.alert("订单支付成功 TO::!");
                    }
                    if (res.resultCode === "8000") {
                        $.alert("正在处理中..");
                    }
                    if (res.resultCode === "4000") {
                        $.alert("订单支付失败..");
                    }
                    if (res.resultCode === "6001") {
                        $.alert("已取消支付..");
                    }
                    if (res.resultCode === "6002") {
                        $.alert("网络连接出错..");
                    }
                });
            });
        </script>



    </body>
</html>
