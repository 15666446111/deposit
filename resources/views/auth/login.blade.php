@extends('layouts.app')

@section('content')
    <div class="wrapper">

        <div class="top_wrapper">
            <div class="container">
                <div class="col-sm-12 header"><img src="images/login_logo.png" width="140" height="37" class="retina" /></div>
            </div>
        </div>

        <div class="container">
            <div class="row">
                <div class="col-sm-12 login_content_wrapper">
                    <div class="content_wrapper">

                        @if(\Session::has('error'))
                            <div id="messages" class="alert alert-danger animated fadeInUp dowebok">
                                {!! \Session::get('error') !!}
                            </div>
                        @endif
               
                        <h1 class="title">登录到您的{{ config('app.name', 'Laravel') }}系统</h1>
                        {!! Form::open(array('url'=>route('login.ck'), 'method'=> 'post')) !!}
                            
                            <div class="form-group">
                                {!! Form::label('username','帐号:') !!}
                                {!! Form::text('username',old('username'),['class'=>'form-control','maxlength'=>'16','placeholder'=>'请输入您的帐号', 'required', 'autofocus']) !!}
                            </div>

                            <div class="form-group" style="margin: 30px 0;">
                                {!! Form::label('password','密码:') !!}
                                {!! Form::password('password',['class'=>'form-control','maxlength'=>'16','placeholder'=>'请输入您的密码', 'required']) !!}
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-sm-8">
                                        <!-- {!! Form::checkbox('remember',0,false,['class'=>'margin-top:-15px;']) !!} -->
                                        {!! Form::label('remember','Copyright  山东省联硕支付有限公司', ['style'=>"font-size:13px;font-weight:normal;"]) !!}
                                    </div>
                                    <div class="col-xs-12 col-sm-4 text-right">
                                        {!! Form::submit('登 入',['class'=>"btn btn-default btn-success"]) !!}
                                    </div>
                                </div>
                            </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
