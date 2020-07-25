@extends('layouts.apps')

@section('content')
<style>
    .scdesc{color:#FF5722; margin: 10px 30px; font-weight: normal;}
</style>
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card" style="height: 100vh;border:0;overflow: auto!important;">

            <div class="header">
                <ol class="breadcrumb breadcrumb-col-pink">
                    <li><a href="/"><i class="material-icons">home</i> 后台主页</a></li>
                    <li class="active"><i class="material-icons">library_books</i> 我的支付宝订单 </li>
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
            <div>
                <h5 class="scdesc">
                    1: 进度说明中, 超过30天未激活机器的订单将自动转为预授权支付(自动在客户的余额中抵扣订单金额),请确保客户须知</h5>
                <h5 class="scdesc">2: 30天激活机器宽限期 计算说明: 在第一次点击查看机器,绑定机器的时间开始, 截至到今天的时间跨度, 大于30天自动扣款</h5>
                <h5 class="scdesc">3: 绑定机器30天之内,客服确认机器激活, 操作订单金额解冻, 原下单用户预授权的金额将不予扣除, 30天之后也不会扣除,请和客户做好确认工作</h5>
            </div>

            <div class="body" style="padding: 10px 30px">
                <div class="row clearfix">

                    <form action="" name="myform" method="get">


                        <div class="col-md-2">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="material-icons">person</i></span>
                                <div class="form-line"><input type="text" name="ORDER" value="{{ isset($where['ORDER']) ? $where['ORDER'] : '' }}" class="form-control date" placeholder="订单号:授权订单号"></div>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="material-icons">person</i></span>
                                <div class="form-line"><input type="text" name="NICKNAME" value="{{ isset($where['NICKNAME']) ? $where['NICKNAME'] : '' }}" class="form-control date" placeholder="会员姓名:订单会员姓名"></div>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="material-icons">person</i></span>
                                <div class="form-line"><input type="text" name="bind_sn" value="{{ isset($where['bind_sn']) ? $where['bind_sn'] : '' }}" class="form-control date" placeholder="机器的终端编号或者商编"></div>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="material-icons">person</i></span>
                                <div class="form-line"><input type="text" name="username" value="{{ isset($where['username']) ? $where['username'] : '' }}" class="form-control date" placeholder="业务员"></div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="material-icons">person</i></span>
                                <div class="form-line">
                                    <select name="PAY" class="form-control">
                                        <option @if(isset($where['PAY']) and $where['PAY'] == 'all') selected @endif value="all">全部</option>
                                        <option @if(isset($where['PAY']) and $where['PAY'] == '1') selected @endif value="1">已授权</option>
                                        <option @if(isset($where['PAY']) and $where['PAY'] == '0') selected @endif value="0">未授权</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="material-icons">person</i></span>
                                <div class="form-line">
                                    <select name="thaw" class="form-control">
                                        <option @if(isset($where['thaw']) and $where['thaw'] == 'all') selected @endif value="all">全部</option>
                                        <option @if(isset($where['thaw']) and $where['thaw'] == '1') selected @endif value="1">已解冻</option>
                                        <option @if(isset($where['thaw']) and $where['thaw'] == '0') selected @endif value="0">未解冻</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="material-icons">person</i></span>
                                <div class="form-line">
                                    <select name="payer" class="form-control">
                                        <option @if(isset($where['payer']) and $where['payer'] == 'all') selected @endif value="all">全部</option>
                                        <option @if(isset($where['payer']) and $where['payer'] == '1') selected @endif value="1">已转支付</option>
                                        <option @if(isset($where['payer']) and $where['payer'] == '0') selected @endif value="0">未转支付</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary waves-effect">搜索</button>
                        </div>
                    </form>
                </div>

                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>授权订单</th>
                            <th>会员姓名</th>
                            <th>会员手机号</th>
                            <th>所属业务员</th>
                            <th>机器Sn</th>
                            <th>商编</th>
                            {{-- <th>订单标题</th> --}}
                            <th>金额</th>
                            {{-- <th>资金类型</th> --}}
                            <th>冻结金额</th>
                            <th>授权状态</th>
                            {{-- <th>处理时间</th> --}}
                            <th>创建时间</th>
                            <th>付款方支付宝帐号</th>
                            <th>累积冻结</th>
                            <th>累积解冻</th>
                            <th>累积支付</th>
                            <th>剩余冻结</th>
                           {{-- <th>创建时间</th> --}}
                            <th>处理时间</th>
                            <th>机器信息</th>
                            <th>进度说明</th>
                            <th>操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($list as $v)
                        <tr>
                            <td>#</td>
                            <td>{{ $v->order_no }}</td>
                            <td>{{ $v->order_user_name }}</td>
                            <td>{{ $v->order_mobile }}</td>
                            <td>{{ $v->parent_name }}</td>
                            <td>
                                @if($v->toBind)
                                    {{ $v->toBind->bind_sn }}
                                @endif
                            </td>
                            <td>
                                @if($v->toBind)
                                    {{ $v->toBind->bind_merch }}
                                @endif
                            </td>
                            {{-- <td>{{ $v->order_title }}</td> --}}
                            <td><code>{{ number_format($v->order_amount / 100, 2, '.', '') }}</code></td>
                            {{-- <td>{{ $v->alipay_operation_type }}</td> --}}
                            <td><code>{{ number_format($v->amount / 100, 2, '.', '') }}</code></td>
                            <td>{{ $v->alipay_status }}</td>
                            {{--<td>{{ $v->alipay_gmt_trans }}</td> --}}
                            <td>{{ $v->created_at }}</td>
                            <td>{{ $v->alipay_payer_logon }}</td>
                            <td><code>{{ number_format($v->total_freeze_amount / 100, 2, '.', '') }}元</code></td>
                            <td><code>{{ number_format($v->total_unfreeze_amount / 100, 2, '.', '') }}元</code></td>
                            <td><code>{{ number_format($v->total_pay_amount / 100, 2, '.', '') }}元</code></td>
                            <td><code>{{ number_format($v->rest_amount / 100, 2, '.', '') }}元</code></td>
                            {{--<td>{{ $v->created_at }}</td> --}}
                            <td>{{ $v->alipay_gmt_trans }}</td>
                            <td>
                                @if($v->alipay_status == 'SUCCESS')
                                <a data-placement="top" data-iframe="/OrderBind/{{ $v->order_no }}" data-original-title='查看绑定机器详情' data-icon="icon-refresh" data-loadingIcon="icon-refresh" toggle="tips" data-toggle="modal" data-width="700" data-height='500' data-title="查看绑定机器详情">
                                    查看机器
                                </a>
                                @endif
                            </td>
                            <td>
                                @if($v->alipay_status == 'SUCCESS')
                                    @if($v->total_unfreeze_amount > 0 )
                                        <code style="color: green"> 已解冻资金</code>
                                    @elseif($v->total_pay_amount > 0 )
                                        <code style="color: #2196F3"> 授权已转支付</code>
                                    @else
                                        @if(empty($v->toBind) or $v->toBind == null)
                                            <code style="color:#E91E63">未绑定机器</code>
                                        @else
                                            <code @if($v->toBind->created_at->diffInDays() <= 20) style="color:#FF9800" @else style="color:#9C27B0"  @endif>{{ $v->toBind->created_at->diffInDays() }}天前配送</code>
                                        @endif
                                    @endif
                                @endif
                                </code>
                            </td>
                            <td>
                                @if($v->rest_amount > 0 and $v->alipay_status == 'SUCCESS' and (Session::get('users.ismanage') == "1" || Session::get('users.platform_role')=='system' || Session::get('users.platform_role')=='administer'))
                                <a class="manipulate bg-red run" toggle="tips" data-placement="top" data-original-title="订单金额解冻" data-url="/OrderThaw/{{ $v->order_no }}" data-text="订单解冻后将无法再进行支付扣款, 请确认好该订单绑定的机器已激活!">
                                    <i class="material-icons">replay</i>
                                </a>
                                @endif
                                <a class="manipulate bg-blue" toggle="tips" data-placement="top" data-original-title="订单同步" data-text="订单将和支付宝同步!" target="_blank" href="/OrderSync/{{ $v->order_no }}">
                                    <i class="material-icons">search</i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                        <tr>
                            <td colspan="18">{{ $list->appends($where)->links() }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection
