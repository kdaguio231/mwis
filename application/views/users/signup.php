
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AdminLTE 3 | Registration Page</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <style>

</style>
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/ionicons/2.0.1/css/ionicons.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition register-page">
<div class="register-box" style="width:460px;">
  <div class="register-logo">
    <a href="../../index2.html"><b>Eirev</b></a><br/> Microfinance Web Information System
  </div>

  <div class="card">
    <div class="card-body register-card-body">
      <p class="login-box-msg">Register a new membership</p>

      <form method="post" id="form_signup" role="form">
        <div class="input-group mb-3">
          <input type="text" class="form-control" name="user_fname" placeholder="First name" required>
		  <input type="text" class="form-control" name="user_mname" placeholder="Middle name">
		  <input type="text" class="form-control" name="user_lname" placeholder="Last name" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
		<div class="input-group mb-3">
          <input type="text" class="form-control" name="position" placeholder="Postion" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-address-card"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="text" class="form-control" name="username" placeholder="Username" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" name="password" placeholder="Password" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" placeholder="Retype password" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-8">
            
          </div>
          <!-- /.col -->
          <div class="col-4">
            <button type="button" onclick="submit_register();" name="register" id="register" class="btn btn-primary btn-block btn-flat">Register</button>
          </div>
          <!-- /.col -->
        </div>
      </form>


      <a href="<?php echo base_url(); ?>" class="text-center">I already have a membership</a>
    </div>
    <!-- /.form-box -->
  </div><!-- /.card -->
</div>
<!-- /.register-box -->

<!-- jQuery -->
<script src="<?php echo base_url(); ?>assets/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?php echo base_url(); ?>assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url(); ?>assets/plugins/dist/js/adminlte.min.js"></script>
</body>
</html>

<script type="text/javascript">
		
	$(document).ready(function() {
		
		var register = $('#register');
			msgalert = $('#response');
		$('#progress_load').hide();
		
		

		function chain_reaction( state_1, state_2, state_3 )
		{
			setTimeout(function(){
				if( state_1 ) loginbtn.show(); else loginbtn.hide();
			},	1000);

			setTimeout(function(){
				if( state_2 ) progress.show(); else progress.hide();
			},	1000);

			setTimeout(function(){
				if( state_3 ) msgalert.show(); else msgalert.hide();
			},	1000);
		}
	});

	function submit_register()
	{
		$.ajax({
			url: '<?php echo base_url(); ?>users/validation',
			method: 'POST',
			data: $("#form_signup").serialize(),
			dataType: 'json',
			async: true,
			error: function(response)
			{
				alert('Error! Please contact your administrator.');
			},
			success: function(response)
			{
				alert('Saved');
				window.location.href = response['redirect'];
			}

			
		});
	}

	</script>
