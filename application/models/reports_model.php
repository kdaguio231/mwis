<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

Class Reports_model extends CI_Model
{
	function __construct()
    {
        parent::__construct();
    }

	function fetch_age($year)
	{
		$this->db->select('YEAR(created_date) AS year_list, FLOOR(DATEDIFF(CURDATE(), birthdate) / 365.25) AS age, COUNT(FLOOR(DATEDIFF(CURDATE(), birthdate) / 365.25)) as cust_count');
		$this->db->from('customers');
		$this->db->where('YEAR(created_date)', $year);
		$this->db->group_by('age');
		$result = $this->db->get();
		$result_set = $result->result_array();
		return $result_set;
	}

	function fetch_year()
	{
		$this->db->select('YEAR(created_date) AS year_list');
		$this->db->from('customers');
		$this->db->group_by('year_list', 'DESC');
		$result = $this->db->get();
		  $result_set = $result->result_array();
		return $result_set;
	}

	function fetch_occupation($year)
	{
		$this->db->select('COUNT(occupation.`description`) AS count_occ, occupation.`description`');
		$this->db->from('customers');
		$this->db->join('occupation', 'customers.occupation = occupation.id', 'left');
		$this->db->where('YEAR(created_date)', $year);
		$this->db->group_by('occupation.description');
		$result = $this->db->get();
		$result_set = $result->result_array();
		return $result_set;
	}

	function fetch_districtarea($year)
	{
		$this->db->select('address_province AS district, COUNT(address_province) AS count_distr');
		$this->db->from('customers');
		$this->db->where('YEAR(created_date)', $year);
		$this->db->group_by('address_province');
		$result = $this->db->get();
		$result_set = $result->result_array();
		return $result_set;
	}

	 function fetch_sales($year)
	 {
		$this->db->select("DATE_FORMAT(date_borrowed, '%b') AS date_borrowed, ROUND(SUM(amount_borrowed),2) AS amount");
		$this->db->from('application');
		$this->db->where('YEAR(date_borrowed)', $year);
		$this->db->group_by('MONTH(date_borrowed)');
		$result = $this->db->get();
		$result_set = $result->result_array();
		return $result_set;
	 }

	 function get_sales_report($get)
	 {
		$this->db->select("customers.customer_id, CONCAT(customers.`customer_lname`, ', ', customers.customer_fname, ' ', customers.customer_mname) AS fullname,
		SUM(application.`amount_borrowed`) AS loan_amt, DATE_FORMAT(application.`date_borrowed`, '%Y/%m/%d') AS date_borrowed, DATE_FORMAT(application.`date_released`, '%Y/%m/%d') AS date_released");
		$this->db->from('application');
		$this->db->join('customers', 'application.`customer_id` = customers.`customer_id`', 'left');
		$this->db->where('YEAR(date_borrowed)', $get);
		$this->db->group_by('application.customer_id');
		$this->db->order_by('fullname', 'asc');
		$result = $this->db->get();
		$result_set = $result->result_array();
		return $result_set;
	 }

	 function get_collection_report($get)
	 {
		$this->db->select("CONCAT(customers.`customer_lname`, ', ', customers.customer_fname, ' ', customers.customer_mname) AS fullname, SUM(application.`amount_borrowed`) AS amount_borrowed, SUM(amount_paid) AS totalcollection, DATE_FORMAT(application.`date_released`,'%Y/%m/%d') as date_released, DATE_FORMAT(application.`end_date`,'%Y/%m/%d') as end_date, CASE application.`payment_status` WHEN 1 THEN 'On Going' ELSE 'Fully Paid' END AS payment_status");
		$this->db->from('loan_details');
		$this->db->join('application', 'application.`application_id` = loan_details.`application_id`', 'left');
		$this->db->join('customers', 'application.`customer_id` = customers.`customer_id`', 'left');
		$this->db->where('loan_details.status', 1);
		$this->db->where('YEAR(paid_date)', $get);
		$this->db->group_by('fullname');
		$this->db->order_by('fullname', 'asc');
		$result = $this->db->get();
		$result_set = $result->result_array();
		return $result_set;
	 }
	 
	 function get_summary_report($get)
	 {
		$this->db->select("CONCAT(customers.`customer_lname`, ', ', customers.customer_fname, ' ', customers.customer_mname) AS fullname,
		SUM(application.`amount_borrowed`) AS loanamt, SUM(application.`amount_borrowed`*.17) AS revenue, SUM(amount_paid) AS totalcollection, DATE_FORMAT(application.`date_released`,'%Y/%m/%d') as date_released, DATE_FORMAT(application.`end_date`,'%Y/%m/%d') as end_date, 
		CASE application.`payment_status` WHEN 1 THEN 'On Going' ELSE 'Fully Paid' END AS payment_status");
		$this->db->from('loan_details');
		$this->db->join('application', 'application.`application_id` = loan_details.`application_id`', 'left');
		$this->db->join('customers', 'application.`customer_id` = customers.`customer_id`', 'left');
		$this->db->where('loan_details.status', 1);
		$this->db->where('YEAR(paid_date)', $get);
		$this->db->group_by('fullname');
		$this->db->order_by('fullname', 'asc');
		$result = $this->db->get();
		$result_set = $result->result_array();
		return $result_set;
	 }
}
