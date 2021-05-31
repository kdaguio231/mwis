
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
          <input type="text" class="form-control" id="user_fname" name="user_fname" placeholder="First name" required>
		  <input type="text" class="form-control" id="user_mname" name="user_mname" placeholder="Middle name">
		  <input type="text" class="form-control" id="user_lname" name="user_lname" placeholder="Last name" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-address-book"></span>
            </div>
          </div>
        </div>
		<div class="input-group mb-3">
		<input type="text" class="form-control datepicker birthdate" name="birthdate" id="birthdate" placeholder="Birth Date">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-calendar"></span>
            </div>
          </div>
        </div>
		
				<div class="input-group mb-3">
          <input type="email" class="form-control" id="email_address" name="email_address" placeholder="Email" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>

				<div class="input-group mb-3">
					<select class="form-control select2 " id="district" name="district" onchange="load_brgy(this.value)">
						<option value=''>-- Please Select --</option>
						<?php 
						if (count($district) > 0){
							foreach ($district as $key ) {?>
									<option value='<?php echo $key['id']; ?>'>District <?php echo $key['district_number']; ?></option>
						<?php	}
						}
						?>
					</select>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-house-user"></span>
            </div>
          </div>
        </div>

				<div class="input-group mb-3">
					<select class="form-control select2 " id="brgy"  name="brgy">
						<option value=''>-- Please Select --</option>
					</select>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-house-user"></span>
            </div>
          </div>
        </div>

        <div class="input-group mb-3">
          <input type="text" class="form-control" id="username" name="username" placeholder="Username" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" id="retypepassword" name="retypepassword" placeholder="Retype password" required value="">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
					
        </div>
				
				<div class="row">
          <div class="col-12">
					<div id="retypeerror"></div>
          </div>
          <!-- /.col -->
          
          <!-- /.col -->
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


      <a href="<?php echo base_url(); ?>client/login" class="text-center">I already have a membership</a>
			<div id="err"></div>
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
<script src="<?php echo base_url(); ?>assets/plugins/jquery-validation/jquery.validate.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
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
		if ($("#retypeerror").html().length) {
				$('.diverror').remove();
		}   
		if(!$('#user_fname').val()){
			$('#user_fname').attr('placeholder',
                'Required');
			$('#user_fname').addClass('is-invalid');
			$('#retypeerror').append(
				'<div class="col-xs-12 diverror">' +
													'<div class="alert alert-danger">' +
															"<strong><i class='ti-face-sad'></i></strong> First name is required." +
													'</div>' +
											'</div>');
		}
		
		 if(!$('#user_lname').val()){
			$('#user_lname').attr('placeholder',
                'Required');
			$('#user_lname').addClass('is-invalid');
			$('#retypeerror').append(
				'<div class="col-xs-12 diverror">' +
													'<div class="alert alert-danger">' +
															"<strong><i class='ti-face-sad'></i></strong> Last name is required." +
													'</div>' +
											'</div>');
		}
		 if(!$('#birthdate').val()){
			$('#birthdate').attr('placeholder',
                'Required');
			$('#birthdate').addClass('is-invalid');
			$('#retypeerror').append(
				'<div class="col-xs-12 diverror">' +
													'<div class="alert alert-danger">' +
															"<strong><i class='ti-face-sad'></i></strong> Birthdate is required." +
													'</div>' +
											'</div>');
		}
		 if(!$('#email_address').val()){
			$('#email_address').attr('placeholder',
                'Required');
			$('#email_address').addClass('is-invalid');
			$('#retypeerror').append(
				'<div class="col-xs-12 diverror">' +
													'<div class="alert alert-danger">' +
															"<strong><i class='ti-face-sad'></i></strong> Email address is required." +
													'</div>' +
											'</div>');
		}
		 if($('#district').val() == ""){
			$('#district').attr('placeholder',
                'Required');
			$('#district').addClass('is-invalid');
			$('#retypeerror').append(
				'<div class="col-xs-12 diverror">' +
													'<div class="alert alert-danger">' +
															"<strong><i class='ti-face-sad'></i></strong> Please select the district you are residing." +
													'</div>' +
											'</div>');
		}
		if($('#brgy').val() == ""){
			$('#brgy').attr('placeholder',
                'Required');
			$('#brgy').addClass('is-invalid');
			$('#retypeerror').append(
				'<div class="col-xs-12 diverror">' +
													'<div class="alert alert-danger">' +
															"<strong><i class='ti-face-sad'></i></strong> Please select a barangay." +
													'</div>' +
											'</div>');
		}
		if(!$('#username').val()){
			$('#username').attr('placeholder',
                'Required');
			$('#username').addClass('is-invalid');
			$('#retypeerror').append(
				'<div class="col-xs-12 diverror">' +
													'<div class="alert alert-danger">' +
															"<strong><i class='ti-face-sad'></i></strong> Username is required." +
													'</div>' +
											'</div>');
		}
		if(!$('#password').val()){
			$('#password').attr('placeholder',
                'Required');
			$('#password').addClass('is-invalid');
			$('#retypeerror').append(
				'<div class="col-xs-12 diverror">' +
													'<div class="alert alert-danger">' +
															"<strong><i class='ti-face-sad'></i></strong> Password is required." +
													'</div>' +
											'</div>');
		}
		if($('#password').val() != $('#retypepassword').val() || $('#retypepassword').val() ==""){
			$('#retypepassword').attr('placeholder',
                'Required');
			$('#password').addClass('is-invalid');
			$('#retypeerror').append(
				'<div class="col-xs-12 diverror">' +
													'<div class="alert alert-danger">' +
															"<strong><i class='ti-face-sad'></i></strong> Password doesn't match." +
													'</div>' +
											'</div>');
		}
		// else{
		// 	$('#user_fname').attr('placeholder',
    //             '');
		// 						$('#user_fname').removeClass('is-invalid');
		// }
		$.ajax({
					url: '<?php echo base_url(); ?>client/register',
					method: 'POST',
					data: $("#form_signup").serialize(),
					dataType: 'json',
					async: true,
					success: function(response)
					{
						alert('Verification sent to your Email');
						window.location.replace('<?php echo base_url(); ?>' + 'client/login');
						
					},
					error: function(e) 
						{
							$("#err").html(e).fadeIn();
						}  
				});

		// $("#form_signup").validate({
		// 	rules: {
		// 		user_fname: {
		// 			required: true
		// 		},
		// 		user_lname: {
		// 			required: true
		// 		},
		// 		birthdate: {
		// 			required: true
		// 		},
		// 		district: {
		// 			required: true
		// 		},
		// 		brgy: {
		// 			required: true
		// 		},
		// 		username: {
		// 			required: true
		// 		},
		// 		password: {
		// 			required: true,
		// 			minlength: 5,
		// 		},
		// 	},

		// 	messages: {
		// 		user_fname: {
		// 			required: "Please enter your first name."
		// 		},
		// 		user_lname: {
		// 			required: "Please enter your last name."
		// 		},
		// 		birthdate: {
		// 			required: "Please enter your birthdate."
		// 		},
		// 		district: {
		// 			required: "Please select the district you are residing."
		// 		},
		// 		brgy: {
		// 			required: "Please select the barangay you are living in."
		// 		},
		// 		username: {
		// 			required: "Please enter a username."
		// 		},
		// 		password: {
		// 			required: "Please provide a password.",
		// 			minlength: "Your password must be at least 5 characters long."
		// 		},
		// 	},

		// 	errorPlacement: function (error, element) {
		// 		$(element).closest('.form-group').find('.error-message').html(error);
		// 		// $(element).closest('.form-group').find('.form-control').attr('placeholder',error);
		// 	},

		// 	submitHandler: function() {
				
		// 	}
		// });

	}

	function load_brgy(id)
	{
		$.ajax({
			url: '<?php echo $this->config->item('base_url').'client/load_brgy'; ?> ',
			method: 'POST',
			dataType: 'json',
			async: true,
			data: {id: id},
			error: function(response)
			{
			$("#fund_or").html();
			},
			success: function(response)
			{
					$('#brgy').html('<option ></option>');
						$.each(response, function(index, value){
							$('#brgy')
								.append($("<option></option>")
								.attr("value",response[index]['id'])
								.text(response[index]['barangay'])); 
						});
			}
		});
	}
	</script>
