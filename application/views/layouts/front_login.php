<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title><?= SITE_NAME ?></title>
    <!-- Styles -->
    <link rel="stylesheet" href="<?= assets('css/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="<?= assets('css/font-awesome.min.css') ?>">
    <link rel="stylesheet" href="<?= assets('css/AdminLTE.min.css') ?>">
    <link rel="stylesheet" href="<?= assets('css/AdminLTE-red.min.css') ?>">
    <link rel="stylesheet" href="<?= assets('css/admin_custom.css') ?>">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    <!-- Scripts -->
    <script src="<?= assets('js/jquery.min.js') ?>"></script>
    <script src="<?= assets('js/bootstrap.min.js') ?>"></script>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style>
    .alert-default { border-color: #aaa; background: #fff; }
    .login-page { background-image: url(<?= uploaded_url($this->vars['site']['login_bg']) ?>); background-size: cover; }
    </style>
</head>
<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo">
            <img src="<?= uploaded_url($this->vars['site']['logo']) ?>" alt="Logo" style="max-width: 200px; max-height: 100px" />
        </div>
        <div class="login-box-body">
            <?php $errors = $this->session->flashdata('error'); ?>
            <?php if($errors) { ?>
            <div class="alert alert-danger"><?= $errors ?></div>
            <?php } ?>

            <?php $success = $this->session->flashdata('success'); ?>
            <?php if($success) { ?>
            <div class="alert alert-default"><?= $success ?></div>
            <?php } ?>

            <?= $body ?>
        </div>
        <?php if($this->vars['site']['login_banner']) { ?>
        <div class="text-center"><img src="<?= uploaded_url($this->vars['site']['login_banner']) ?>" class="img-responsive" style="display:inline-block; max-height: 250px"></div>
        <?php } ?>
    </div>
    <?php if($success) { ?>
<script>
window.setTimeout(function() {
    $(".alert").fadeTo(500, 0).slideUp(500, function(){
        $(this).remove(); 
    });
}, 5000);
</script>
<?php } ?>
</body>
</html>