<div class="content-wrapper">    

<!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Billing/Payment</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Billing/Payment</li>
            </ol>
          </div>
        </div>

		<div class="row">
          <div class="col-sm-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3>₱<?php echo number_format($loan_amount,2); ?></h3>

                <p>Loan Amount</p>
              </div>
              <div class="icon">
                <i class="far fa-money-bill-alt"></i>
              </div>
              <a href="#" class="small-box-footer"></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3>₱<?php echo number_format($remittance, 2); ?></h3>

                <p>Remittance</p>
              </div>
              <div class="icon">
                <i class="far fa-credit-card"></i>
              </div>
              <a href="#" class="small-box-footer"> </a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3>₱<?php echo number_format($balance, 2);?></h3>

                <p>Balance</p>
              </div>
              <div class="icon">
                <i class="fas fa-tags"></i>
              </div>
              <a href="#" class="small-box-footer"> </a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3>65</h3>

                <p>Delinquency/Overdue</p>
              </div>
              <div class="icon">
                <i class="fas fa-coins"></i>
              </div>
              <a href="#" class="small-box-footer"> </a>
            </div>
          </div>
          <!-- ./col -->
        </div>
      </div><!-- /.container-fluid -->
    </section>
		
	<div class="row" style="margin-left: 10px">
	<div class="col-md-6">
            <!-- general form elements disabled -->
            <div class="card card-warning">
              <div class="card-header">
                <h3 class="card-title">Payment Record</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
			  <form class="" id="form_payment">
							<!-- Name -->
							<div class="row">
							<div class="card-body table-responsive p-0" >
								<table class="table table-head-fixed table-foot-fixed text-nowrap bill_breakdown_details" id="bill_breakdown_details">
								<thead>
									<tr>
									<th style="width: 200px">Date</th>
									<th style="width: 200px">Amount</th>
									</tr>
								</thead>
								<tbody style="height: 300px; ">
									
								</tbody>
								
								</table>
							</div>
								
							</div>
							

						</form>	
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
			</div>
			<div class="col-md-4">
            <!-- general form elements disabled -->
            <div class="card card-warning">
              <div class="card-header">
                <h3 class="card-title">Payment</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
			  <form class="" id="form_payment">
			  <input type="hidden" id="application_id" value="<?php echo $application_id;?>">
							<!-- Balance -->
							<div class="row">
								<div class=" col-8">
										<label>Total Amount Due</label>
								</div>
								<div class=" col-3">
										<h3 style="text-align: right"><?php echo number_format($balance,2); ?></h3>
								</div>
								
							</div>
							<!-- Minimum amount paid -->
							<div class="row">
								<div class=" col-8">
										<label>Minimum amount paid</label>
								</div>
								<div class=" col-3">
										<h3 style="text-align: right"><?php echo number_format($minimum_amount_due,2); ?></h3>
								</div>
								
							</div>
							<div class="row">
								
								<div class="col-sm-5">
									<!-- text input -->
									<div class="form-group">
										<label></label>
									</div>
								</div>
								<div class="col-sm-5">
									<!-- text input -->
									<div class="form-group">
										<label></label>
										<input type="text" value="" id="amount" name="amount" class="form-control" placeholder="Enter Amount to pay">
									
									</div>
								</div>
							</div>
							<div class="row">
								<!-- birthdate -->
								<div class="col-sm-8">
									<!-- text input -->
									<div class="form-group">
									
									</div>
								</div>
								<div class="col-sm-2">
									<!-- text input -->
									<div class="form-group">
									<button type="button" onclick="submit_payment()" class="btn btn-block btn-success waves-effect waves-light" >Pay</button>
									</div>
								</div>
							</div>

						</form>	
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
			</div>
	</div>


<div id="err"></div>
<script type="text/javascript">
	

	
function submit_payment()
{
	var amount = $("#amount").val();
	var application_id = $("#application_id").val();
		$.ajax({
				url: '<?php echo base_url(); ?>client/checkout',
				method: 'POST',
				dataType: 'json',
				async: true,
				data: {amount: amount, application_id: application_id},
				error: function(response)
				{
					alert('Error! Please contact your administrator.');
				},
				success: function(response)
				{
					// alert(response["CheckoutId"]);
					window.location.href = response["redirectUrl"];
				}
			});
}

	$(document).ready(function()
	{
		load_table = function(){
			$('#bill_breakdown_details').dataTable().fnClearTable();
			$('#bill_breakdown_details').dataTable().fnDraw();
			$('#bill_breakdown_details').dataTable().fnDestroy();
			$("#bill_breakdown_details").dataTable(
			{
				"bLengthChange": false,
				"bPaginate": false,
				"bInfo": false,
				"deferLoading": 0,
				"ajax": {
				"url":"<?php echo base_url(); ?>client/load_breakdown",
				"dataSrc": function (d) {
						return d
					}

				}  ,
				"order": [[ 1, "asc" ]],
				"columns": [
						{ data: 'paid_date' },
						{ data: 'amount_paid' }
					],
				"sDom": "lrtip",
				'columnDefs': [
					{
						"targets": 0, // your case first column
						"className": "text-left",
					},
					{
						"targets": 1,
						"className": "text-right",
					}],
			});
		}
		load_table();
	});
</script>
