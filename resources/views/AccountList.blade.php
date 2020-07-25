@extends('layouts.apps')
@section('content')
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card" style="overflow: auto!important;">
            <div class="header">
                <ol class="breadcrumb breadcrumb-col-pink">
                    <li><a href="/"><i class="material-icons">home</i> 后台主页</a></li>
                    <li class="active"><i class="material-icons">library_books</i> 业务人员帐号</li>
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
                <div class="row clearfix">
                    <form action="" method="post">
                        @csrf
                        <div class="col-md-2">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="material-icons">person</i></span>
                                <div class="form-line"><input type="text" name="username" value="" class="form-control" placeholder="业务帐号:手机号登录帐号"></div>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="material-icons">person</i></span>
                                <div class="form-line"><input type="password" name="password" value="" class="form-control" placeholder="帐号密码:登录此帐号的密码"></div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="material-icons">person</i></span>
                                <div class="form-line"><input type="text" name="name" value="" class="form-control" placeholder="业务姓名:业务员名字"></div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="material-icons">person</i></span>
                                <div class="form-line"><input type="text" name="email" value="" class="form-control" placeholder="邮箱帐号:业务员邮箱帐号(选填)"></div>
                            </div>
                        </div>

                        @if((session('users'))->platform_role=='system')
                        <div class="col-md-2">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="material-icons">person</i></span>
                                <div class="form-line"><input type="text" name="platform" value="" class="form-control" placeholder="商户信息（必填，唯一）"></div>
                            </div>
                        </div>
                        @else
                            <div class="col-md-2">
                          <div class="input-group">
                                        <span class="input-group-addon"><i class="material-icons">person</i></span>
                                        <div class="form-line"><input type="text" name="platform" value="{{ session()->get('users.platform') }}" class="form-control" readonly placeholder="商户信息（必填，唯一）"></div>
                          </div>
                            </div>
                        @endif
                    <!---管理员可以添加小组信息-->
                        @if((session('users'))->platform_role=='administer')
                            <div class="col-md-2">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="material-icons">person</i></span>
                                    <div class="form-line"><input type="text" name="groups" value="" class="form-control" placeholder="组别名称"></div>
                                </div>
                            </div>
                        @elseif((session('users'))->platform_role!='system' && (session('users'))->platform_role=='member' && (session('users'))->isLeader)
                        <!--小组长只能添加本组会员-->
                            <div class="col-md-2">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="material-icons">person</i></span>
                                    <div class="form-line"><input type="text" name="groups" value="{{ (session('users'))->groups }}" class="form-control" readonly placeholder="组别名称"></div>
                                </div>
                            </div>
                        @endif
                        @if((session('users'))->platform_role=='administer')
                            <div class="col-md-2">
                                <div class="input-group">
                                    <input type="checkbox" value="1" id="isLeader" name="isLeader"> <label for="isLeader">组长</label>
                                </div>
                            </div>
                        @endif

                        <div class="col-md-2">
                            <div class="input-group">
                                <button type="submit" class="btn btn-primary waves-effect">添加业务员</button>
                            </div>
                        </div>

                    </form>

                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>业务帐号</th>
                            <th>业务人员</th>
                            <th>帐号邮箱</th>
                            <th>帐号状态</th>
                            <th>交易订单</th>
                            <th>商户信息</th>
                            <th>用户组别</th>
                            <th>注册时间</th>
                            <th>配置</th>
                            <th>操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($lists as $v)
                        <tr>
                            <td>#</td>
                            <td> <a href="{{url('Aliorder',['order_parent' => $v->username])}}">{{ $v->username }}</a></td>
                            <td>{{ $v->name }}</td>
                            <td>{{ $v->email }}</td>
                            <td>
                                @if($v->status)
                                <i class="material-icons" style="color:#2b982b" title="正常">check_circle</i>
                                @else
                                <i class="material-icons" style="color:#fb483a" title="禁止登录">do_not_disturb</i>
                                @endif
                            </td>
                            <td><code>{{ $v->order_many_count }} 条</code></td>
                            <td>
                                <code>{{ $v->platform }}</code>
                                @if($v->platform_role=='administer')
                                    <b>管理员</b>
                                    @elseif($v->platform_role=='member')
                                    业务员
                                    @else
                                    <b style="color: red">系统管理员</b>
                                @endif
                            </td>
                            <td>
                                <p style="padding: 5px 0;">
                                    <code>{{ $v->groups }}</code>
                                    @if($v->isLeader)
                                        组长
                                    @else
                                        组员
                                    @endif
                                </p>
                            </td>
                            <td>{{ $v->created_at }}</td>
                            <td>
                                @if((session('users'))->platform_role=='system' || (session('users'))->platform_role=='administer' || (session('users'))->isLeader==1)
                                    @if((session('users'))->platform_role=='system' && ($v->platform_role=='administer' || $v->platform_role=='system'))
                                        <button><a href="{{url('AliAuthconfig',['username'=> $v->username])}}" class="btn btn-primary ">支付授权配置</a> </button>
                                        @else
                                         -
                                    @endif
                            </td>
                            <td>
                                    @if((session('users'))->id != $v->id)
                                        <button>
                                            <a href="{{ route('ban_account',$v->id) }}" class="btn btn-primary ">
                                                @if($v->status==1)
                                                    禁用
                                                @else
                                                    启用
                                                @endif
                                            </a>
                                        </button>
                                    @else
                                        当前会员
                                    @endif
                                @endif
                            </td>
                        </tr>
                        @endforeach
                        <tr>
                            <td colspan="18">{{ $lists->links() }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection
