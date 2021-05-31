
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AdminLTE 3 | Blank Page</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/ionicons/2.0.1/css/ionicons.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <!-- Select2 -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
	<!-- Custom -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/dist/css/custom.css">
  <!-- jQuery -->
  <script src="<?php echo base_url(); ?>assets/plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="<?php echo base_url(); ?>assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- AdminLTE App -->
  <script src="<?php echo base_url(); ?>assets/plugins/dist/js/adminlte.min.js"></script>
  <!-- AdminLTE for demo purposes -->
  <script src="<?php echo base_url(); ?>assets/plugins/dist/js/demo.js"></script>
  <!-- Toastr -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/toastr/toastr.min.css">
  <script src="<?php echo base_url(); ?>assets/plugins/toastr/bootstrap.bundle.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/plugins/toastr/sweetalert2.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/plugins/toastr/toastr.min.js"></script>

<!-- Datepicker -->
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<!-- <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/datepicker/daterangepicker.css">
<script src="<?php echo base_url(); ?>assets/plugins/datepicker/daterangepicker.js"></script> -->

<link rel="stylesheet" type="text/css" href="<?php echo $this->config->item('base_url').'assets/'; ?>plugins/datatables/dataTables.bootstrap.css">
<script src="<?php echo $this->config->item('base_url').'assets/'; ?>plugins/datatables/dataTables.bootstrap.min.js"></script>
<script src="<?php echo $this->config->item('base_url').'assets/'; ?>plugins/datatables/jquery.dataTables.min.js"></script>

<link href="<?php echo $this->config->item('base_url').'assets/'; ?>plugins/bootstrap-switch/css/bootstrap4-toggle.min.css" rel="stylesheet">
<!-- <link rel="stylesheet" type="text/css" href="<?php echo $this->config->item('base_url').'assets/'; ?>plugins/bootstrap-switch/css/bootstrap4-toggle.min.css"> -->
<!-- <script src="<?php echo $this->config->item('base_url').'assets/'; ?>plugins/bootstrap-switch/js/bootstrap4-toggle.min.js"></script> -->
<script src="<?php echo $this->config->item('base_url').'assets/'; ?>plugins/bootstrap-switch/js/bootstrap4-toggle.min.js"></script>
<script src="<?php echo $this->config->item('base_url').'assets/'; ?>plugins/chartjs/Chart.min.js"></script>
	<script>
	$( function() {
    //Date range picker
    $('.datepicker').datepicker();
  } );

	$(function(){ $('#chkToggle1').bootstrapToggle() });
  </script>

	<script type="text/javascript">
	 $(function() {
    const Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 3000
		});
	})


	</script>

</head>
<body class="hold-transition sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
      </li>
     
    </ul>

    <!-- SEARCH FORM -->
    

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Messages Dropdown Menu -->
      
      
    </ul>
  </nav>
  <!-- /.navbar -->

