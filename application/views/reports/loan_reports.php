<div class="content-wrapper">    

<!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Loan Reports</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
			  <li class="breadcrumb-item"><a href="#">Reports</a></li>
              <li class="breadcrumb-item active">Loan Reports</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
		<div class="col-md-12">
			<select name="reports_to_display" id="reports_to_display" style="width: 25%" onchange="load_report(this)" class="form-control" >
				<option value="">Select Report</option>
				<option value="sales">Sales Report</option>
				<option value="collection">Collection Report</option>
				<option value="summary">Summary Report</option>
			</select>
		</div>
		<br/>	
		<div class="col-md-12" id="sales_div">
			<!-- general form elements disabled -->
			<div class="card card-warning">
				<div class="card-header">
					<h3 class="card-title"><b>Sales Reports</b></h3>
				</div>
				<select name="year_sales" id="year_sales" style="width: 25%" class="form-control" >
					<option value="">Select Year</option>
					<?php
					foreach($year_list as $row)
					{
							echo '<option value="'.$row["year_list"].'">'.$row["year_list"].'</option>';
					}
					?>
							</select>
				<div class="card-body">
					<div class="row">
						<div class="col-sm-12">
								<div class="card-box table-responsive">
										<table id="datatable_sales_report" class="table table-striped table-hover dt-responsive nowrap">
												<thead>
														<tr>
																<th width="20%">Customer Name</th>
																<th width="10%">Loan Amount</th>
																<th width="10%">Date Borrowed</th>
																<th width="10%">Date Released</th>
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
				<!-- <a href='<?= base_url() ?>reports/export_csv_sales_report'>Export</a><br><br> -->
				<input type="button" name="export_sales" id="export_sales" value="Export">
			</div>
		</div>

		<div class="col-md-12" id="collection_div">
			<!-- general form elements disabled -->
			<div class="card card-warning">
				<div class="card-header">
					<h3 class="card-title"><b>Collection</b></h3>
				</div>
				<select name="year_collection" id="year_collection" style="width: 25%" class="form-control" >
					<option value="">Select Year</option>
					<?php
					foreach($year_list as $row)
					{
							echo '<option value="'.$row["year_list"].'">'.$row["year_list"].'</option>';
					}
					?>
							</select>
				<div class="card-body">
					<div class="row">
						<div class="col-sm-12">
								<div class="card-box table-responsive">
										<table id="datatable_collection_report" class="table table-striped table-hover dt-responsive nowrap">
												<thead>
														<tr>
																<th width="20%">Customer Name</th>
																<th width="15%">Loan Amount</th>
																<th width="15%">Total Collection</th>
																<th width="20%">Date Released</th>
																<th width="20%">Maturity Date</th>
																<th width="20%">Payment Status</th>
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
				<input type="button" name="export_collection" id="export_collection" value="Export">
				<!-- <a href='<?= base_url() ?>reports/export_csv_collection_report'>Export</a><br><br> -->
			</div>
		</div>

		<div class="col-md-12" id="summary_div">
			<!-- general form elements disabled -->
			<div class="card card-warning">
				<div class="card-header">
					<h3 class="card-title"><b>Summary</b></h3>
				</div>
				<select name="year_summary" id="year_summary" style="width: 25%" class="form-control" >
					<option value="">Select Year</option>
					<?php
					foreach($year_list as $row)
					{
							echo '<option value="'.$row["year_list"].'">'.$row["year_list"].'</option>';
					}
					?>
				</select>
				<div class="card-body">
					<div class="row">
						<div class="col-sm-12">
								<div class="card-box table-responsive">
										<table id="datatable_summary_report" class="table table-striped table-hover dt-responsive nowrap">
												<thead>
														<tr>
																<th width="20%">Customer Name</th>
																<th width="10%">Loan Amount</th>
																<th width="10%">Revenue</th>
																<th width="10%">Total Collection</th>
																<th width="10%">Date Released</th>
																<th width="10%">Maturity Date</th>
																<th width="10%">Payment Status</th>
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
				<!-- <a href='<?= base_url() ?>reports/export_csv_summary_report?year='+document.getElementById("year_summary").value>Export</a><br><br> -->
				<!-- <a href=''>Export</a><br><br> -->
				<input type="button" name="export_summary" id="export_summary" value="Export">
			</div>
		</div>

</div>

