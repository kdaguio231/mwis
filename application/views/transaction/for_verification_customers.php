<div class="content-wrapper">    

<!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Verify Accounts</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
			  <li class="breadcrumb-item"><a href="#">Transaction</a></li>
              <li class="breadcrumb-item active">Verify Accounts</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>


<div class="col-md-12">
            <!-- general form elements disabled -->
            <div class="card card-warning">
              <div class="card-header">
                <h3 class="card-title"><b>Verify Accounts</b></h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
							<div class="row">
            <div class="col-sm-12">
                <div class="card-box table-responsive">
                    <table id="datatable_verify_customers" class="table table-striped table-hover dt-responsive nowrap">
                        <thead>
                            <tr>
                                <th width="10%">Customer Name</th>
								<th width="20%">Address</th>
                                <th width="10%">Occupation</th>
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
			
			$('#datatable_verify_customers').dataTable().fnClearTable();
			$('#datatable_verify_customers').dataTable().fnDraw();
			$('#datatable_verify_customers').dataTable().fnDestroy();
			$("#datatable_verify_customers").dataTable(
			{
				"scrollY":        "200px",
				"scrollCollapse": true,
				"bLengthChange": false,
				"deferLoading": 0,
				"ajax": {
				"url":"<?php echo base_url(); ?>transaction/datatable_verify_customers_list",
				"dataSrc": function (d) {
						return d
					}

				}  ,
				"order": [[ 1, "asc" ]],
				"columns": [
						{ data: 'fullname' },
						{ data: 'address' },
						{ data: 'occupation' },
						{
							sortable: false,
							"render": function ( data, type, full, meta ) {
								var buttonID = "employee_no_"+full.customer_id;
								return '<a href="<?php echo base_url()?>transaction/loan_details/'+full.customer_id+'" id='+buttonID+' class="btn btn-success btn-xs" role="button">Details</a>';
							}
						}
					]
				
			});
		}
		load_table();
	});

	


</script>
