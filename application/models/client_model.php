<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

Class Client_model extends CI_Model
{
	function __construct()
    {
        parent::__construct();
    }

	function isRegistered($id)
	{
		$this->db->where('login_oauth_uid', $id);
		$query = $this->db->get('customers');
		if($query->num_rows() > 0)
		{
			return true;
		}
		else{
			return false;
		}
	}

	function update_user_data($data, $id)
	{
		$this->db->where('login_oauth_uid', $id);
		$this->db->update('customers', $data);

	}

	function insert_user_data($data)
	{
		$this->db->insert('customers', $data);
		return $this->db->insert_id(); 
	}

	public function getUser($id){
		$query = $this->db->get_where('customers',array('customer_id'=>$id));
		return $query->row_array();
	}

	public function getCustomer()
	{
		$user_rec = $this->getUser($this->session->userdata('customer_id'));
		
		$buyer = new PayMaya\Model\Checkout\Buyer();

		$address = new PayMaya\Model\Checkout\Address();
		$address->line1 = $user_rec['address_house_number'].' '.$user_rec['address_street'];
		$address->line2 = $user_rec['address_barangay'];
		$address->city = $user_rec['address_city_town'];
		$address->state = $user_rec['address_province'];
		$address->zipCode = $user_rec['zipcode'];
		$address->countryCode = "PH";
		$this->billingAddress = $address;


		$buyer->firstName = $user_rec['customer_fname'];
		$buyer->middleName = $user_rec['customer_mname'];
		$buyer->lastName = $user_rec['customer_lname'];
		$buyer->contactDetails = $user_rec['contact_number'];
		$buyer->billingAddress = $this->billingAddress;
		return $buyer;
	}

	public function get_user_array($id){
		$query = $this->db->get_where('customers',array('customer_id'=>$id));
		return $query->result_array();
	}

	public function activate($data, $id){
		$this->db->where('customers.customer_id', $id);
		return $this->db->update('customers', $data);
	}

	function validateuser($username,$password)
	{
		$this->db->select("*");
		$this->db->from("customers");
		$this->db->where("active", 1);
		$this->db->where("username", $username);
		$this->db->where("password", $password);
		$this->db->where("verified", 1);
		$result = $this->db->get();
        $userdata = $result->result_array();
		// var_dump($userdata);
		// exit();
		return $userdata;
	}

	function get_loan_existing_loan($id)
	{
		$this->db->select("*");
		$this->db->from("application");
		$this->db->where("customer_id", $id);
		$result = $this->db->get();
        $userdata = $result->result_array();
		// var_dump($userdata);
		// exit();
		return $userdata;
	}

	function get_interest_rate()
	{
		$this->db->select("interest_rate");
		$this->db->from("interest");
		$this->db->where("active", 1);
		$result = $this->db->get();
        $userdata = $result->result_array();
		// var_dump($userdata);
		// exit();
		return $userdata;
	}

	function apply_loan($input)
	{
		$cust_id = $this->session->userdata('customer_id');
		$prevrec = $this->get_loan_existing_loan($cust_id);
		$interest = $this->get_interest_rate();
		$application_type = 1;
		$date = new DateTime("now", new DateTimeZone('Asia/Kuala_Lumpur') );
		$currdate = $date->format('Y-m-d H:i:s');
		if($input['application_id'] == "")
		{
			if(count($prevrec) > 0)
			{
				$application_type = 2;
			}
	
			$data = array(
				'customer_id' => $cust_id,
				'amount_borrowed' => $input['amount_borrowed'],
				'application_type' => $application_type,
				'interest_rate' => $interest[0]['interest_rate'],
				'reason_for_loan' => $input['reason_for_loan']
			);
			$this->db->insert('application', $data);
		}
		else{
			$data = array(
				'amount_borrowed' => $input['amount_borrowed'],
				'reason_for_loan' => $input['reason_for_loan'],
				'date_updated' => $currdate
			);
			$this->db->where('application_id', $input['application_id']);
			$this->db->update('application', $data);
		}
		
	}

	function get_customer_status($id)
	{
		$this->db->select("*");
		$this->db->from("application");
		$this->db->where("customer_id", $id);
		$this->db->order_by('created_date', 'desc');
		$result = $this->db->get();
        $userdata = $result->result_array();
		// var_dump($userdata);
		// exit();
		return $userdata;
	}

	function cancel_loan($id)
	{
		$column = "*";
		$criteria = "application_id = ".$id['id'];
		$loan_rec = $this->application_model->getApplication($column, $criteria);
		
		$date = new DateTime("now", new DateTimeZone('Asia/Kuala_Lumpur') );
		$currdate = $date->format('Y-m-d H:i:s');

		if(!empty($loan_rec))
		{
			$data = array(
				'cancelled' => 1,
				'date_updated' => $currdate
			);
			$this->db->where('application_id', $id['id']);
			$this->db->update('application', $data);
		}
		else{
			return "Error: Record doesn't exist";
		}
		
		return "Success";
		
	}

	function get_billing($customer_id)
	{
		$this->db->select("paid_date, amount_paid");
		$this->db->from("loan_details");
		$this->db->join('application', 'application.application_id = loan_details.application_id', 'left');
		$this->db->where("`amount_paid` != 0");
		$this->db->where('customer_id', $customer_id);
		$this->db->where('application_status', 1);
		$this->db->where('loan_release_status', 2);
		$this->db->where('payment_status', 1);
		$this->db->order_by('due_date asc');
		$result = $this->db->get();
        $loandata = $result->result_array();
		// var_dump($userdata);
		// exit();
		return $loandata;
	}

	function get_all_payment_history($customer_id)
	{
		$this->db->select("paid_date, amount_paid");
		$this->db->from("loan_details");
		$this->db->join('application', 'application.application_id = loan_details.application_id', 'left');
		$this->db->where("`amount_paid` != 0");
		$this->db->where('customer_id', $customer_id);
		$this->db->order_by('due_date asc');
		$result = $this->db->get();
        $loandata = $result->result_array();
		// var_dump($userdata);
		// exit();
		return $loandata;
	}

	function get_totalbill($customer_id)
	{
		$this->db->select("SUM(amount_due) AS loan_amount, SUM(amount_paid) AS remittance, (SUM(amount_due) - SUM(amount_paid)) AS balance, amount_due");
		$this->db->from("loan_details");
		$this->db->join('application', 'application.application_id = loan_details.application_id', 'left');
		$this->db->where('customer_id', $customer_id);
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

	function get_district_list()
	{
		$this->db->select("*");
		$this->db->from('district');
		$result = $this->db->get();
		$data = $result->result_array();
		return $data;
	}

	function get_barangay_by_district($id)
	{
		$this->db->select("*");
		$this->db->from('barangay');
		$this->db->where('district_id', $id);
		$result = $this->db->get();
		$data = $result->result_array();
		return $data;
	}

	function get_occupation()
	{
		$sql = "SELECT * FROM occupation ORDER BY CASE  WHEN parent_id = 0 THEN id ELSE parent_id END ASC
		,  CASE WHEN parent_id = 0 THEN '0' ELSE description END ASC";
		$query = $this->db->query($sql);
		return $query->result_array(); 
	}
	
}
