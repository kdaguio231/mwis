<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script> -->
 <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" /> -->
 <!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script> -->

<div class="content-wrapper">    

<!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Sales and Marketing</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
			  <li class="breadcrumb-item"><a href="#">Reports</a></li>
              <li class="breadcrumb-item active">Sales and Marketing</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

	<div class="content">
      <div class="container-fluid">
        <div class="row">
		<!-- first column -->
			<div class="col-lg-6">
				<div class="card">
					<div class="card-header border-0">
						<div class="d-flex justify-content-between">
						<h3 class="card-title">Select Year you want to view</h3>
							<select name="year_sales" id="year_sales" style="width: 50%" class="form-control" >
								<option value="">Select Year</option>
								<?php
								foreach($year_list as $row)
								{
										echo '<option value="'.$row["year_list"].'">'.$row["year_list"].'</option>';
								}
								?>
							</select>
						</div>
					</div>
					<div class="card-body">
						<br />
						<h3 align="center">Monthly Sales</h3>
						
						<div class="panel-body">
							<div id="chart_sales" style="width: 750px; height: 450px;"></div>
						</div>
					</div>
				</div>
			</div>
			

			<!-- second column -->
			<div class="col-lg-6">
				<div class="card">
					<div class="card-header border-0">
						<div class="d-flex justify-content-between">
						<h3 class="card-title">Select Year you want to view</h3>
							<select name="year_district" id="year_district" style="width: 50%" class="form-control" >
								<option value="">Select Year</option>
								<?php
								foreach($year_list as $row)
								{
										echo '<option value="'.$row["year_list"].'">'.$row["year_list"].'</option>';
								}
								?>
							</select>
						</div>
					</div>
					<div class="card-body">
						<br />
						<h3 align="center">Number of Borrowers Each Area</h3>
						
						<div class="panel-body">
							<div id="chart_area_district" style="width: 750px; height: 450px;"></div>
						</div>
					</div>
				</div>
					
			</div>
			
		</div>

		<!-- 2nd row -->
		<div class="row">
		<!-- first column -->
		<div class="col-lg-6">
				<div class="card">
					<div class="card-header border-0">
						<div class="d-flex justify-content-between">
						<h3 class="card-title">Select Year you want to view</h3>
							<select name="year_occu" id="year_occu" style="width: 50%" class="form-control" >
								<option value="">Select Year</option>
								<?php
								foreach($year_list as $row)
								{
										echo '<option value="'.$row["year_list"].'">'.$row["year_list"].'</option>';
								}
								?>
							</select>
						</div>
					</div>
					<div class="card-body">
						<br />
						<h3 align="center">Occupation of Borrowers</h3>
						
						<div class="panel-body">
							<div id="chart_area_occu" style="width: 750px; height: 450px;"></div>
						</div>
					</div>
				</div>
			</div>

			<!-- second column -->
			<div class="col-lg-6">
				<div class="card">
					<div class="card-header border-0">
						<div class="d-flex justify-content-between">
						<h3 class="card-title">Select Year you want to view</h3>
							<select name="year" id="year" style="width: 50%" class="form-control" >
								<option value="">Select Year</option>
								<?php
								foreach($year_list as $row)
								{
										echo '<option value="'.$row["year_list"].'">'.$row["year_list"].'</option>';
								}
								?>
							</select>
						</div>
					</div>
					<div class="card-body">
						<br />
						<h3 align="center">Age brackets of Borrowers</h3>
						
						<div class="panel-body">
							<div id="chart_area" style="width: 750px; height: 450px;"></div>
						</div>
					</div>
				</div>
					
			</div>
		</div>
	  </div>
	</div>
