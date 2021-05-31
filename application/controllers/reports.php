<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reports extends CI_Controller {
	function __contsruct()
	{
		parent::__construct();
		$this->load->model("reports_model");
	}

	public function index()
	{
		$this->session->sess_destroy();	
		
		$this->load->view('system_login');
	}

	public function report_and_sales()
	{
		if(empty($this->session->userdata('user_id')))
		{
			redirect('site/index');
		}
		$data['year_list'] = $this->reports_model->fetch_year();
		$data['mainmenu']='';
		$data['menu']='reports';
		$data['submenu']='sales_market';
		$this->load->view('includes/header',$data);
		$this->load->view('includes/sidebar',$data);
		$this->load->view('reports/sales_and_marketing', $data);
		$this->load->view('includes/footer');
	}

	public function fetch_data()
	{
		
		if($this->input->post('year'))
		{
			$chart_data = $this->reports_model->fetch_age($this->input->post('year'));
		
			foreach($chart_data as $row)
			{
				$output[] = array(
				'cust_count'  => intval($row["cust_count"]),
				'age' => intval($row["age"])
				);
			}
		echo json_encode($output);
		}
	}

	public function loan_reports()
	{
		if(empty($this->session->userdata('user_id')))
		{
			redirect('site/index');
		}

		$data['year_list'] = $this->reports_model->fetch_year();
		$data['mainmenu']='';
		$data['menu']='reports';
		$data['submenu']='loan_reports';
		$this->load->view('includes/header',$data);
		$this->load->view('includes/sidebar',$data);
		$this->load->view('reports/loan_reports', $data);
		$this->load->view('includes/footer');
	}

	public function fetch_occupation_data()
	{
		if($this->input->post('year'))
		{
			$chart_data = $this->reports_model->fetch_occupation($this->input->post('year'));
		
			foreach($chart_data as $row)
			{
				$output[] = array(
				'count_occ'  => intval($row["count_occ"]),
				'description' => $row["description"]
				);
			}
		echo json_encode($output);
		}
	}

	public function fetch_district_data()
	{
		if($this->input->post('year'))
		{
			$chart_data = $this->reports_model->fetch_districtarea($this->input->post('year'));
		
			foreach($chart_data as $row)
			{
				$output[] = array(
				'count_distr'  => intval($row["count_distr"]),
				'district' => 'District '.$row["district"]
				);
			}
		echo json_encode($output);
		}
	}

	public function fetch_data_sales()
	{
		if($this->input->post('year'))
		{
			$chart_data = $this->reports_model->fetch_sales($this->input->post('year'));
		
			foreach($chart_data as $row)
			{
				$output[] = array(
				'amount'  => floatval($row["amount"]),
				'date_borrowed' => $row["date_borrowed"]
				);
			}
		echo json_encode($output);
		}
	}

	public function export_csv(){ 
		// file name 
		
		$filename = 'sales_'.date('Ymd').'.csv'; 
		
		header("Content-Description: File Transfer"); 
		header("Content-Disposition: attachment; filename=$filename"); 
		header("Content-Type: application/csv; ");
		
	   // get data 
	   $year = '2020';
		$usersData = $this->reports_model->fetch_sales($year);
		
		// file creation 
		$file = fopen('php://output','w');
		$header = array("date_borrowed","amount"); 
		fputcsv($file, $header);
		foreach ($usersData as $key=>$line){ 
			fputcsv($file,$line); 
		}
		fclose($file); 
		exit; 
	}

	public function export_csv_sales_report()
	{
		$filename = 'sales_'.date('Ymd').'.csv'; 
		
		header("Content-Description: File Transfer"); 
		header("Content-Disposition: attachment; filename=$filename"); 
		header("Content-Type: application/csv; ");
		
	   // get data 
	   $year = date("Y");
	   if($_GET['year'] != '')
	   {
		$year = $_GET['year'];
	   }
		$usersData = $this->reports_model->get_sales_report($year);
		
		// file creation 
		$file = fopen('php://output','w');
		$header = array("Id","Name", "Loan Amount", "Date Borrowed", "Date Released"); 
		fputcsv($file, $header);
		foreach ($usersData as $key=>$line){ 
			fputcsv($file,$line); 
		}
		fclose($file); 
		exit; 
	}

	public function export_csv_collection_report()
	{
		$filename = 'collection_'.date('Ymd').'.csv'; 
		
		header("Content-Description: File Transfer"); 
		header("Content-Disposition: attachment; filename=$filename"); 
		header("Content-Type: application/csv; ");
		
	   // get data 
	   $year = date("Y");
	   if($_GET['year'] != '')
	   {
		$year = $_GET['year'];
	   }
		$usersData = $this->reports_model->get_collection_report($year);
		
		// file creation 
		$file = fopen('php://output','w');
		$header = array("Name", "Loan Amount", "Total Collection", "Date Released", "Maturity Date", "Payment Status"); 
		fputcsv($file, $header);
		foreach ($usersData as $key=>$line){ 
			fputcsv($file,$line); 
		}
		fclose($file); 
		exit; 
	}

	public function export_csv_summary_report()
	{
		$filename = 'summary_'.date('Ymd').'.csv'; 
		
		header("Content-Description: File Transfer"); 
		header("Content-Disposition: attachment; filename=$filename"); 
		header("Content-Type: application/csv; ");

	   $year = date("Y");
	   if($_GET['year'] != '')
	   {
		$year = $_GET['year'];
	   }
	
		$usersData = $this->reports_model->get_summary_report($year);
		
		// file creation 
		$file = fopen('php://output','w');
		$header = array("Name", "Loan Amount", "Revenue", "Total Collection", "Date Released", "Maturity Date", "Payment Status"); 
		fputcsv($file, $header);
		foreach ($usersData as $key=>$line){ 
			fputcsv($file,$line); 
		}
		fclose($file); 
		exit; 
	}

	public function datatable_sales_report_list()
	{
		// $year = '2021';
		$year = $_GET['year'];
		$results = $this->reports_model->get_sales_report($year);
        echo json_encode($results);
	}

	public function datatable_collection_report_list()
	{
		// $year = '2021';
		$year = $_GET['year'];
		$results = $this->reports_model->get_collection_report($year);
		echo json_encode($results);
	}

	public function datatable_summary_report_list()
	{
		$year = $_GET['year'];
		// var_dump($_GET);
		// exit();
		$results = $this->reports_model->get_summary_report($year);
		// var_dump($results);
		// exit();
		echo json_encode($results);
	}
}
