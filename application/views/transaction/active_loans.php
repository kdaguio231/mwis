<div class="content-wrapper">    

<!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Active Loans</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
			  <li class="breadcrumb-item"><a href="#">Transaction</a></li>
              <li class="breadcrumb-item"><a href="#">Loan Management</a></li>
              <li class="breadcrumb-item active">Active Loans</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>


<div class="col-md-12">
            <!-- general form elements disabled -->
            <div class="card card-warning">
              <div class="card-header">
                <h3 class="card-title"><b>Active Loans</b></h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
							<div class="row">
            <div class="col-sm-12">
                <div class="card-box table-responsive">
                    <table id="datatable_active_loans" class="table table-striped table-hover dt-responsive nowrap">
                        <thead>
                            <tr>
                                <th width="10%">Customer Name</th>
								<th width="10%">Loan Amount</th>
                                <th width="10%">Application Type</th>
                                <th width="10%">Loan Release Status</th>
								<th width="10%">Payment Status</th>
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
			
			$('#datatable_active_loans').dataTable().fnClearTable();
			$('#datatable_active_loans').dataTable().fnDraw();
			$('#datatable_active_loans').dataTable().fnDestroy();
			$("#datatable_active_loans").dataTable(
			{
				"scrollY":        "200px",
				"scrollCollapse": true,
				"bLengthChange": false,
				"deferLoading": 0,
				"ajax": {
				"url":"<?php echo base_url(); ?>transaction/load_active_loan_list",
				"dataSrc": function (d) {
						return d
					}

				}  ,
				"order": [[ 1, "asc" ]],
				"columns": [
						{ data: 'fullname' },
						{ data: 'amount_borrowed' },
						{ data: 'application_type' },
						{ data: 'loan_release_status'},
						{ data: 'payment_status'},
						{
							sortable: false,
							"render": function ( data, type, full, meta ) {
								var buttonID = "employee_no_"+full.application_id;
								return '<a href="<?php echo base_url()?>transaction/loan_details/'+full.application_id+'" id='+buttonID+' class="btn btn-success btn-xs" role="button">Details</a>';
							}
						}
					],
				"columnDefs" : [
						{ targets : [3],
							render : function (data, type, row) {
								return (row['loan_release_status'] === '1' ? 'For Release' : 'Released')
							}
						},
						{ targets : [2],
							render : function (data, type, row) {
								return (row['application_type'] === '1' ? 'New Application' : 'Renewal')
							}
						},
						{ targets : [4],
							render : function (data, type, row) {
								return (row['payment_status'] > 0 ? (row['payment_status'] === '1' ? 'On going' : (row['payment_status'] === '2' ? 'Fully Paid' : 'Delinquent')) : 'No Payment Yet')
							}
						}
				],
				
			});
		}
		load_table();

	});

	function loan_release(elem)
	{
	var id = $(elem).attr("id");
	var myString = id;
	var newString = myString.substr(12);
	// alert(id);

	$.ajax({
			url: '<?php echo base_url(); ?>transaction/loan_release',
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
				alert(response);
				$('#datatable_loans').DataTable().ajax.reload()
			}
		});
	}

	function loan_details(elem)
	{
	var id = $(elem).attr("id");
	var myString = id;
	var newString = myString.substr(12);
	// alert(id);

	$.ajax({
			url: '<?php echo base_url(); ?>transaction/loan_release',
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
				alert(response);
				$('#datatable_loans').DataTable().ajax.reload()
			}
		});
	}


</script>