<script type="text/javascript">

	$(document).ready(function()
	{
		$("#sales_div").hide();
		$("#summary_div").hide();
		$("#collection_div").hide();
		
		$('#export_summary').click( function(e) {
			var yr = new Date().getFullYear();
			if($('#year_summary').val() != '')
			{
				yr = $('#year_summary').val();
			}
			var go_to_url = "<?= base_url() ?>reports/export_csv_summary_report?year="+yr;
			// e.preventDefault(); 
			window.location.href = go_to_url;
			
		} );

		$('#export_collection').click( function(e) {
			var yr = new Date().getFullYear();
			if($('#year_collection').val() != '')
			{
				yr = $('#year_collection').val();
			}
			var go_to_url = "<?= base_url() ?>reports/export_csv_collection_report?year="+yr;
			// e.preventDefault(); 
			window.location.href = go_to_url;
			
		} );

		$('#export_sales').click( function(e) {
			var yr = new Date().getFullYear();
			if($('#year_sales').val() != '')
			{
				yr = $('#year_sales').val();
			}
			var go_to_url = "<?= base_url() ?>reports/export_csv_sales_report?year="+yr;
			// e.preventDefault(); 
			window.location.href = go_to_url;
			
		} );
	});

	
	function load_report(elem)
	{
		var val = $(elem).val();
		var myString = val;
		var yr = new Date().getFullYear();
		if(myString == 'sales')
		{
			if($('#year_sales').val() != '')
			{
				yr = $('#year_sales').val();
			}
			$("#summary_div").hide();
			$("#collection_div").hide();
			$("#sales_div").show();
			
			load_table = function(){
			
				$('#datatable_sales_report').dataTable().fnClearTable();
				$('#datatable_sales_report').dataTable().fnDraw();
				$('#datatable_sales_report').dataTable().fnDestroy();
				$("#datatable_sales_report").dataTable(
				{
					"scrollY":        "500px",
					"scrollCollapse": true,
					"bLengthChange": false,
					"deferLoading": 0,
					"ajax": {
					"url":"<?php echo base_url(); ?>reports/datatable_sales_report_list?year="+yr,
					"dataSrc": function (d) {
							return d
						}

					}  ,
					"columns": [
							{ data: 'fullname' },
							{ data: 'loan_amt' },
							{ data: 'date_borrowed' },
							{ data: 'date_released'}
						]
				});
			}
			load_table();
		}
		else if(myString == 'collection')
		{
			if($('#year_collection').val() != '')
			{
				yr = $('#year_collection').val();
			}
			$("#summary_div").hide();
			$("#sales_div").hide();
			$("#collection_div").show();
			load_table_collection = function(){
			
				$('#datatable_collection_report').dataTable().fnClearTable();
				$('#datatable_collection_report').dataTable().fnDraw();
				$('#datatable_collection_report').dataTable().fnDestroy();
				$("#datatable_collection_report").dataTable(
				{
					"scrollY":        "500px",
					"scrollCollapse": true,
					"bLengthChange": false,
					"deferLoading": 0,
					"ajax": {
					"url":"<?php echo base_url(); ?>reports/datatable_collection_report_list?year="+yr,
					"dataSrc": function (d) {
							return d
						}

					}  ,
					"columns": [
							{ data: 'fullname' },
							{ data: 'amount_borrowed' },
							{ data: 'totalcollection' },
							{ data: 'date_released'},
							{ data: 'end_date'},
							{ data: 'payment_status'}
						],
						"columnDefs" : [
						
						{ targets : [2],
							render : function (data, type, row) {
								return (parseFloat(row['totalcollection']).toFixed(2));
							}
						},
						{ targets : [1],
							render : function (data, type, row) {
								return (parseFloat(row['amount_borrowed']).toFixed(2));
							}
						}
				],
					
				});
			}
			load_table_collection();
		}
		else if(myString == 'summary')
		{
			if($('#year_summary').val() != '')
			{
				yr = $('#year_summary').val();
			}
			$("#summary_div").show();
			$("#collection_div").hide();
			$("#sales_div").hide();
			
			load_table_summary = function(){
			
				$('#datatable_summary_report').dataTable().fnClearTable();
				$('#datatable_summary_report').dataTable().fnDraw();
				$('#datatable_summary_report').dataTable().fnDestroy();
				$("#datatable_summary_report").dataTable(
				{
					"scrollY":        "500px",
					"scrollCollapse": true,
					"bLengthChange": false,
					"deferLoading": 0,
					"ajax": {
					"url":"<?php echo base_url(); ?>reports/datatable_summary_report_list?year="+yr,
					"dataSrc": function (d) {
							return d
						}

					}  ,
					"columns": [
							{ data: 'fullname' },
							{ data: 'loanamt', className: "text-right" },
							{ data: 'revenue', className: "text-right" },
							{ data: 'totalcollection', className: "text-right" },
							{ data: 'date_released' },
							{ data: 'end_date'},
							{ data: 'payment_status' },
						],
					"columnDefs" : [
						
						{ targets : [1],
							render : function (data, type, row) {
								return (parseFloat(row['loanamt']).toFixed(2));
							}
						},
						{ targets : [2],
							render : function (data, type, row) {
								return (parseFloat(row['revenue']).toFixed(2));
							}
						},
						{ targets : [3],
							render : function (data, type, row) {
								return (parseFloat(row['totalcollection']).toFixed(2));
							}
						}
					],
						
				});
			}
			load_table_summary();
		}
	}

</script>
<script>
    
$(document).ready(function(){
	
    $('#year_sales').change(function(){
        var display = $('#reports_to_display');
		load_report(display);
    });

	$('#year_collection').change(function(){
	var display =$('#reports_to_display');
		load_report(display);
    });

	$('#year_summary').change(function(){
		var display =$('#reports_to_display');
		load_report(display);
    });

	
});

</script>
