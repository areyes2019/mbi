<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>MBI-Iniciar</title>

    <!-- Custom fonts for this template-->
    <link href="<?php echo base_url('public/panel/vendor/fontawesome-free/css/all.min.css'); ?>" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="<?php echo base_url('public/panel/css/sb-admin-2.min.css'); ?>" rel="stylesheet">
    <script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>

</head>

<body class="bg-gradient-primary">

    <div class="container">

        <!-- Outer Row -->
        <div id="app">
            <div class="row justify-content-center">
                <?php echo $this->renderSection('login-panel') ?>
            </div>
        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="<?php echo base_url('public/panel/vendor/jquery/jquery.min.js'); ?> "></script>
    <script src="<?php echo base_url('public/js/notify.min.js'); ?>"></script>
    <script src="<?php echo base_url('public/js/login.js'); ?> "></script>
    <script src="<?php echo base_url('public/panel/vendor/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>

    <!-- Core plugin JavaScript-->
    <script src="<?php echo base_url('public/panel/vendor/jquery-easing/jquery.easing.min.js'); ?>"></script>

    <!-- Custom scripts for all pages-->
    <script src="<?php echo base_url('public/panel/js/sb-admin-2.min.js'); ?> "></script>

</body>

</html>