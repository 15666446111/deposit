<?php $__env->startSection('content'); ?>
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
                        <?php if(\Session::has('error')): ?>
                            <div id="messages" class="alert alert-danger animated fadeInUp dowebok">
                                <?php echo \Session::get('error'); ?>

                            </div>
                        <?php elseif(\Session::has('success')): ?>
                            <div id="messages" class="alert alert-success animated fadeInUp dowebok">
                                <?php echo \Session::get('success'); ?>

                            </div>
                        <?php endif; ?>
                        </div>
                        <div class="col-sm-6"></div>
                    </div>
                    <div class="row clearfix">
                        <div class="col-sm-2"></div>
                        <div class="col-sm-4"><h2 class="card-inside-title">支付宝配置信息</h2></div>
                        <div class="col-sm-5"></div>
                    </div>
                </div>
                <form action="<?php echo e(url('AliAuthconfig')); ?>" name="" method="post" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                <div class="row clearfix">
                    <div class="col-sm-2"></div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <div class="form-line">
                                <?php if($zfconfiginfo!= null): ?>
                            AppId:    <input type="text" class="form-control" value="<?php echo e($zfconfiginfo->app_id); ?>" placeholder="支付宝appid" name="app_id" autocomplete="on">
                                <?php else: ?>
                                    AppId:    <input type="text" class="form-control" value="" placeholder="支付宝appid" name="app_id" autocomplete="on">
                                <?php endif; ?>
                            </div>
                        </div>

                        
                            
                                
                            
                        

                        <div class="form-group">
                            <div class="form-line">
                                <?php if($zfconfiginfo!= null): ?>
                                private_key:   <input type="text" class="form-control" value="<?php echo e($zfconfiginfo->private_key); ?>" placeholder="商户私钥" name="private_key">
                                <?php else: ?>
                                private_key:   <input type="text" class="form-control" value="" placeholder="商户私钥" name="private_key">
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="form-line">
                                <?php if($zfconfiginfo!= null): ?>
                                public_key:   <input type="text" class="form-control" value="<?php echo e($zfconfiginfo->public_key); ?>" placeholder="商户公钥" name="public_key">
                                <?php else: ?>
                                public_key:   <input type="text" class="form-control" value="" placeholder="商户公钥" name="public_key">
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="form-line">
                                <?php if($zfconfiginfo!= null): ?>
                                alipay_pub_key:   <input type="text" class="form-control" value="<?php echo e($zfconfiginfo->alipay_pub_key); ?>" placeholder="支付宝公钥" name="alipay_pub_key">
                                <?php else: ?>
                                alipay_pub_key:   <input type="text" class="form-control" value="" placeholder="支付宝公钥" name="alipay_pub_key">
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="form-line">
                                <?php if($zfconfiginfo!= null): ?>
                                gatewayUrl:   <input type="text" class="form-control" value="<?php echo e($zfconfiginfo->gatewayUrl); ?>" placeholder="网关地址" name="gatewayUrl">
                                <?php else: ?>
                                gatewayUrl:   <input type="text" class="form-control" value="https://openapi.alipay.com/gateway.do" placeholder="网关地址" name="gatewayUrl">
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="form-line">
                                <?php if($zfconfiginfo!= null): ?>
                                sign_type:   <input type="text" class="form-control" value="<?php echo e($zfconfiginfo->sign_type); ?>" placeholder="支付宝签名类型" name="sign_type">
                                <?php else: ?>
                                sign_type:   <input type="text" class="form-control" value="RSA2" placeholder="支付宝签名类型" name="sign_type">
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="form-line">
                                <?php if($zfconfiginfo!= null): ?>
                                charset:   <input type="text" class="form-control" value="<?php echo e($zfconfiginfo->charset); ?>" placeholder="字符编码" name="charset">
                                <?php else: ?>
                                charset:   <input type="text" class="form-control" value="UTF-8" placeholder="字符编码" name="charset">
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php if(isset($user)): ?>
                        <input type="hidden" class="form-control" value="<?php echo e($user->username); ?>" placeholder="业务员账号" name="username" >
                        <?php else: ?>
                        <input type="hidden" class="form-control" value="" placeholder="业务员账号" name="username" >
                        <?php endif; ?>
                            <div class="form-group">
                            <div class="form-line">
                                <?php if($zfconfiginfo!= null): ?>
                                    收款账号:   <input type="text" class="form-control" value="<?php echo e($zfconfiginfo->account); ?>" placeholder="收款账号" name="account">
                                <?php else: ?>
                                    收款账号:   <input type="text" class="form-control" value="UTF-8" placeholder="收款账号" name="account">
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-line">
                                <?php if($zfconfiginfo!= null): ?>
                                    平台代号:   <input type="text" class="form-control" value="<?php echo e($zfconfiginfo->platform_code); ?>" placeholder="平台代号(唯一)" readonly name="platform_code">
                                <?php else: ?>
                                    平台代号:   <input type="text" class="form-control" value="UTF-8" placeholder="平台代号（唯一）" name="platform_code">
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-line">

                                    平台代号:   <input type="text" class="form-control" value="<?php echo e($user->platform); ?>" placeholder="平台代号(唯一)" readonly name="platform">
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

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.apps', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>