<!-- end of content-wrapper -->
</div>

		
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
// google.charts.load('current', {packages:['corechart', 'bar']});
// google.charts.setOnLoadCallback();
google.charts.load('current', {'packages':['corechart']}); 
google.charts.setOnLoadCallback(drawChart); 
google.charts.setOnLoadCallback(drawChartOccupation); 
google.charts.setOnLoadCallback(drawChartDistrict); 
google.charts.setOnLoadCallback(drawChartSales); 

	function drawChart() { 	
		var d = new Date();
		var year = d.getFullYear();
		var jsonData = $.ajax({ 
		url:"<?php echo base_url(); ?>reports/fetch_data",
		method:"POST",
		data:{year:year},
		dataType: "json", 
		async: false 
		}).responseText; 
           
      // Create our data table out of JSON data loaded from server. 
      	var data = new google.visualization.DataTable(jsonData); 
 
	 	data.addColumn('number', 'age');
		data.addColumn('number', 'Count');

		$.each(JSON.parse(jsonData), function(i, jsonData){
			var Age = jsonData.age;
			var cust_count = jsonData.cust_count;
			data.addRows([[Age, cust_count]]);
		});
		var chart_main_title = "Ages of borrowers in the year of "+year;
		var options = {
			title:chart_main_title,
			hAxis: {
				title: "Age"
			},
			vAxis: {
				title: "Number of clients"
			},
			chartArea:{width:'80%',height:'70%'}
		}

		var chart = new google.visualization.ColumnChart(document.getElementById('chart_area'));

		chart.draw(data, options);
    } 

	function drawChartOccupation()
	{
		var d = new Date();
		var year = d.getFullYear();
		var jsonData = $.ajax({ 
			url:"<?php echo base_url(); ?>reports/fetch_occupation_data",
			method:"POST",
			data:{year:year},
			dataType: "json", 
			async: false 
			}).responseText; 
			
		// Create our data table out of JSON data loaded from server. 
		var data = new google.visualization.DataTable(jsonData); 
	
		data.addColumn('string', 'Occupation');
    	data.addColumn('number', 'Count');

		$.each(JSON.parse(jsonData), function(i, jsonData){
			var occupation = jsonData.description;
			var count_occ = jsonData.count_occ;
			data.addRows([[occupation, count_occ]]);
		});
		var chart_main_title = "Occupation of borrowers in the year of "+year;
		var options = {
			title:chart_main_title,
			hAxis: {
				title: "Occupation"
			},
			vAxis: {
				title: "Number of clients"
			},
			chartArea:{width:'80%',height:'85%'}
		}

		var chart = new google.visualization.ColumnChart(document.getElementById('chart_area_occu'));

		chart.draw(data, options);
	}

	function drawChartDistrict()
	{
		var d = new Date();
		var year = d.getFullYear();
		var jsonData = $.ajax({ 
			url:"<?php echo base_url(); ?>reports/fetch_district_data",
			method:"POST",
			data:{year:year},
			dataType: "json", 
			async: false 
			}).responseText; 
			
		// Create our data table out of JSON data loaded from server. 
		var data = new google.visualization.DataTable(jsonData); 
	
		data.addColumn('string', 'District');
		data.addColumn('number', 'Count');

		$.each(JSON.parse(jsonData), function(i, jsonData){
			var district = jsonData.district;
			var count_distr = jsonData.count_distr;
			data.addRows([[district, count_distr]]);
		});

		var chart_main_title = "Number of Borrowers Each Area for the year of "+year;
		var options = {
			title:chart_main_title,
			hAxis: {
				title: "District"
			},
			vAxis: {
				title: "Number of clients per Area"
			},
			chartArea:{width:'80%',height:'85%'}
		}

		var chart = new google.visualization.ColumnChart(document.getElementById('chart_area_district'));

		chart.draw(data, options);
	}

	function drawChartSales() { 	
		var d = new Date();
		var year = d.getFullYear();
		var jsonData = $.ajax({ 
		url:"<?php echo base_url(); ?>reports/fetch_data_sales",
		method:"POST",
		data:{year:year},
		dataType: "json", 
		async: false 
		}).responseText; 
           
      // Create our data table out of JSON data loaded from server. 
      	var data = new google.visualization.DataTable(jsonData); 
 
	 	data.addColumn('string', 'date_borrowed');
		data.addColumn('number', 'amount');

		$.each(JSON.parse(jsonData), function(i, jsonData){
			var date_borrowed = jsonData.date_borrowed;
			var amount = jsonData.amount;
			data.addRows([[date_borrowed, amount]]);
		});
		var chart_main_title = "Monthly sales as of Year "+year;
		var options = {
			title:chart_main_title,
			hAxis: {
				title: "Date"
			},
			vAxis: {
				title: "Amount borrowed"
			},
			chartArea:{width:'80%',height:'70%'}
		}

		var chart = new google.visualization.LineChart(document.getElementById('chart_sales'));

		chart.draw(data, options);
    }

function load_monthwise_data(year, title)
{
    var temp_title = title + ' ' + year;
    $.ajax({
        url:"<?php echo base_url(); ?>reports/fetch_data",
        method:"POST",
        data:{year:year},
        dataType:"JSON",
        success:function(data)
        {
            drawMonthwiseChart(data, temp_title);
        }
    })
}


