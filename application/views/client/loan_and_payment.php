<div class="content-wrapper">    

<!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Loan And Payment History</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Loan And Payment History</li>
            </ol>
          </div>
        </div>
	
				
      </div><!-- /.container-fluid -->
    </section>

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
										<th width="10%">Amount</th>
										<th width="10%">Date Borrowed</th>
										<th width="10%">Application Status</th>
										<th width="10%">Payment Status</th>
										<th width="10%">Loan Release Status</th>
										<th width="10%">Release Date</th>
										<th width="10%">Interest Rate</th>
										<th width="15%">Reason for loan</th>
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

	<div class="col-md-12">
            <!-- general form elements disabled -->
		<div class="card card-warning">
              <div class="card-header">
                <h3 class="card-title">Payment History</h3>
              </div>
              <!-- /.card-header -->
			<div class="card-body">
				<div class="row">
					<div class="col-sm-12">
						<div class="card-box table-responsive">
							<table id="datatable_payment_history" class="table table-striped table-hover dt-responsive nowrap">
								<thead>
									<tr>
										<th width="10%">Paid Date</th>
										<th width="10%">Amount Paid</th>
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
						{ data: 'amount_borrowed', className: "text-right" , render: $.fn.dataTable.render.number(',', '.', 2, '')},
						{ data: 'date_borrowed' },
						{ data: 'application_status' },
						{ data: 'payment_status'},
						{ data: 'loan_release_status'},
						{ data: 'date_released'},
						{ data: 'interest_rate', className: "text-right"},
						{ data: 'reason_for_loan'},
					
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


		// payment history
		load_table_history = function(){
			
			$('#datatable_payment_history').dataTable().fnClearTable();
			$('#datatable_payment_history').dataTable().fnDraw();
			$('#datatable_payment_history').dataTable().fnDestroy();
			$("#datatable_payment_history").dataTable(
			{
				"scrollY":        "200px",
				"scrollCollapse": true,
				"bLengthChange": false,
				"deferLoading": 0,
				"ajax": {
				"url":"<?php echo base_url(); ?>client/payment_history",
				"dataSrc": function (d) {
						return d
					}

				}  ,
				"order": [[ 1, "desc" ]],
				"columns": [
						{ data: 'paid_date', className: "text-right"},
						{ data: 'amount_paid', className: "text-right" , render: $.fn.dataTable.render.number(',', '.', 2, '') }
					]
			});
		}
		load_table_history();
	});

</script>
