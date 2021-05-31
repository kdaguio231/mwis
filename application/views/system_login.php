<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>MWIS | Log in</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <style>
.alert {
  padding: 20px;
  background-color: #f44336;
  color: white;
  opacity: 1;
  transition: opacity 0.6s;
  /* margin-bottom: 15px; */
}

.alert.success {background-color: #4CAF50;}
.alert.info {background-color: #2196F3;}
.alert.warning {background-color: #ff9800;}

.closebtn {
  margin-left: 15px;
  color: white;
  font-weight: bold;
  float: right;
  font-size: 22px;
  line-height: 20px;
  cursor: pointer;
  transition: 0.3s;
}

.closebtn:hover {
  color: black;
}
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
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="../../index2.html"><b>Eirev</b></a><br/> Microfinance Web Information System
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Sign in to start your session</p>
	  <button class="btn btn-primary" id="progress_load" style="float:right; margin-top: 0px; margin-right: 25px; width: 130px" type="button" disabled>
			<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
			Loading...
		 </button>
		 <div id="progress" style="align: right; width: 500px">
		  
		  </div>
		  <div id="response" >
		  
		  </div>
      <form class="form-horizontal" method="post" id="form_login" role="form">
        <div class="input-group mb-3">
		<input type="text" class="form-control" name="username" id="username" placeholder="Username">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
		<input type="password" class="form-control" name="password" id="password" placeholder="Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <!-- <div class="col-12">
            <div class="icheck-primary">
              <input type="checkbox" id="remember">
              <label for="remember">
                Remember Me
              </label>
            </div>
          </div> -->
          <!-- /.col -->
          <div class="col-12">
		  
		  <button type="submit" name="btnSignIn" id="btnSignIn"  class="btn btn-info col-12" value="true">Login</button><br/><br/>
		  <a href="<?php echo base_url(); ?>" style="margin-left: 100px;" class="text-center">Forgot Password?</a><br/>
		  <div class="_8icz" style="border-bottom: 1px solid #dadde1; display: flex; margin: 20px 16px;"></div>
		  <button type="submit" onclick="signUp();" name="btnSignUp" id="btnSignUp" style="width: 130px; margin-left: 100px;" class="btn btn-success" value="true">Sign Up</button>
		  
          </div>
		  
          <!-- /.col -->
        </div>
      </form>

     
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="<?php echo base_url(); ?>assets/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?php echo base_url(); ?>assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url(); ?>assets/plugins/dist/js/adminlte.min.js"></script>

<script src="<?php echo base_url(); ?>assets/plugins/jquery-validation/jquery.validate.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>

</body>
</html>



 

<script type="text/javascript">
		
	$(document).ready(function() {
		
		var loginbtn = $('#btnSignIn');
			msgalert = $('#response');
		$('#progress_load').hide();
		
		$("#form_login").validate({
			rules: {
				username: {
					required: true,
					minlength: 5,
				},
				password: {
					required: true,
					minlength: 5,
				},
			},

			messages: {
				username: {
					required: "Please enter a email",
					minlength: "Your email must consist of at least 5 characters"
				},
				password: {
					required: "Please provide a password",
					minlength: "Your password must be at least 5 characters long"
				},
			},

			errorPlacement: function (error, element) {
				$(element).closest('.form-group').find('.error-message').html(error);
				// $(element).closest('.form-group').find('.form-control').attr('placeholder',error);
			},

			submitHandler: function() {
				$.ajax({
					url: '<?php echo base_url(); ?>site/validation',
                    method: 'POST',
                    data: $("#form_login").serialize(),
					dataType: 'json',
                    async: true,
					success: function(response)
					{
						loginbtn.hide();
						$('#progress_load').show();
						msgalert.hide();

						switch( response['login_status'] ) 
						{
							case 'incorrect':
							case 'invalid':
								msgalert.html(
									'<div class="col-xs-12">' +
		                                '<div class="alert alert-danger">' +
		                                    '<strong><i class="ti-face-sad"></i></strong> Incorrect username or password' +
		                                '</div>' +
		                            '</div>');
								chain_reaction(1,0,1);
								break;
							
							case 'success':
								msgalert.html(
									'<div class="alert success">' +
										'<span class="closebtn">&times;</span>' +  
										'<strong>Successfully</strong> logged in.' +
									'</div>');
								chain_reaction(0,0,1);
								
								setTimeout(function() {
									window.location.href = '<?php echo base_url(); ?>' + 'dashboard';
								}, 	1500);
								break;

							default:
								// financerLogin.resetProgressBar(true);
								break;
						}
					}
				});
			}
		});

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

	function signUp()
	{
		window.location.href = '<?php echo base_url(); ?>' + 'users/signup';
	}
	</script>
