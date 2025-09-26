<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title><?= $this->pageTitle ? $this->pageTitle . ' - ' : '' ?>Admin Panel - <?= SITE_NAME ?></title>
    <!-- Styles -->
    <link rel="stylesheet" href="<?= assets('css/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="<?= assets('css/font-awesome.min.css') ?>">
    <link rel="stylesheet" href="<?= assets('css/dataTables.bootstrap.min.css') ?>">
    <link rel="stylesheet" href="<?= assets('css/select2.min.css') ?>">
    <link rel="stylesheet" href="<?= assets('css/AdminLTE.min.css') ?>">
    <link rel="stylesheet" href="<?= assets('css/AdminLTE-red.min.css') ?>">
    <link rel="stylesheet" href="<?= assets('js/fancybox/jquery.fancybox.css') ?>">
    <link rel="stylesheet" href="<?= assets('css/admin_custom.css') ?>">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    <!-- Scripts -->
    <script src="<?= assets('js/jquery.min.js') ?>"></script>
    <script src="<?= assets('js/jquery-ui.min.js') ?>"></script>
    <script src="<?= assets('js/bootstrap.min.js') ?>"></script>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style>
    .alert-default { border-color: #aaa; background: #fff; }
    .skin-red .main-header .navbar { background-color: #222d32; }
    .skin-red .main-header .logo, .skin-red .main-header .logo:hover { background-color: #000; }
    </style>
</head>
<body class="hold-transition skin-red sidebar-mini">
    <div class="wrapper">
        <?= $header ?>
        <?= $sidebar ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <div class="box-body">
                <?php
                $success = $this->session->flashdata('success');
                $errors = $this->session->flashdata('error');

                $this->session->set_flashdata('success', '');
                $this->session->set_flashdata('error', '');
                ?>
                
                <?php if($success) { ?>
                <div class="alert alert-default"><?= $success ?></div>
                <?php } ?>

                <?php if($errors) { ?>
                <div class="alert alert-danger"><?= $errors ?></div>
                <?php } ?>

                <?php if($this->pageTitle) { ?>
                <section class="content-header">
                    <h1><?= $this->pageTitle ?></h1>
                </section>
                <?php } ?>

                <div class="content">
                    <?= $body ?>
                </div>
            </div>
        </div><!-- /.content-wrapper -->

        <footer class="main-footer">
            <div class="row">
                <div class="col-md-6">
                    <strong>Copyright &copy; <?= date('Y') ?> <a href="https://eetee.in" target="_blank">eetee.in</a>.</strong> All rights reserved.
                </div>
                <div class="col-md-6 text-right">
                    <a href="https://www.gltechnocraft.com/" target="_blank">Design and Developed by GLT. Pvt. Ltd.</a>
                </div>
            </div>
        </footer>
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
<script src="<?= assets('js/jquery.validate.min.js') ?>"></script>
<script src="<?= assets('js/additional-methods.min.js') ?>"></script>
<script src="<?= assets('js/jquery.dataTables.min.js') ?>"></script>
<script src="<?= assets('js/dataTables.bootstrap.min.js') ?>"></script>
<script src="<?= assets('js/adminlte.min.js') ?>"></script>
<script src="<?= assets('js/select2.min.js') ?>"></script>
<script src="<?= assets('js/nestable.js') ?>"></script>
<script src="<?= assets('js/ckeditor/ckeditor.js') ?>"></script>
<script src="<?= assets('js/ckeditor/adapters/jquery.js') ?>"></script>
<script src="<?= assets('js/fancybox/jquery.fancybox.min.js') ?>"></script>
<script src="<?= assets('js/admin_custom.js') ?>"></script>
</body>
</html>