<div class="content-wrapper">    

<!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Loans Overdue</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Transaction</a></li>
              <li class="breadcrumb-item"><a href="#">Loan Management</a></li>
              <li class="breadcrumb-item active">Loans Overdue</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>


<div class="col-md-12">
            <!-- general form elements disabled -->
            <div class="card card-warning">
              <div class="card-header">
                <h3 class="card-title"><b>Loans Overdue</b></h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
							<div class="row">
            <div class="col-sm-12">
                <div class="card-box table-responsive">
                    <table id="datatable_loans_overdue" class="table table-striped table-hover dt-responsive nowrap">
                        <thead>
                            <tr>
                                <th width="10%">Customer Name</th>
								<th width="10%">End date</th>
								<th width="10%">Loan Amount</th>
                                <th width="10%">Total Loan Amount</th>
                                <th width="10%">Amount Paid</th>
								<th width="10%">Balance</th>
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
			
			$('#datatable_loans_overdue').dataTable().fnClearTable();
			$('#datatable_loans_overdue').dataTable().fnDraw();
			$('#datatable_loans_overdue').dataTable().fnDestroy();
			$("#datatable_loans_overdue").dataTable(
			{
				"scrollY":        "200px",
				"scrollCollapse": true,
				"bLengthChange": false,
				"deferLoading": 0,
				"ajax": {
				"url":"<?php echo base_url(); ?>transaction/load_overdue_list",
				"dataSrc": function (d) {
						return d
					}

				}  ,
				"order": [[ 1, "asc" ]],
				"columns": [
						{ data: 'fullname' },
						{ data: 'end_date' },
						{ data: 'amount_borrowed' },
						{ data: 'total_loanamount' },
						{ data: 'amount_paid' },
						{ data: 'balance'},
						{
							sortable: false,
							"render": function ( data, type, full, meta ) {
								var buttonID = "employee_no_"+full.application_id;
								return '<a href="<?php echo base_url()?>transaction/loan_details/'+full.application_id+'" id='+buttonID+' class="btn btn-success btn-xs" role="button">Details</a>';
							}
						}
					]
				
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
