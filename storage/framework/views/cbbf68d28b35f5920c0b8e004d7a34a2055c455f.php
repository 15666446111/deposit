<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="referrer" content="origin">

    <meta http-equiv="Cache-Control" content="no-store"/>

    <meta http-equiv="Pragma" content="no-cache"/>

    <meta http-equiv="Expires" content="0"/>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title><?php echo e(config('app.name', 'Laravel')); ?></title>

    <!-- Scripts -->
    <script src="<?php echo e(asset('js/app.js')); ?>" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles
    <link href="<?php echo e(asset('css/app.css')); ?>" rel="stylesheet">
    -->
    <link rel="stylesheet" href="https://daneden.github.io/animate.css/animate.min.css">
    <link rel="stylesheet" media="screen" href="<?php echo e(URL::asset('css/login.main.css')); ?>" />

    <style>.dowebok {animation-delay: .5s;-webkit-animation-delay:.5s;}</style>
</head>
<body class="animated fadeIn">

    <?php echo $__env->yieldContent('content'); ?>
</body>
</html>
