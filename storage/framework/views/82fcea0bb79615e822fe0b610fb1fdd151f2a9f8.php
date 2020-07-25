<?php $__env->startSection('content'); ?>

<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card" style="height: 100vh;border:0; box-shadow:0">

            <div class="header">
                <ol class="breadcrumb breadcrumb-col-pink">
                    <li><a href="/"><i class="material-icons">home</i> 后台主页</a></li>
                    <li class="active"><i class="material-icons">library_books</i> 生成我的二维码</li>
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
                <h5>二维码说明</h5>
                <p style="margin: 10px 0"><small>二维码有效期: 永久有效</small></p>
                <p style="margin: 10px 0"><small>二维码使用说明: 打开对应终端 , 按提示授权即可</small></p>
                <p style="margin: 10px 0"><small>二维码邀请关系: 每张二维码附带每个业务人员的邀请信息 , 请让自己客户扫码自己的二维码</small></p>
                <!-- Nav tabs -->
                <ul class="nav nav-tabs tab-col-orange" role="tablist">
                    <li role="presentation" class="">
                        <a href="#home_with_icon_title" data-toggle="tab" aria-expanded="false">
                            <i class="fa fa-wechat fa-lg"></i> 微信
                        </a>
                    </li>
                    <li role="presentation" class="active">
                        <a href="#profile_with_icon_title" data-toggle="tab" aria-expanded="false">
                            <i class="fa fa-yc-square fa-lg"></i> 支付宝
                        </a>
                    </li>
                    <li role="presentation" class="">
                        <a href="#messages_with_icon_title" data-toggle="tab" aria-expanded="true">
                            <i class="fa fa-ellipsis-h fa-lg"></i> 更多
                        </a>
                    </li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane fade" id="home_with_icon_title" >

                        <div class="img" style="width: 300px; text-align: center; float: left;">
                            <?php echo QrCode::size(300)->margin(0)->generate($WeHOST);; ?>

                            
                            <button type="button" class="btn btn-block btn-lg btn-success waves-effect download">
                                保存二维码
                            </button>
                        </div>
                        <div class="tools" style="width: 300px; float: left; margin-left: 50px;">
                            <div class="button">
                                <button class="btn btn-block btn-lg btn-success waves-effect download">
                                    前景颜色
                                </button>
                            </div>

                            <div class="button">
                                <button class="btn btn-block btn-lg btn-info waves-effect download">
                                    背景颜色
                                </button>
                            </div>

                            <div class="button">
                                <button class="btn btn-block btn-lg bg-pink waves-effect download">
                                    LOGO图标
                                </button>
                            </div>
                            <div class="button">
                                <button class="btn btn-block btn-lg btn-success waves-effect download">
                                    图片大小
                                </button>
                            </div>
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane fade active in" id="profile_with_icon_title">
                        <div class="img" style="width: 300px; text-align: center; float: left;">
                            <img src="<?php echo e(asset('storage/qrcode/'.session('users.username').'ali.png')); ?>"/>  </br> </br>
                            <button type="button" style="background-color: #108ee9!important;" class="btn btn-block btn-lg btn-success waves-effect download">
                                <a href="<?php echo e(asset('storage/qrcode/'.session('users.username').'ali.png')); ?>"  download=""> <font color="black">保存二维码</font> </a>
                            </button>
                        </div>
                        <div class="tools" style="width: 300px; float: left; margin-left: 50px; margin-top:180px;">
                            <div class="button">
                                <button class="btn btn-block btn-lg btn-success waves-effect download">
                                    前景颜色
                                </button>
                            </div>

                            <div class="button">
                                <button class="btn btn-block btn-lg btn-info waves-effect download">
                                    背景颜色
                                </button>
                            </div>

                            <div class="button">
                                <button class="btn btn-block btn-lg bg-pink waves-effect download">
                                    LOGO图标
                                </button>
                            </div>
                            <div class="button">
                                <button class="btn btn-block btn-lg btn-success waves-effect download">
                                    图片大小
                                </button>
                            </div>
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane fade" id="messages_with_icon_title">

                        <h4 style="text-align: center; margin-top:100px">等待开发..</h4>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.apps', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>