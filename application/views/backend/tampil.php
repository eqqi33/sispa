<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php //$title_page;?></title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="<?=base_URL('assets/backend/lib/bootstrap/css/bootstrap.min.css')?>">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?=base_URL('assets/backend/lib/font-awesome/css/font-awesome.min.css')?>">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?=base_URL('assets/backend/lib/ionicons/css/ionicons.min.css')?>">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?=base_URL('assets/backend/css/AdminLTE.min.css')?>">
  <!-- AdminLTE Skins. We have chosen the skin-blue for this starter
        page. However, you can choose any other skin. Make sure you
        apply the skin class to the body tag so the changes take effect.
  -->
  <link rel="stylesheet" href="<?=base_URL('assets/backend/css/skins/skin-blue.min.css')?>">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="<?=base_URL('assets/backend/js/html5shiv.min.js')?>"></script>
  <script src="<?=base_URL('assets/backend/js/respond.min.js')?>"></script>
  <![endif]-->
  <!-- jQuery 2.2.3 -->
  <script src="<?=base_URL('assets/backend/lib/jQuery/jquery-2.2.3.min.js')?>"></script>  
</head>
<!--
BODY TAG OPTIONS:
=================
Apply one or more of the following classes to get the
desired effect
|---------------------------------------------------------|
| SKINS         | skin-blue                               |
|               | skin-black                              |
|               | skin-purple                             |
|               | skin-yellow                             |
|               | skin-red                                |
|               | skin-green                              |
|---------------------------------------------------------|
|LAYOUT OPTIONS | fixed                                   |
|               | layout-boxed                            |
|               | layout-top-nav                          |
|               | sidebar-collapse                        |
|               | sidebar-mini                            |
|---------------------------------------------------------|
-->
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <!-- Main Header -->
    <?php $this->load->view('backend/'.$top)?>
  <!-- Left side column. contains the logo and sidebar -->
    <?php $this->load->view('backend/'.$left)?>

  <!-- Content Wrapper. Contains page content -->
    <?php $this->load->view('backend/'.$main)?>
  <!-- /.content-wrapper -->

  <!-- Main Footer -->
    <?php $this->load->view('backend/'.$bottom)?>

  <!-- Control Sidebar -->
    <?php $this->load->view('backend/'.$right)?>
  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<!-- REQUIRED JS SCRIPTS -->
<!-- Bootstrap 3.3.6 -->
<script src="<?=base_URL('assets/backend/lib/bootstrap/js/bootstrap.min.js')?>"></script>
<!-- AdminLTE App -->
<script src="<?=base_URL('assets/backend/js/app.min.js')?>"></script>
<script src="<?=base_URL('assets/backend/lib/datatables/jquery.dataTables.min.js')?>" type="text/javascript"></script>
<script src="<?=base_URL('assets/backend/lib/datatables/dataTables.bootstrap.min.js')?>" type="text/javascript"></script>
<script src="<?=base_URL('assets/backend/lib/datatables/extensions')?>/buttons/js/dataTables.buttons.js" type="text/javascript"></script>
<script src="<?=base_URL('assets/backend/lib/datatables/extensions/buttons/js/buttons.html5.js')?>" type="text/javascript"></script>
<script src="<?=base_URL('assets/backend/lib/datatables/extensions/buttons/js/buttons.flash.js')?>" type="text/javascript"></script>
<script src="<?=base_URL('assets/backend/lib/datatables/extensions/buttons/js/buttons.print.js')?>" type="text/javascript"></script>
<script src="<?=base_URL('assets/backend/lib/datatables/extensions/buttons/js/buttons.colVis.js')?>" type="text/javascript"></script>
<script src="<?=base_URL('assets/backend/lib/datatables/extensions/buttons/js/buttons.bootstrap.js')?>" type="text/javascript"></script>
<script src="<?=base_URL('assets/backend/js/jszip.min.js')?>" type="text/javascript"></script>
<script src="<?=base_URL('assets/backend/js/pdfmake.min.js')?>" type="text/javascript"></script>
<script src="<?=base_URL('assets/backend/js/vfs_fonts.js')?>" type="text/javascript"></script>
<!-- Optionally, you can add Slimscroll and FastClick plugins.
     Both of these plugins are recommended to enhance the
     user experience. Slimscroll is required when using the
     fixed layout. -->
</body>
</html>