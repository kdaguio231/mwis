<div class="content-wrapper">    

<!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>User List</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
			  <li class="breadcrumb-item"><a href="#">Maintenance</a></li>
              <li class="breadcrumb-item active">User List</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>


<div class="col-md-12">
            <!-- general form elements disabled -->
            <div class="card card-warning">
              <div class="card-header">
                <h3 class="card-title">Users</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
							<div class="row">
            <div class="col-sm-12">
                <div class="card-box table-responsive">
                    <table id="datatable_users" class="table table-striped table-hover dt-responsive nowrap">
                        <thead>
                            <tr>
                                <th width="15%">Employee No.</th>
                                <th width="25%">Fullname</th>
                                <th width="20%">Position</th>
                                <th width="10%">Is active</th>
                                <th width="15%">Action</th>
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
			
			$('#datatable_users').dataTable().fnClearTable();
			$('#datatable_users').dataTable().fnDraw();
			$('#datatable_users').dataTable().fnDestroy();
			$("#datatable_users").dataTable(
			{
				"scrollY":        "200px",
				"scrollCollapse": true,
				"bLengthChange": false,
				"deferLoading": 0,
				"ajax": {
				"url":"<?php echo base_url(); ?>maintenance/userlist",
				"dataSrc": function (d) {
						return d
					}

				}  ,
				"order": [[ 1, "asc" ]],
				"columns": [
						{ data: 'employee_no' },
						{ data: 'fullname' },
						{ data: 'position' },
						{ data: 'active'},
						{
							sortable: false,
							"render": function ( data, type, full, meta ) {
								var buttonID = "employee_no_"+full.employee_no;
								return '<a id='+buttonID+' class="btn btn-success btn-xs" onclick="select_student_details(this)" role="button">Select</a>';
							}
						}
					],
				"columnDefs" : [
						{ targets : [3],
						render : function (data, type, row) {
							return data == '1' ? 'Active' : 'Inactive'
						}
						}
				],
				"sDom": "lrtip",
			});
		}
		load_table();
	});

</script>
