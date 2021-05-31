<div class="content-wrapper">    

<!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Apply a loan</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Apply a loan</li>
            </ol>
          </div>
        </div>
	
				
      </div><!-- /.container-fluid -->
    </section>

		
				
<div class="col-md-6">
            <!-- general form elements disabled -->
            <div class="card card-warning">
              <div class="card-header">
                <h3 class="card-title">Apply a loan</h3> &nbsp;
				<?php if($buttonstat == "disable") { ?>
				<h3 class="" style="color:red">Sorry cannot apply a loan. Please contact our office for confirmation.</h3>
				<?php } ?>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
			  <form class="" id="form_apply_loan">
			  <input type="hidden" value="" name="application_id" id="application_id">
							<!-- Name -->
							<div class="row">
								<div class=" col-10">
										<label>Loan amount</label>
								</div>
								<div class="col-sm-7">
									<!-- text input -->
									<div class="form-group">
										<label></label>
										<input type="text" value="" id="amount_borrowed" name="amount_borrowed" style="text-align: right" class="form-control" placeholder="0.00">
										
									</div>
								</div>
								
								
							</div>

							<!-- Address -->
							<div class="row">
								<div class=" col-12">
										<label>Reason for loan request</label>
								</div>
								<div class="col-sm-7">
									<!-- text input -->
									<div class="form-group">
										<label></label>
										<input type="text" value="" id="reason_for_loan" name="reason_for_loan" class="form-control" placeholder="Reason for loan request">
									</div>
								</div>
							</div>

							<div class="row">
								<!-- birthdate -->
								<div class="col-sm-2">
									<!-- text input -->
									<div class="form-group">
									<?php if($buttonstat == "disable") { ?>
										<button type="button" class="btn btn-block btn-secondary disabled waves-effect waves-light" onclick="apply_loan()">Apply</button>
									<?php } else { ?>
										<button type="button" class="btn btn-block btn-success waves-effect waves-light" onclick="apply_loan()">Apply</button>
									<?php } ?>
									
									</div>
								</div>
							</div>

						</form>	
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

</div>

<div class="col-md-12">
            <!-- general form elements disabled -->
            <div class="card card-warning">
              <div class="card-header">
                <h3 class="card-title">Loans</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
			<div class="row">
            <div class="col-sm-12">
                <div class="card-box table-responsive">
                    <table id="datatable_loans" class="table table-striped table-hover dt-responsive nowrap">
                        <thead>
                            <tr>
                                <th width="5%">Amount</th>
                                <th width="10%">Date Borrowed</th>
                                <th width="10%">Application Status</th>
                                <th width="10%">Payment Status</th>
								<th width="15%">Loan Release Status</th>
								<th width="10%">Release Date</th>
								<th width="5%">Interest Rate</th>
								<th width="15%">Reason for loan</th>
								<th width="10%">Action</th>
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
			
			$('#datatable_loans').dataTable().fnClearTable();
			$('#datatable_loans').dataTable().fnDraw();
			$('#datatable_loans').dataTable().fnDestroy();
			$("#datatable_loans").dataTable(
			{
				"scrollY":        "200px",
				"scrollCollapse": true,
				"bLengthChange": false,
				"deferLoading": 0,
				"ajax": {
				"url":"<?php echo base_url(); ?>client/loan_list",
				"dataSrc": function (d) {
						return d
					}

				}  ,
				"order": [[ 1, "desc" ]],
				"columns": [
						{ data: 'amount_borrowed', className: "text-right", render: $.fn.dataTable.render.number(',', '.', 2, '') },
						{ data: 'date_borrowed' },
						{ data: 'application_status' },
						{ data: 'payment_status'},
						{ data: 'loan_release_status'},
						{ data: 'date_released'},
						{ data: 'interest_rate'},
						{ data: 'reason_for_loan'},
						{
							sortable: false,
							"render": function ( data, type, full, meta ) {
								var buttonID = "application_no_"+full.application_id;
								var statuslayout = (full.application_status === '0' && full.cancelled != 1 ? '<button id='+buttonID+' class="btn btn-success btn-xs" onclick="edit_application(this)" role="button">Edit</button><button id=cancel_application_'+full.application_id+' class="btn btn-success btn-xs" onclick="cancel_application(this)" role="button">Cancel Application</button>' : '<button id='+buttonID+' class="btn btn-secondary btn-xs" disabled role="button">Edit</button><button id='+buttonID+' style="height: 25px;" class="btn btn-secondary btn-xs" disabled role="button">Cancel Application</button>')
								return statuslayout;
							}
						}
					],
				"columnDefs" : [
						{ targets : [2],
							render : function (data, type, row) {
								return (row['application_status'] === '0' ? 'For Approval' : (row['application_status'] === '2' ? 'Rejected' : 'Approved'))
							}
						},
						{ targets : [3],
							render : function (data, type, row) {
								if(row['payment_status'] === '0'){
									return 'No Payment';
								}
								else if(row['payment_status'] === '1'){
									return 'On going loan';
								}
								else if(row['payment_status'] === '2'){
									return 'Fully Paid';
								}
								else{
									return 'Delinquent';
								}
								// return (row['application_type'] === '1' ? 'New Application' : 'Renewal')
							}
						},
						{ targets : [4],
							render : function (data, type, row) {
								if(row['loan_release_status'] === '0'){
									return 'For approval application';
								}
								else if(row['loan_release_status'] === '1'){
									return 'For release';
								}
								else if(row['loan_release_status'] === '2'){
									return 'Released';
								}
								else{
									return 'Fully Paid';
								}
							}
						},
						{ targets : [6],
							render : function (data, type, row) {
								return row['interest_rate']+"%";
							}
						}
				],
				
			});
		}
		load_table();
	});

	function apply_loan()
	{
		$formdata = $("#form_apply_loan");
		$.ajax({
				url: '<?php echo base_url(); ?>client/apply_loan',
				method: 'POST',
				dataType: 'json',
				async: true,
				data: $("#form_apply_loan").serialize(),
				error: function(response)
				{
				alert('Error! Please contact your administrator.');
				},
				success: function(response)
				{
					alert("Successfully updated!");
					location.reload();
				}
			});
	}
	  
	function edit_application(elem)
	{
		var id = $(elem).attr("id");
		var myString = id;
		var newString = myString.substr(15);
		$.ajax({
			url: '<?php echo base_url(); ?>client/edit_loan_application',
			method: 'POST',
			dataType: 'json',
			data: {id: newString},
			async: true,
			error: function(response)
			{
				alert('Error! Please contact your administrator.');
			},
			success: function(response)
			{
				$("#amount_borrowed").val(response[0]['amount_borrowed']);
				$("#reason_for_loan").val(response[0]['reason_for_loan']);
				$("#application_id").val(response[0]['application_id']);
			}
		});
	}

	function cancel_application(elem)
	{
		var id = $(elem).attr("id");
		var myString = id;
		var newString = myString.substr(19);
		$.ajax({
			url: '<?php echo base_url(); ?>client/cancel_loan_application',
			method: 'POST',
			dataType: 'json',
			data: {id: newString},
			async: true,
			error: function(response)
			{
				alert('Error! Please contact your administrator.');
			},
			success: function(response)
			{
				alert('Application has been successfully cancelled.');
				load_table();
			}
		});
	}

</script>
