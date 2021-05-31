<style>
.switch {
  position: relative;
  display: inline-block;
  width: 60px;
  height: 34px;
}

.switch input { 
  opacity: 0;
  width: 0;
  height: 0;
}

.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 26px;
  width: 26px;
  left: 4px;
  bottom: 4px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

input:checked + .slider {
  background-color: #2196F3;
}

input:focus + .slider {
  box-shadow: 0 0 1px #2196F3;
}

input:checked + .slider:before {
  -webkit-transform: translateX(26px);
  -ms-transform: translateX(26px);
  transform: translateX(26px);
}

/* Rounded sliders */
.slider.round {
  border-radius: 34px;
}

.slider.round:before {
  border-radius: 50%;
}
</style>

<div class="content-wrapper">    

<!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Interest Rate List</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
			  <li class="breadcrumb-item"><a href="#">Maintenance</a></li>
              <li class="breadcrumb-item active">Interest Rate List</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

	<div class="col-md-12">
            <!-- general form elements disabled -->
            <div class="card card-warning">
              <div class="card-header">
                <h3 class="card-title">Interest Details</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
			  <form class="" id="form_interest_rates_details">
							<!-- Name -->
							<div class="row">
								
								<div class="col-sm-4">
									<!-- text input -->
									<div class="form-group">
										<label></label>
										<input type="text" value="" name="interest_rate" id="interest_rate" class="form-control" placeholder="Interest Rate">
										<input type="hidden" value="" name="interest_id" id="interest_id">
									</div>
								</div>
								<div class="col-sm-4">
									<div class="form-group">
										<label> </label>
										<input type="text" value="" name="interest_description" id="interest_description" class="form-control" placeholder="Description">
									</div>
								</div>
								<!-- <div class="col-sm-2">
									<div class="form-group">
									<label> Active </label>
									<label class="switch" style="margin-top: 25px;"><input type="checkbox" ><span class="slider round"></span></label>
									</div>
								</div> -->
								
							
								<div class="col-sm-2">
									<!-- text input -->
									<div class="form-group">
									<label> </label>
									<button type="button" class="btn btn-block btn-success waves-effect waves-light" onclick="update_interestrates()">Save</button>
									</div>
								</div>
							</div>
							<div class="row">
								<!-- birthdate -->
								
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
                <h3 class="card-title">Interest Rates</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
							<div class="row">
            <div class="col-sm-12">
                <div class="card-box table-responsive">
                    <table id="datatable_interest_rates" class="table table-striped table-hover dt-responsive nowrap">
                        <thead>
                            <tr>
                                <th width="15%">Interest Rates</th>
                                <th width="25%">Description</th>
								<th width="25%">Date Created</th>
								<th width="25%">Active</th>
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

		$("input[data-bootstrap-switch]").each(function(){
			$(this).bootstrapSwitch('state', $(this).prop('checked'));
		});

		load_table = function(){
			
			$('#datatable_interest_rates').dataTable().fnClearTable();
			$('#datatable_interest_rates').dataTable().fnDraw();
			$('#datatable_interest_rates').dataTable().fnDestroy();
			$("#datatable_interest_rates").dataTable(
			{
				"scrollY":        "200px",
				"scrollCollapse": true,
				"bLengthChange": false,
				"order": [[ 2, "desc" ]],
				"deferLoading": 0,
				"ajax": {
				"url":"<?php echo base_url(); ?>maintenance/interestratelist",
				"dataSrc": function (d) {
						return d
					}

				}  ,
				"order": [[ 1, "asc" ]],
				"columns": [
						{ data: 'interest_rate' },
						{ data: 'interest_description' },
						{ data: 'created_date' },
						{ 
							data: 'active'
							// sortable: false,
							// "render": function ( data, type, full, meta ) {
							// 	var checkID = "interest_id_"+full.interest_id;
							// 	return '<label class="switch"><input type="checkbox" checked><span class="slider round"></span></label>';
							// 	// '<div class="bootstrap-switch-container" style="width: 128px; "> <input type="checkbox" onclick="activate(this)" id="'+checkID+'" name="active" checked="" data-bootstrap-switch="" class="make-switch" data-off-color="danger" data-on-color="success"> </div>';
							// 	//  '<a id='+buttonID+' class="btn btn-success btn-xs" onclick="select_interest_details(this)" role="button">Select</a>';
							// }
						},
						{
							sortable: false,
							"render": function ( data, type, full, meta ) {
								var buttonID = "interest_id_"+full.interest_id;
								return '<a id='+buttonID+' class="btn btn-success btn-xs" onclick="select_interest_details(this)" role="button">Edit</a>';
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
				"order": [[3, 'asc']]
			});
		}
		load_table();
	});

	function select_interest_details(elem)
	{
		var id = $(elem).attr("id");
		var myString = id;
		var newString = myString.substr(12);
		$.ajax({
			url: '<?php echo base_url(); ?>maintenance/interest_details',
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
				$("#interest_id").val(response[0]['interest_id']);
				$("#interest_rate").val(response[0]['interest_rate']);
				$("#interest_description").val(response[0]['interest_description']);
				
			}
		});
	
	}

	function activate(dataelement)
	{
		var id = $(elem).attr("id");
		var val = $(elem).attr("value");
	}
	function update_interestrates()
	{
		$formdata = $("#form_interest_rates_details");
		$.ajax({
				url: '<?php echo base_url(); ?>maintenance/update_interest_rates',
				method: 'POST',
				dataType: 'json',
				async: true,
				data: $("#form_interest_rates_details").serialize(),
				error: function(response)
				{
				alert('Error! Please contact your administrator.');
				},
				success: function(response)
				{
					alert("Successfully updated!");
					load_table();
				}
			});
	}
</script>
