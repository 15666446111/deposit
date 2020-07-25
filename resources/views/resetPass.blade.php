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



                <div class="row clearfix" style="margin-top: 100px;">
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
                        <div class="col-sm-4"><h2 class="card-inside-title">重置我的密码</h2></div>
                        <div class="col-sm-5"></div>
                    </div>
                </div>
                <form action="" name="myform" method="post">
                    @csrf
                <div class="row clearfix">
                    <div class="col-sm-2"></div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <div class="form-line">
                                <input type="text" class="form-control" value="{{ old('oldpass')}}" placeholder="原先的旧密码" name="oldpass">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-line">
                                <input type="password" class="form-control" value="{{ old('newpass')}}" placeholder="新的密码,6位字符以上" name="newpass">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-line">
                                <input type="password" class="form-control" value="{{ old('conpass')}}" placeholder="确认新密码" name="conpass">
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary waves-effect">确认修改</button>
                        </div>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
