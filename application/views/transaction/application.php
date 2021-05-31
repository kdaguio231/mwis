<div class="content-wrapper">    

<!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Application</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
			  <li class="breadcrumb-item"><a href="#">Transaction</a></li>
              <li class="breadcrumb-item active">Application</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>


<div class="col-md-12">
            <!-- general form elements disabled -->
            <div class="card card-warning">
              <div class="card-header">
                <h3 class="card-title">Applications</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
			<div class="row">
            <div class="col-sm-12">
                <div class="card-box table-responsive">
                    <table id="datatable_application" class="table table-striped table-hover dt-responsive nowrap">
                        <thead>
                            <tr>
                                <th width="10%">Customer Name</th>
                                <th width="20%">Address</th>
                                <th width="10%">Occupation</th>
								<th width="10%">Amount</th>
                                <th width="10%">Application Date</th>
                                <th width="10%">Application Status</th>
								<th width="10%">Application Type</th>
								<th width="10%">Approve</th>
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
				"scrollY":        "200px",
				"scrollCollapse": true,
				"bLengthChange": false,
				"deferLoading": 0,
				"ajax": {
				"url":"<?php echo base_url(); ?>transaction/application_list",
				"dataSrc": function (d) {
						return d
					}

				}  ,
				"order": [[ 1, "asc" ]],
				"columns": [
						{ data: 'fullname' },
						{ data: 'address' },
						{ data: 'occupation' },
						{ data: 'amount_borrowed'},
						{ data: 'date_borrowed'},
						{ data: 'application_status'},
						{ data: 'application_type'},
						{
							sortable: false,
							"render": function ( data, type, full, meta ) {
								var buttonID = "employee_no_"+full.application_id;
								var statuslayout = (full.application_status === '1' ? '<button id='+buttonID+' disabled class="btn btn-success btn-xs" onclick="approve_application(this)" role="button">Approve Application</button>' : '<button id='+buttonID+' class="btn btn-success btn-xs" onclick="approve_application(this)" role="button">Approve Application</button>')
								statuslayout += '<a href="<?php echo base_url()?>transaction/loan_details/'+full.application_id+'" id='+buttonID+' class="btn btn-success btn-xs" role="button">Details</a>';
								return statuslayout;
							}
						}
					],
				"columnDefs" : [
						{ targets : [5],
							render : function (data, type, row) {
								return (row['application_status'] === '0' ? 'For Approval' : (row['application_status'] === '2' ? 'Rejected' : 'Approved'))
							}
						},
						{ targets : [6],
							render : function (data, type, row) {
								return (row['application_type'] === '1' ? 'New Application' : 'Renewal')
							}
						}
				],
				
			});
		}
		load_table();
	});

	function approve_application(elem)
	{
	var id = $(elem).attr("id");
	var myString = id;
	var newString = myString.substr(12);
	// alert(id);

	$.ajax({
		url: '<?php echo base_url(); ?>transaction/approve_application',
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
			$('#datatable_application').DataTable().ajax.reload()
		}
	});
	}


	


</script>
