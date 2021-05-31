<div class="content-wrapper">    

<!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Loan Details</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Loan Details</li>
            </ol>
          </div>
        </div>
				<?php foreach($details as $row): ?>
		<div class="row">
          <div class="col-sm-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3><?php echo number_format($row["amount_borrowed"], 2);?></h3>

                <p>Loan Amount</p>
              </div>
              <div class="icon">
                <i class="far fa-money-bill-alt"></i>
              </div>
              <a href="#" class="small-box-footer"></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3>53<sup style="font-size: 20px">%</sup></h3>

                <p>Remittance</p>
              </div>
              <div class="icon">
                <i class="far fa-credit-card"></i>
              </div>
              <a href="#" class="small-box-footer"> </a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3>44</h3>

                <p>Balance</p>
              </div>
              <div class="icon">
                <i class="fas fa-tags"></i>
              </div>
              <a href="#" class="small-box-footer"> </a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3>65</h3>

                <p>Delinquency</p>
              </div>
              <div class="icon">
                <i class="fas fa-coins"></i>
              </div>
              <a href="#" class="small-box-footer"> </a>
            </div>
          </div>
          <!-- ./col -->
        </div>
      </div><!-- /.container-fluid -->
    </section>

		
				
<div class="col-md-12">
            <!-- general form elements disabled -->
            <div class="card card-warning">
              <div class="card-header">
                <h3 class="card-title">Loan Details</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
			  <form class="" id="form_loan_account_details">
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
										<input type="hidden" value="<?php echo $row["application_id"];?>" name="application_id" id="application_id">
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
										<input type="text" value="<?php echo $row["address_city_town"];?>" name="address_city_town" class="form-control" placeholder="City/Town">
									</div>
								</div>
								<div class="col-sm-3">
									<div class="form-group">
										<label> </label>
										<input type="text" value="<?php echo $row["barangay"];?>" name="address_barangay" class="form-control" placeholder="Barangay">
									</div>
								</div>
								
								<div class="col-sm-3">
									<div class="form-group">
										<label> </label>
										<input type="text" value="District <?php echo $row["district"];?>" name="address_province" class="form-control" placeholder="Province">
									</div>
								</div>
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
										<input type="text" value="<?php echo $row["occupation"];?>" name="occupation" class="form-control" placeholder="Occupation">
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
										<label>Valid ID</label>
										<a href="<?php echo base_url('upload/'. $row['verified_id']);?>" >View image</a>
										<img src="<?php echo base_url('upload/'. $row['verified_id']); ?>" height=200 width=300 />
                						
									</div>
									
								</div>
							</div>

							<div class="row">
								<!-- birthdate -->
								<div class="col-sm-2">
									<!-- text input -->
									<div class="form-group">
									<button type="button" class="btn btn-block btn-success waves-effect waves-light" onclick="update_account_details()">Save</button>
									<button type="button" class="btn btn-block btn-primary waves-effect waves-light" onclick="verify_account()">Verify Now</button>
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


<div class="col-md-12">
            <!-- general form elements disabled -->
            <div class="card card-warning">
              <div class="card-header">
                <h3 class="card-title">Loan Details</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
							<div class="row">
								<div class="col-sm-12">
										<div class="card-box table-responsive">
												<table id="datatable_application" class="table table-striped table-hover dt-responsive nowrap">
														<thead>
																<tr>
																		<th width="10%">Due Date</th>
																		<th width="20%">Amount Paid</th>
																		<th width="10%">Date Remitted</th>
																		
																</tr>
														</thead>
														<tbody>
																
														</tbody>
												</table>
										</div>
								</div>
						</div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

</div>



<script type="text/javascript">

	$(document).ready(function()
	{
		load_table = function(){
			
			$('#datatable_application').dataTable().fnClearTable();
			$('#datatable_application').dataTable().fnDraw();
			$('#datatable_application').dataTable().fnDestroy();
			$("#datatable_application").dataTable(
			{
				"scrollY":        "400px",
				"scrollCollapse": true,
				"paging": false,
				"bLengthChange": false,
				"deferLoading": 0,
				"ajax": {
				"url":"<?php echo base_url(); ?>transaction/payment_record?application_id="+$('#application_id').val(),
				"dataSrc": function (d) {
						return d
					}

				}  ,
				"order": [[ 1, "asc" ]],
				"columns": [
						{ data: 'due_date' },
						{ data: 'amount_paid' },
						{ data: 'paid_date' }
					],
				"columnDefs" : [
						{ targets : [1],
							render : function (data, type, row) {
								return ((row['amount_paid']))
							}
						},
				],
				"order": [[ 0, "asc" ]]
			});
		}
		load_table();
	});


	function update_account_details()
	{
		$formdata = $("#form_loan_account_details");
		$.ajax({
				url: '<?php echo base_url(); ?>transaction/update_loan_account',
				method: 'POST',
				dataType: 'json',
				async: true,
				data: $("#form_loan_account_details").serialize(),
				error: function(response)
				{
				alert('Error! Please contact your administrator.');
				},
				success: function(response)
				{
					alert("Successfully updated!");
				}
			});
	}
	  
	function verify_account()
	{
		var application_id = $("#application_id").val();
		$.ajax({
			url: '<?php echo base_url(); ?>transaction/verify_account',
			method: 'POST',
			dataType: 'json',
			async: true,
			data: {id: application_id},
			error: function(response)
			{
			alert('Error! Please contact your administrator.');
			},
			success: function(response)
			{
				alert("Successfully verified!");
			}
		});
	}

</script>
