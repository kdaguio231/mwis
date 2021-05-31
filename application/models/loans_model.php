<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

Class Loans_model extends CI_Model
{
	function __construct()
    {
        parent::__construct();
		$this->load->model('interest_model');
    }

	function getLoanDetailsAll()
	{
		$this->db->select("*");
		$this->db->from("loan_details");
		$result = $this->db->get();
		$result_set = $result->result_array();
		return $result_set;
	}

	function getLoanDetails($column, $where)
	{
		$this->db->select($column);
		$this->db->from("loan_details");
		if(!empty($where))
		{
			$this->db->where($where);
		}
		
		$result = $this->db->get();
        $result_set = $result->result_array();
		return $result_set;
	}

	function getLoanDetailsJoin($column, $table2, $joinOn, $joinType, $where=null)
	{
		$this->db->select($column);
		$this->db->from("loan_details");
		$this->db->join($table2, $joinOn, $joinType );
		if($where != null)
		{
			$this->db->where($where);
		}
		
		$result = $this->db->get();
        $result_set = $result->result_array();
		return $result_set;
	}

	function get_loan_remittance($get)
	{
		// var_dump($get);
		// exit();
		$this->db->select('amount_paid, due_date, paid_date');
        $this->db->from('loan_details');
        $this->db->where('application_id', $get['application_id']);
		$this->db->order_by("due_date", "asc");
        $result = $this->db->get();
        return $result->result_array();
	}

	function update_loan_account_details($input)
	{
		$date = new DateTime("now", new DateTimeZone('Asia/Kuala_Lumpur') );
		$currdate = $date->format('Y-m-d H:i:s');
		$data = array(
			'customer_lname' => $input['customer_lname'],
			'customer_fname' => $input['customer_fname'],
			'customer_mname' => $input['customer_mname'],
			'address_house_number' => $input['address_house_number'],
			'address_barangay' => $input['address_barangay'],
			'address_city_town' => $input['address_city_town'],
			'address_province' => $input['address_province'],
			'occupation' => $input['occupation'],
			'birthdate' => $input['birthdate'],
			'date_modified' => $currdate,
		);
		$this->db->where('customer_id', $input['customer_id']);
		$this->db->update('customers', $data);

		return $input['customer_id'];
	}
	
	function getLoanOverdueList($where=null)
	{
		$this->db->select("(application.`amount_borrowed`*(loan_details.`interest_rate_id`/100))+application.`amount_borrowed` AS total_loanamount, application.application_id, CONCAT(customers.`customer_lname`, ', ', customers.customer_fname, ' ', customers.customer_mname) AS fullname,
		amount_borrowed, SUM(amount_paid) AS amount_paid, (SUM(amount_due) - SUM(amount_paid)) AS balance, application.`end_date`");
		$this->db->from("loan_details");
		$this->db->join("application", "application.`application_id` = loan_details.`application_id`");
		$this->db->join("customers", "customers.`customer_id` = application.`application_id`");
		$this->db->where("(application.`end_date` <= CURDATE())");
		$this->db->where('application.loan_release_status', 2);
		$this->db->where('application.payment_status', 1);

		if($where != null)
		{
			$this->db->where($where);
		}
		$this->db->group_by("application_id");
		$result = $this->db->get();
        $result_set = $result->result_array();
		return $result_set;
	}

	function daily_central_collection($input)
	{
		
		$date = new DateTime("now", new DateTimeZone('Asia/Kuala_Lumpur') );
		$currdate = $date->format('Y-m-d H:i:s');
		$datewhere = $date->format('Y-m-d');
		$amountpaid = $input['amount'];
		$interest = $this->interest_model->getInterestAll();

		$data = array(
			'amount_paid' => floatval($amountpaid),
			'paid_date' => $currdate,
			'created_date' => $currdate,
			'updated_by' => $this->session->userdata('user_id'),
			'application_id' => $input['id'],
			'interest_rate_id' => $interest[0]['interest_rate'],
		);
		$this->db->insert('loan_details', $data);
		
		$getbilling = $this->get_totalbill_by_application_id($input['id']);
		$total = $getbilling[0]['remittance'];
		if($total == $getbilling[0]['loan_amount'])
		{
			$data_application = array(
				'payment_status' => 2,
				'loan_release_status' => 3,
				'date_updated' => $currdate
			);

			$this->db->where('application_id', $input['id']);
	
			$this->db->update('application', $data_application);
		}
		return $input['id'];
	}

	function get_totalbill_by_application_id($application_id)
	{
		$this->db->select("(application.`amount_borrowed`*(loan_details.`interest_rate_id`/100))+application.`amount_borrowed` AS loan_amount, SUM(amount_paid) AS remittance");
		$this->db->from("loan_details");
		$this->db->join('application', 'application.application_id = loan_details.application_id', 'left');
		$this->db->where('application.application_id', $application_id);
		$this->db->where('application_status', 1);
		$this->db->where('loan_release_status', 2);
		$this->db->where('payment_status', 1);
		$this->db->order_by('due_date', 'asc');
		$result = $this->db->get();
        $loandata = $result->result_array();
		// var_dump($userdata);
		// exit();
		return $loandata;
	}

	function getCentralCollectionList($where=null)
	{
		$this->db->select("application.application_id, CONCAT(customers.`customer_lname`, ', ', customers.customer_fname, ' ', customers.customer_mname) AS fullname,
		(application.`amount_borrowed`*(loan_details.`interest_rate_id`/100))+application.`amount_borrowed` AS loanamount, ((application.`amount_borrowed`*(loan_details.`interest_rate_id`/100))+application.`amount_borrowed`)/100 AS minimum_amount_due, SUM(amount_paid) AS sum_amount_paid");
		$this->db->from("loan_details");
		$this->db->join("application", "application.`application_id` = loan_details.`application_id`", "left");
		$this->db->join("customers", "customers.`customer_id` = application.`application_id`", 'left');
		// $this->db->where("(due_date <= CURDATE())");
		$this->db->where('application_status', 1);
		$this->db->where('loan_release_status', 2);
		$this->db->where('payment_status', 1);
		if($where != null)
		{
			$this->db->where($where);
		}
		$this->db->group_by("application_id");
		$result = $this->db->get();
        $result_set = $result->result_array();
		return $result_set;
	}

	function get_customer_list_for_verification()
	{
		$this->db->select("customers.`customer_id`, CONCAT(customers.`customer_lname`, ', ', customers.customer_fname, ' ', customers.customer_mname) AS fullname,
		CONCAT(customers.`address_house_number`,  ' ', barangay.`barangay`, ' District ', district.`district_number`, ', ',customers.`address_city_town`) AS address,
		occupation.`description` as occupation");
		$this->db->from('customers');
		$this->db->join('district', 'district.`district_number` = customers.`address_province`', 'left');
		$this->db->join('barangay', 'barangay.`id` = customers.`address_barangay`', 'left');
		$this->db->join('occupation', 'occupation.`id` = customers.`occupation`', 'left');
		$this->db->where('verified_id IS NOT NULL AND verified_id_by IS NULL');
		$result = $this->db->get();
        $result_set = $result->result_array();
		return $result_set;
	}

	 function verify_account_with_govtid($input)
	 {
		$date = new DateTime("now", new DateTimeZone('Asia/Kuala_Lumpur') );
		$currdate = $date->format('Y-m-d H:i:s');

		$this->db->select('customer_id');
		$this->db->from('customers');
		$this->db->where('customers.customer_id', $input['id']);
		$result = $this->db->get();
        $result_set = $result->result_array();

		$data_application = array(
			'verified_id_by' => $this->session->userdata('user_id'),
			'date_modified' => $currdate
		);

		$this->db->where('customer_id', $result_set[0]['customer_id']);

		$this->db->update('customers', $data_application);
	 }
}