function drawMonthwiseChart(chart_data, chart_main_title)
{
    var jsonData = chart_data;
    var data = new google.visualization.DataTable();
    data.addColumn('number', 'age');
    data.addColumn('number', 'Count');

    $.each(jsonData, function(i, jsonData){
        var Age = jsonData.age;
        var cust_count = jsonData.cust_count;
        data.addRows([[Age, cust_count]]);
    });

    var options = {
        title:chart_main_title,
        hAxis: {
            title: "Age"
        },
        vAxis: {
            title: "Number of clients"
        },
        chartArea:{width:'80%',height:'70%'}
    }

    var chart = new google.visualization.ColumnChart(document.getElementById('chart_area'));

    chart.draw(data, options);
}

function load_occupation_data(year, title)
{
    var temp_title = title + ' ' + year;
    $.ajax({
        url:"<?php echo base_url(); ?>reports/fetch_occupation_data",
        method:"POST",
        data:{year:year},
        dataType:"JSON",
        success:function(data)
        {
            drawOccupationChart(data, temp_title);
        }
    })
}

function drawOccupationChart(chart_data, chart_main_title)
{
    var jsonData = chart_data;
    var data = new google.visualization.DataTable();
    data.addColumn('string', 'Occupation');
    data.addColumn('number', 'Count');

    $.each(jsonData, function(i, jsonData){
        var occupation = jsonData.description;
        var count_occ = jsonData.count_occ;
        data.addRows([[occupation, count_occ]]);
    });

    var options = {
        title:chart_main_title,
        hAxis: {
            title: "Occupation"
        },
        vAxis: {
            title: "Number of clients"
        },
        chartArea:{width:'80%',height:'85%'}
    }

    var chart = new google.visualization.ColumnChart(document.getElementById('chart_area_occu'));

    chart.draw(data, options);
}

// district area
function load_districtarea_data(year, title)
{
    var temp_title = title + ' ' + year;
    $.ajax({
        url:"<?php echo base_url(); ?>reports/fetch_district_data",
        method:"POST",
        data:{year:year},
        dataType:"JSON",
        success:function(data)
        {
            drawDistrictAreaChart(data, temp_title);
        }
    })
}

function drawDistrictAreaChart(chart_data, chart_main_title)
{
    var jsonData = chart_data;
    var data = new google.visualization.DataTable();
    data.addColumn('string', 'District');
    data.addColumn('number', 'Count');

    $.each(jsonData, function(i, jsonData){
        var district = jsonData.district;
        var count_distr = jsonData.count_distr;
        data.addRows([[district, count_distr]]);
    });

    var options = {
        title:chart_main_title,
        hAxis: {
            title: "District"
        },
        vAxis: {
            title: "Number of clients per Area"
        },
        chartArea:{width:'80%',height:'85%'}
    }

    var chart = new google.visualization.ColumnChart(document.getElementById('chart_area_district'));

    chart.draw(data, options);
}


function load_sales_data(year, title)
{
    var temp_title = title + ' ' + year;
    $.ajax({
        url:"<?php echo base_url(); ?>reports/fetch_data_sales",
        method:"POST",
        data:{year:year},
        dataType:"JSON",
        success:function(data)
        {
            drawSalesChart(data, temp_title);
        }
    })
}


function drawSalesChart(chart_data, chart_main_title)
{
    var jsonData = chart_data;
    var data = new google.visualization.DataTable();
    data.addColumn('string', 'date_borrowed');
	data.addColumn('number', 'amount');

    $.each(jsonData, function(i, jsonData){
        var date_borrowed = jsonData.date_borrowed;
		var amount = jsonData.amount;
		data.addRows([[date_borrowed, amount]]);
    });

    var options = {
		title:chart_main_title,
		hAxis: {
			title: "Date"
		},
		vAxis: {
			title: "Amount borrowed"
		},
		chartArea:{width:'80%',height:'70%'}
	}

    var chart = new google.visualization.LineChart(document.getElementById('chart_sales'));

    chart.draw(data, options);
}

</script>

<script>
    
$(document).ready(function(){
	
    $('#year').change(function(){
        var year = $(this).val();
        if(year != '')
        {
            load_monthwise_data(year, 'Ages of borrowers in the year of');
        }
    });

		$('#year_occu').change(function(){
        var year = $(this).val();
        if(year != '')
        {
			load_occupation_data(year, 'Occupation of borrowers in the year of');
        }
    });

	$('#year_district').change(function(){
        var year = $(this).val();
        if(year != '')
        {
			load_districtarea_data(year, 'Number of Borrowers Each Area');
        }
    });

	$('#year_sales').change(function(){
        var year = $(this).val();
        if(year != '')
        {
			load_sales_data(year, 'Monthly sales');
        }
    });

	
});

</script>
