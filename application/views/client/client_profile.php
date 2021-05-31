<div class="content-wrapper">    

<!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Profile</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Profile</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
		<?php foreach($details as $row): ?>
		<div class="col-md-12">
            <!-- general form elements disabled -->
            <div class="card card-warning">
              <div class="card-header">
                <h3 class="card-title">Loan Details</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
			  <form class="" id="form_client_profile" enctype="multipart/form-data">
							<!-- Name -->
							<div class="row">
								<div class=" col-10">
										<label>Name</label>
								</div>
								<div class="col-sm-4">
									<!-- text input -->
									<div class="form-group">
										<label></label>
										<input type="text" value="<?php echo $row["customer_lname"];?>" name="customer_lname" class="form-control" placeholder="Last Name">
									
									</div>
								</div>
								<div class="col-sm-4">
									<div class="form-group">
										<label> </label>
										<input type="text" value="<?php echo $row["customer_fname"];?>" name="customer_fname" class="form-control" placeholder="First Name">
									</div>
								</div>
								<div class="col-sm-4">
									<div class="form-group">
										<label> </label>
										<input type="text" value="<?php echo $row["customer_mname"];?>" name="customer_mname" class="form-control" placeholder="Middle Name">
									</div>
								</div>
							</div>

							<!-- Address -->
							<div class="row">
								<div class=" col-12">
										<label>Address</label>
								</div>
								<div class="col-sm-3">
									<!-- text input -->
									<div class="form-group">
										<label></label>
										<input type="text" value="<?php echo $row["address_house_number"];?>" name="address_house_number" class="form-control" placeholder="House Number & Street">
									</div>
								</div>
								<div class="col-sm-3">
									<div class="form-group">
										<label> </label>
										<input type="text" value="Quezon City" readonly name="address_city_town" class="form-control" placeholder="City/Town">
									</div>
								</div>
								<div class="col-sm-3">
									<div class="form-group">
										<label> </label>
										<select class="form-control select2 " id="district" name="district" onchange="load_brgy(this.value)">
											<option value=''>-- Please Select --</option>
											<?php 
											if (count($district) > 0){
												foreach ($district as $key ) {?>
													 <option value='<?php echo $key['id']; ?>' <?php if($row['address_province'] == $key['id']) { echo 'selected';} ?> >District <?php echo $key['district_number']; ?></option>
											<?php	}
											}
											?>
										</select>

									</div>
								</div>
								<div class="col-sm-3">
									<div class="form-group">
										<label> </label>
										<select class="form-control select2 " id="brgy" style="width: 100%;" name="brgy">
											<option value=''>-- Please Select --</option>
										</select>
									</div>
								</div>
								
								<!-- <div class="col-sm-3">
									<div class="form-group">
										<label> </label>
										<input type="text" value="<?php echo $row["address_province"];?>" name="address_province" class="form-control" placeholder="Province">
									</div>
								</div> -->
							</div>

							<!-- Occupation -->
							<div class="row">
								<div class=" col-5">
										<label>Occupation</label>
								</div>
									<!-- birthdate -->
								<div class=" col-5">
										<label>Birthdate</label>
								</div>
								
							</div>

							<div class="row">
								<!-- occupation -->
							<div class="col-sm-5">
									<!-- text input -->
									<div class="form-group">
										<label></label>
										<select class="form-control select2 " id="occupation" name="occupation">
											<option value=''>-- Please Select --</option>
											<?php 
											if (count($occupation) > 0){
												$x = 0;
												foreach ($occupation as $key ) {
													$parent = "";
													$prev = "";
													if($key['parent_id'] == 0)
													{
														if($x > 0)
														{
															echo '</optgroup>';
														}
														$prev = $key['parent_id'];
														$parent = $key['id'];
														echo '<optgroup label="'.$key['description'].'">';
														$x++;
													}
													else{
														echo ' <option value="'.$key['id'].'">'.$key['description'].'</option>';
													}	
												}
											}
											?>
										</select>
										
									</div>
								</div>
									<!-- birthdate -->
								<div class="col-sm-5">
									<!-- text input -->
									<div class="form-group">
										<label></label>
										<input type="text" value="<?php echo $row["birthdate"];?>" name="birthdate" class="form-control" placeholder="Birthdate">
									</div>
								</div>
							</div>

							<div class="row">
								<!-- occupation -->
							<div class="col-sm-5">
									<!-- text input -->
									
									<div class="form-group">
										<label>Upload Valid ID</label>
										
										<input type="file" <?php if($row["verified_id"]){ echo 'disabled'; } ?> accept="image/*" id="validid_image" name="validid_image"  />
                						<?php if($row["verified_id"] && $row["verified_id_by"] == ""){ echo '<p style="color: red;">Under Verification</p>'; } else if($row["verified_id"] && $row["verified_id_by"]){ echo 'Verified<img alt="Verified Badge icon" src="http://localhost:8080/microfinance/assets/images/verified-badge.png" style="height:28px;width:28px;">';}?><!-- <input type="submit" value="Upload Image" /> -->
									</div>
									
								</div>
							</div>
							<div class="row">
								<!-- birthdate -->
								<div class="col-sm-2">
									<!-- text input -->
									<div class="form-group">
									<button type="submit" class="btn btn-block btn-success waves-effect waves-light" >Save</button>
									</div>
								</div>
							</div>
						</form>	
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

</div>
<?php endforeach; ?>
<div id="err"></div>
<script type="text/javascript">
	$(document).ready(function (e) {
 		$("#form_client_profile").on('submit',(function(e) {
		e.preventDefault();
			$.ajax({
				url: "<?php echo base_url(); ?>client/upload_valid_id",
				type: "POST",
				data:  new FormData(this),
				contentType: false,
				cache: false,
				processData:false,
				beforeSend : function()
				{
					//$("#preview").fadeOut();
					$("#err").fadeOut();
				},
				success: function(data)
				{
					
					if(data =='Success')
					{
						// view uploaded file.
						alert('Successfully submitted.  Your account is now under verification.');
						location.reload(); 
					}
					else if(data =='Success saved')
					{
						alert('Successfully saved.');
						location.reload(); 
					}
					else
					{
						// invalid file format.
						$("#err").html("Invalid File !").fadeIn();
					}
				},
				error: function(e) 
				{
					$("#err").html(e).fadeIn();
				}          
			});
 		}));
	});

	

</script>
