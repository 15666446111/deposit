@extends('layouts.apps')

@section('content')
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card" style="height: 100vh;border:0; box-shadow:0">

            <div class="header">
                <ol class="breadcrumb breadcrumb-col-pink">
                    <li><a href="/"><i class="material-icons">home</i> 后台主页</a></li>
                    <li class="active"><i class="material-icons">library_books</i> 重置密码</li>
                </ol>

                <ul class="header-dropdown m-r--5">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                            <span class="label label-dot label-info">Info</span>
                            <span class="label label-dot label-warning">Warning</span>
                            <span class="label label-dot label-danger">Danger</span>
                        </a>
                        <ul class="dropdown-menu pull-right">
                            <li><a href="javascript:void(0);" class=" waves-effect waves-block">TODO::</a></li>
                            <li><a href="javascript:void(0);" class=" waves-effect waves-block">TODO::</a></li>
                        </ul>
                    </li>
                </ul>
            </div>

            <div class="body" style="padding: 10px 30px">



                <div class="row clearfix" style="margin-top: 30px;">
                    <div class="row clearfix">
                        <div class="col-sm-2"></div>
                        <div class="col-sm-4">
                        @if(\Session::has('error'))
                            <div id="messages" class="alert alert-danger animated fadeInUp dowebok">
                                {!! \Session::get('error') !!}
                            </div>
                        @elseif(\Session::has('success'))
                            <div id="messages" class="alert alert-success animated fadeInUp dowebok">
                                {!! \Session::get('success') !!}
                            </div>
                        @endif
                        </div>
                        <div class="col-sm-6"></div>
                    </div>
                    <div class="row clearfix">
                        <div class="col-sm-2"></div>
                        <div class="col-sm-4"><h2 class="card-inside-title">支付宝配置信息</h2></div>
                        <div class="col-sm-5"></div>
                    </div>
                </div>
                <form action="{{url('AliAuthconfig')}}" name="" method="post" enctype="multipart/form-data">
                    @csrf
                <div class="row clearfix">
                    <div class="col-sm-2"></div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <div class="form-line">
                                @if ($zfconfiginfo!= null)
                            AppId:    <input type="text" class="form-control" value="{{$zfconfiginfo->app_id}}" placeholder="支付宝appid" name="app_id" autocomplete="on">
                                @else
                                    AppId:    <input type="text" class="form-control" value="" placeholder="支付宝appid" name="app_id" autocomplete="on">
                                @endif
                            </div>
                        </div>

                        {{--<div class="form-group">--}}
                            {{--<div class="form-line">--}}
                                {{--notify_url:   <input type="text" class="form-control" value="{{config('Alipay.notify_url')}}" placeholder="支付异步回调地址" name="notify_url">--}}
                            {{--</div>--}}
                        {{--</div>--}}

                        <div class="form-group">
                            <div class="form-line">
                                @if ($zfconfiginfo!= null)
                                private_key:   <input type="text" class="form-control" value="{{$zfconfiginfo->private_key}}" placeholder="商户私钥" name="private_key">
                                @else
                                private_key:   <input type="text" class="form-control" value="" placeholder="商户私钥" name="private_key">
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="form-line">
                                @if ($zfconfiginfo!= null)
                                public_key:   <input type="text" class="form-control" value="{{$zfconfiginfo->public_key}}" placeholder="商户公钥" name="public_key">
                                @else
                                public_key:   <input type="text" class="form-control" value="" placeholder="商户公钥" name="public_key">
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="form-line">
                                @if ($zfconfiginfo!= null)
                                alipay_pub_key:   <input type="text" class="form-control" value="{{$zfconfiginfo->alipay_pub_key}}" placeholder="支付宝公钥" name="alipay_pub_key">
                                @else
                                alipay_pub_key:   <input type="text" class="form-control" value="" placeholder="支付宝公钥" name="alipay_pub_key">
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="form-line">
                                @if ($zfconfiginfo!= null)
                                gatewayUrl:   <input type="text" class="form-control" value="{{$zfconfiginfo->gatewayUrl}}" placeholder="网关地址" name="gatewayUrl">
                                @else
                                gatewayUrl:   <input type="text" class="form-control" value="https://openapi.alipay.com/gateway.do" placeholder="网关地址" name="gatewayUrl">
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="form-line">
                                @if ($zfconfiginfo!= null)
                                sign_type:   <input type="text" class="form-control" value="{{$zfconfiginfo->sign_type}}" placeholder="支付宝签名类型" name="sign_type">
                                @else
                                sign_type:   <input type="text" class="form-control" value="RSA2" placeholder="支付宝签名类型" name="sign_type">
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="form-line">
                                @if ($zfconfiginfo!= null)
                                charset:   <input type="text" class="form-control" value="{{$zfconfiginfo->charset}}" placeholder="字符编码" name="charset">
                                @else
                                charset:   <input type="text" class="form-control" value="UTF-8" placeholder="字符编码" name="charset">
                                @endif
                            </div>
                        </div>
                        @if (isset($user))
                        <input type="hidden" class="form-control" value="{{$user->username}}" placeholder="业务员账号" name="username" >
                        @else
                        <input type="hidden" class="form-control" value="" placeholder="业务员账号" name="username" >
                        @endif
                            <div class="form-group">
                            <div class="form-line">
                                @if ($zfconfiginfo!= null)
                                    收款账号:   <input type="text" class="form-control" value="{{$zfconfiginfo->account}}" placeholder="收款账号" name="account">
                                @else
                                    收款账号:   <input type="text" class="form-control" value="UTF-8" placeholder="收款账号" name="account">
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-line">
                                @if ($zfconfiginfo!= null)
                                    平台代号:   <input type="text" class="form-control" value="{{$zfconfiginfo->platform_code}}" placeholder="平台代号(唯一)" readonly name="platform_code">
                                @else
                                    平台代号:   <input type="text" class="form-control" value="UTF-8" placeholder="平台代号（唯一）" name="platform_code">
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-line">

                                    平台代号:   <input type="text" class="form-control" value="{{$user->platform}}" placeholder="平台代号(唯一)" readonly name="platform">
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary waves-effect">修改配置</button>
                        </div>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
