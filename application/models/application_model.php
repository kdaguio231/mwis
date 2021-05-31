<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

Class Application_model extends CI_Model
{
	function __construct()
    {
        parent::__construct();
		$this->load->model('interest_model');
    }

	function getApplicationAll()
	{
		$this->db->select("*");
		$this->db->from("application");
		$result = $this->db->get();
		$result_set = $result->result_array();
		return $result_set;
	}

	function getApplication($column, $where)
	{
		$this->db->select($column);
		$this->db->from("application");
		$this->db->where($where);
		$result = $this->db->get();
        $result_set = $result->result_array();
		return $result_set;
	}

	function getApplicationJoin($column, $table2, $joinOn, $joinType, $where=null)
	{
		$this->db->select($column);
		$this->db->from("application");
		$this->db->join($table2, $joinOn, $joinType );
		if($where != null)
		{
			$this->db->where($where);
		}
		
		$result = $this->db->get();
        $result_set = $result->result_array();
		return $result_set;
	}

	function approve_application($input)
	{
		$column = "*";
		$criteria = "application_id = ".$input["id"];
		$application_rec = $this->getApplication($column, $criteria);
		$date = new DateTime("now", new DateTimeZone('Asia/Kuala_Lumpur') );
		$currdate = $date->format('Y-m-d H:i:s');

		$interest = $this->interest_model->getInterestAll();

		// var_dump($interest);
		// exit();
		if(!empty($application_rec))
		{
			$data = array(
				'interest_rate' => $interest[0]['interest_rate'],
				'application_status' => 1,
				'loan_release_status' => 1,
				'payment_status' => 0,
				'approved_by' => $this->session->userdata('user_id'),
				'verified_by' => $this->session->userdata('user_id'),
				'date_approved' => $currdate,
				'date_updated' => $currdate
			);
			$this->db->where('application_id', $input['id']);
			$this->db->update('application', $data);
		}
		else{
			return "Error: Record doesn't exist";
		}
		
		return "Success";
	}

	function loan_release($input)
	{
		$column = "*";
		$criteria = "application_id = ".$input["id"];
		$loan_rec = $this->getApplication($column, $criteria);
		$date = new DateTime("now", new DateTimeZone('Asia/Kuala_Lumpur') );
		$currdate = $date->format('Y-m-d H:i:s');
		$loandays = 100;
		
		$enddate = date('Y-m-d', strtotime("+101 days"));
		$start = date('Y-m-d', strtotime($currdate . ' + 1 day')); // Added one day to start from 03-05-2018
		
		$startdate = new DateTime($start);
		$ender = new DateTime($enddate);
		
		$interval = DateInterval::createFromDateString('1 day');
		$period   = new DatePeriod($startdate, $interval, $ender);
		$time = strtotime($ender->format("Y-m-d"));

		$newformat = date('Y-m-d',$time);
		if(!empty($loan_rec))
		{
			$data = array(
				'loan_release_status' => 2,
				'payment_status' => 1,
				'released_by' => $this->session->userdata('user_id'),
				'date_released' => $currdate,
				'date_updated' => $currdate,
				'end_date' => $newformat
			);
			$this->db->where('application_id', $input['id']);
			$this->db->update('application', $data);

			$loanamount = $loan_rec[0]['amount_borrowed'];
			$percentage = intval($loanamount * ($loan_rec[0]['interest_rate'] /  100));
			$amt = $loanamount + $percentage;
			$paymentperday = $amt/100; //100 days

			// echo ($paymentperday);
			// exit();
			
			$interest = $this->interest_model->getInterestAll();

			$loandetails = array(
				'application_id' => $input["id"],
				'amount_due' => $paymentperday,
				'amount_paid' => $paymentperday,
				'paid_date' => $currdate,
				'interest_rate_id' => $interest[0]['interest_rate'],
				'created_date' => $currdate,
				'updated_by' => $this->session->userdata('user_id'),
			);
			// var_dump($loandetails);
			// exit();

			$this->db->insert('loan_details', $loandetails);

			// remove the 100 days loan details
			// foreach ($period as $dt) {
			// 	$duedate = $dt->format("Y-m-d");

			// 	$loandetailsloop = array(
			// 		'application_id' => $input["id"],
			// 		'amount_due' => $paymentperday,
			// 		'due_date' => $duedate,
			// 		'interest_rate_id' => $loan_rec[0]['interest_rate'],
			// 		'created_date' => $currdate
			// 	);

			// 	$this->db->insert('loan_details', $loandetailsloop);
			// }
		}
		else{
			return "Error: Record doesn't exist";
		}
		
		return "Success";
	}

	function getApplicationdetails($where=null)
	{
		$this->db->select("application.application_id, customers.customer_id, customer_lname, customer_fname, 
		customer_mname, address_house_number, address_street, address_barangay, barangay.barangay AS barangay, 
		address_city_town, customers.address_province, district.district_number AS district, 
		occupation.`description` AS occupation, birthdate, application.application_type, application.amount_borrowed, 
		customers.`verified_id`");
		$this->db->from("application");
		$this->db->join("customers", 'application.customer_id = customers.customer_id', 'left');
		$this->db->join("district", 'customers.address_province = district.id', 'left');
		$this->db->join("barangay", 'customers.address_barangay = barangay.id', 'left');
		$this->db->join("occupation", 'customers.occupation = occupation.id', 'left');
		if($where != null)
		{
			$this->db->where($where);
		}
		$this->db->where('verified = 1');
		$result = $this->db->get();
        $result_set = $result->result_array();
		return $result_set;
	}
	
}
