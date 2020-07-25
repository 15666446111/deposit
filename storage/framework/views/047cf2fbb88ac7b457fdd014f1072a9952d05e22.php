<?php $__env->startSection('content'); ?>
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

                        <?php if(\Session::has('error')): ?>
                            <div id="messages" class="alert alert-danger animated fadeInUp dowebok">
                                <?php echo \Session::get('error'); ?>

                            </div>
                        <?php endif; ?>
               
                        <h1 class="title">登录到您的<?php echo e(config('app.name', 'Laravel')); ?>系统</h1>
                        <?php echo Form::open(array('url'=>route('login.ck'), 'method'=> 'post')); ?>

                            
                            <div class="form-group">
                                <?php echo Form::label('username','帐号:'); ?>

                                <?php echo Form::text('username',old('username'),['class'=>'form-control','maxlength'=>'16','placeholder'=>'请输入您的帐号', 'required', 'autofocus']); ?>

                            </div>

                            <div class="form-group" style="margin: 30px 0;">
                                <?php echo Form::label('password','密码:'); ?>

                                <?php echo Form::password('password',['class'=>'form-control','maxlength'=>'16','placeholder'=>'请输入您的密码', 'required']); ?>

                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-sm-8">
                                        <!-- <?php echo Form::checkbox('remember',0,false,['class'=>'margin-top:-15px;']); ?> -->
                                        <?php echo Form::label('remember','Copyright  山东省联硕支付有限公司', ['style'=>"font-size:13px;font-weight:normal;"]); ?>

                                    </div>
                                    <div class="col-xs-12 col-sm-4 text-right">
                                        <?php echo Form::submit('登 入',['class'=>"btn btn-default btn-success"]); ?>

                                    </div>
                                </div>
                            </div>
                        <?php echo Form::close(); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>