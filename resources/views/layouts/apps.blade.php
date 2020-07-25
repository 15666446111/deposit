<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="referrer" content="origin">

    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <meta http-equiv="Cache-Control" content="no-store"/>

    <meta http-equiv="Pragma" content="no-cache"/>

    <meta http-equiv="Expires" content="0"/>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    -->
    <link rel="stylesheet" href="https://daneden.github.io/animate.css/animate.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">
    <link href="//netdna.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <!--ZUI 框架样式-->
    <link rel="stylesheet" href="{{ URL::asset('css/zui.min.css') }}">
    <!--bootstrap-->
    <link href="{{ URL::asset('css/bootstrap.css') }}" rel="stylesheet">
    <!--sweetalert-->
    <link href="{{ URL::asset('css/sweetalert.css') }}" rel="stylesheet">

    <link href="{{ URL::asset('css/left.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('css/Admin.css') }}" rel="stylesheet">

    <style>
        .dowebok {animation-delay: .5s;-webkit-animation-delay:.5s;}
        .contentbox{margin-left:200px; height: 100vh;}
        .nav-tabs > li > a {line-height: 1.4; }
        .nav-tabs > li > a .fa{margin-right: 10px; line-height: 1.4; font-size:22px;}
        .nav-tabs > li.active > a .fa-wechat{color:#06AE56;}
        .nav-tabs > li.active > a .fa-yc-square{color:#00a3ee;}
        .nav-tabs > li.active > a .fa-ellipsis-h{color:#2196F3;}
        .tools .button{width: 100%;  margin-right: 3%; margin-top: 30px;}
    </style>

</head>
<body class="animated fadeIn">
<!-- Left Sidebar -->
<aside id="leftsidebar" class="sidebar">
    <!-- User Info -->
    <div class="user-info">
        <div class="image">
            <img src="{{ URL::asset('images/user.png') }} " width="58" height="58" alt="UserFace" />


        </div>
        <div class="info-container">
            <div class="name">
                <i class="material-icons">supervisor_account</i>{{ Session::get('users.username') }}
                <a href="/logot" title="退出登录" style="color:white; float: right;">
                    <i class="material-icons">power_settings_new</i>
                </a>
            </div>
            <div class="name">
                <i class="material-icons">email</i>{{ Session::get('users.email') }}
            </div>
        </div>
    </div>
    <!-- #User Info -->

    <!-- Menu -->
    <div class="menu">
        <ul class="list">

            <!--一级菜单遍历开始-->

            <li class="">
                <a href="javascript:void(0);" class="menu-toggle">
                    <i class="material-icons">account_circle</i><span>个人中心</span>
                </a>
                <!--如果当前栏目有下级菜单 显示下级菜单-->

                <ul class="ml-menu">
                    <li class=""><a href="/resetPass">重设密码</a></li>
                    <li class=""><a href="/qrcode">我的二维码</a></li>
                </ul>
            </li>

            @if((session('users'))->platform_role=='system' || (session('users'))->platform_role=='administer' || (session('users'))->isLeader)
            <li class="">
                <a href="javascript:void(0);" class="menu-toggle">
                    <i class="material-icons">supervisor_account</i><span>业务管理</span>
                </a>
                <ul class="ml-menu">
                    <li class=""><a href="/AccountList">业务帐号列表</a></li>
                </ul>
            </li>
            @endif



            <li class="">
                <a href="javascript:void(0);" class="menu-toggle">
                    <i class="material-icons">favorite_border</i><span>我的订单</span>
                </a>
                <!--如果当前栏目有下级菜单 显示下级菜单-->

                <ul class="ml-menu">
                    <li class=""><a href="">微信订单</a></li>
                    <li class=""><a href="/Aliorder">支付宝订单</a></li>
                </ul>
            </li>
            {{--@if(Session::get('users.ismanage') == "1")--}}
            {{--<li class="">--}}
                {{--<a href="javascript:void(0);" class="menu-toggle">--}}
                    {{--<i class="material-icons">favorite_border</i><span>支付授权配置</span>--}}
                {{--</a>--}}
                {{--<!--如果当前栏目有下级菜单 显示下级菜单-->--}}

                {{--<ul class="ml-menu">--}}
                    {{--<li class=""><a href="">微信订单</a></li>--}}
                    {{--<li class=""><a href="AliAuthconfig">支付宝授权配置</a></li>--}}
                {{--</ul>--}}
            {{--</li>--}}
            {{--@endif--}}
        </ul>
    </div>
    <!-- #Menu -->
    <!-- Footer -->
    <div class="legal">
        <div class="copyright">
            &copy; 2018 - 2018 <a href="javascript:void(0);">Pudding.</a>.
        </div>
        <div class="version"><b>Version: </b> 1.0.5</div>
    </div>
    <!-- #Footer -->
</aside>
<!-- #END# Left Sidebar -->

<div class="card contentbox">
    @if(count($errors)>0)
        @foreach($errors->all() as $error)
            <div id="messages" class="alert alert-danger animated fadeInUp dowebok">
                 {{ $error }}
            </div>
        @endforeach
    @endif
    @if (Session::has('success'))
        <div id="messages" class="alert alert-success animated fadeInUp dowebok">
            {!! Session::get('success') !!}
        </div>
    @endif
    @yield('content')
</div>
<!-- #END# Left Sidebar -->
<script src="{{ URL::asset('js/jquery.min.js') }} "></script>
<!-- bootstrap -->
<script src="{{ URL::asset('js/bootstrap.js') }} "></script>

<script src="{{ URL::asset('js/zui.min.js') }} "></script>
<!--sweetalert-->
<script src="{{ URL::asset('js/sweetalert.min.js') }} "></script>
<script src="{{ URL::asset('js/admin.js') }} "></script>
<script src="{{ URL::asset('js/AppMain.js?t=15666446111') }}" charset="utf-8"></script>
</body>
</html>
