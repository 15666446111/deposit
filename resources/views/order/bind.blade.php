@extends('layouts.app')
@section('Css')
<link href="{{ URL::asset('css/zui.dashboard.min.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="card" style="height: 100%">

        @if(\Session::has('error'))
            <div id="messages" class="alert alert-danger animated fadeInUp dowebok">
                {!! \Session::get('error') !!}
            </div>
        @endif

        @if(\Session::has('success'))
            <div id="messages" class="alert alert-success animated fadeInUp dowebok">
                {!! \Session::get('success') !!}
            </div>
        @endif

        <div class="col-md-12">
            <table class="table table-striped">
                <tbody>
                    <form action="" method="post">
                        @csrf
                    <tr>
                        <td>订单编号</td>
                        <td>{{ $no }}</td>
                    </tr>
                    <tr>
                        <td>机器型号</td>
                        <td>
                            <input type="text" name="bind_title" class="form-control" value="{{ isset($bind->bind_title) ? $bind->bind_title : '' }}">
                        </td>
                    </tr>
                    <tr>
                        <td>机器终端</td>
                        <td>
                            <input type="text" name="bind_sn" class="form-control" value="{{ isset($bind->bind_sn) ? $bind->bind_sn : '' }}"></td>
                    </tr>
                    <tr>
                        <td>机器商编</td>
                        <td>
                            <input type="text" name="bind_merch" class="form-control" value="{{ isset($bind->bind_merch) ? $bind->bind_merch : '' }}"></td>
                    </tr>
                    <tr>
                        <td>是否激活</td>
                        <td>
                            <input type="text" name="bind_active" class="form-control" value="{{ isset($bind->bind_active) ? $bind->bind_active : '' }}"></td>
                    </tr>
                    <tr>
                        <td>绑定时间</td>
                        <td>{{ isset($bind->created_at) ? $bind->created_at : '' }}</td>
                    </tr>
                    <tr>
                        <td colspan="2" style="text-align: center;">
                            @if(Session::get('users.ismanage') == "1" || Session::get('users.platform_role')=='system' || Session::get('users.platform_role')=='administer' )
                            <button class="btn btn-primary" type="submit">绑定</button>
                            @endif
                        </td>
                    </tr>
                    </form>
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('Javascript')
<script>
    $(".reloadfr").click(function(){
        $.ajax({
            type: "GET",
            url : '/WithdrawReload/',
            dataType: "json",
            success: function(result){
                //var result=eval('('+data+')');
                showNotification(result.code=='1' ? "alert-success" : "alert-danger", result.msg, "top", "center", "", "");
                setTimeout(function(){ window.location.reload(); }, 2000);
            },
            beforeSend: function(){
                $(this).attr("disabled","disabled");
                $(this).html("<i class='icon icon-spin icon-spinner'></i> 分润中, 请稍后...");
            }
        })
    })
</script>
@endsection
