<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transaction extends CI_Controller {
	function __contsruct()
	{
		parent::__construct();
		$this->load->model('application_model');
		$this->load->model("loans_model");
	}
	public function index()
	{
		if(empty($this->session->userdata('user_id')))
		{
			redirect('site/index');
		}

		$data['mainmenu']='';
		$data['menu']='';
		$this->load->view('includes/header',$data);
		$this->load->view('includes/sidebar',$data);
		$this->load->view('dashboard/home');
		$this->load->view('includes/footer');
	}

	public function application()
	{
		if(empty($this->session->userdata('user_id')))
		{
			redirect('site/index');
		}

		$data['mainmenu']='';
		$data['menu']='transaction';
		$data['submenu']='application';
		$this->load->view('includes/header',$data);
		$this->load->view('includes/sidebar',$data);
		$this->load->view('transaction/application');
		$this->load->view('includes/footer');
	}

	public function loans()
	{
		if(empty($this->session->userdata('user_id')))
		{
			redirect('site/index');
		}

		$data['mainmenu']='';
		$data['menu']='';
		$this->load->view('includes/header',$data);
		$this->load->view('includes/sidebar',$data);
		$this->load->view('transaction/loans');
		$this->load->view('includes/footer');
	}

	public function loans_for_release()
	{
		if(empty($this->session->userdata('user_id')))
		{
			redirect('site/index');
		}

		$data['mainmenu']='';
		$data['menu']='transaction';
		$data['submenu']='loan_management';
		$data['subsubmenu']='for_release';
		$this->load->view('includes/header',$data);
		$this->load->view('includes/sidebar',$data);
		$this->load->view('transaction/loans_for_release');
		$this->load->view('includes/footer');
	}

	public function active_loans()
	{
		if(empty($this->session->userdata('user_id')))
		{
			redirect('site/index');
		}

		$data['mainmenu']='';
		$data['menu']='transaction';
		$data['submenu']='loan_management';
		$data['subsubmenu']='active_loans';
		$this->load->view('includes/header',$data);
		$this->load->view('includes/sidebar',$data);
		$this->load->view('transaction/active_loans');
		$this->load->view('includes/footer');
	}

	public function loans_overdue()
	{
		if(empty($this->session->userdata('user_id')))
		{
			redirect('site/index');
		}

		$data['mainmenu']='';
		$data['menu']='transaction';
		$data['submenu']='loan_management';
		$data['subsubmenu']='overdue';
		$this->load->view('includes/header',$data);
		$this->load->view('includes/sidebar',$data);
		$this->load->view('transaction/loans_overdue');
		$this->load->view('includes/footer');
	}

	public function collection()
	{
		if(empty($this->session->userdata('user_id')))
		{
			redirect('site/index');
		}

		$data['mainmenu']='';
		$data['menu']='transaction';
		$data['submenu']='collection';
		$this->load->view('includes/header',$data);
		$this->load->view('includes/sidebar',$data);
		$this->load->view('transaction/collection');
		$this->load->view('includes/footer');
	}

	public function application_list()
	{
		$column = array(
			"application.application_id",
			"CONCAT(customers.`customer_lname`, ', ', customers.customer_fname, ' ', customers.customer_mname) as fullname",
			"CONCAT(customers.`address_house_number`, ' ', customers.`address_street`, ' ', customers.`address_barangay`, ' ', customers.`address_city_town`, ', ', customers.`address_province`) AS address",
			"customers.`occupation`",
			"amount_borrowed", 
			"date_borrowed", 
			"application_status",
			"application_type"
		);
		$table2 = "customers";
		$joinOn = "application.`customer_id` = customers.customer_id";
		$joinType = "left";
		$where = "application_status = 0";
		$results = $this->application_model->getApplicationJoin($column, $table2, $joinOn, $joinType, $where);
        echo json_encode($results);
	}

	public function approve_application()
	{
		$post_formdata = $this->input->post();
        $results = $this->application_model->approve_application($post_formdata);
		echo json_encode($results);
	}

	public function load_loan_for_release_list()
	{
		$column = array(
			"`application`.`application_id`", 
			"CONCAT(customers.`customer_lname`, ', ', customers.customer_fname, ' ', customers.customer_mname) AS fullname", 
			"`amount_borrowed`", 
			"application_type", 
			"loan_release_status", 
			"payment_status"
		);
		$table2 = "customers";
		$joinOn = "application.`customer_id` = customers.customer_id";
		$joinType = "left";
		$where = "application.loan_release_status = 1";
		$results = $this->application_model->getApplicationJoin($column, $table2, $joinOn, $joinType, $where);
        echo json_encode($results);
	}

	public function load_active_loan_list()
	{
		$column = array(
			"`application`.`application_id`", 
			"CONCAT(customers.`customer_lname`, ', ', customers.customer_fname, ' ', customers.customer_mname) AS fullname", 
			"`amount_borrowed`", 
			"application_type", 
			"loan_release_status", 
			"payment_status"
		);
		$table2 = "customers";
		$joinOn = "application.`customer_id` = customers.customer_id";
		$joinType = "left";
		$where = "application.loan_release_status = 2";
		$results = $this->application_model->getApplicationJoin($column, $table2, $joinOn, $joinType, $where);
        echo json_encode($results);
	}

	public function load_overdue_list()
	{
		$results = $this->loans_model->getLoanOverdueList();
        echo json_encode($results);
	}

	public function load_central_collection_list()
	{
		$results = $this->loans_model->getCentralCollectionList();
        echo json_encode($results);
	}

	public function loan_release()
	{
		$post_formdata = $this->input->post();
        $results = $this->application_model->loan_release($post_formdata);
		echo json_encode($results);
	}

	public function loan_details($id)
	{
		if(empty($this->session->userdata('user_id')))
		{
			redirect('site/index');
		}
		
		$where = "application.application_id =".$id;
		$results = $this->application_model->getApplicationdetails($where);
		$destination_path = getcwd().DIRECTORY_SEPARATOR;
		$target_path = base_url('upload/') . $results[0]['verified_id'];
		// var_dump($this->db->last_query());
		// exit();
		$data['mainmenu']='';
		$data['menu']='';
		$data['verified_id_path'] = $target_path;
		$data['details'] = $results;
		$this->load->view('includes/header',$data);
		$this->load->view('includes/sidebar',$data);
		$this->load->view('transaction/loan_details', $data);
		$this->load->view('includes/footer');
	}

	public function payment_record()
	{
		$results = $this->loans_model->get_loan_remittance($_GET);
		echo json_encode($results);
	}

	public function update_loan_account()
	{
		$post_formdata = $this->input->post();
        $results = $this->loans_model->update_loan_account_details($post_formdata);
		echo json_encode($results);
	}

	public function daily_loans_payment()
	{
		$post_formdata = $this->input->post();
		
        $results = $this->loans_model->daily_central_collection($post_formdata);
		echo json_encode($results);
	}

	public function verify_accounts()
	{
		$data['mainmenu']='';
		$data['menu']='transaction';
		$data['submenu']='verify_accounts';
		$this->load->view('includes/header',$data);
		$this->load->view('includes/sidebar',$data);
		$this->load->view('transaction/for_verification_customers', $data);
		$this->load->view('includes/footer');
	}

	public function datatable_verify_customers_list()
	{
		$results = $this->loans_model->get_customer_list_for_verification();
        echo json_encode($results);
	}

	public function verify_account()
	{
		$post_formdata = $this->input->post();
		$results = $this->loans_model->verify_account_with_govtid($post_formdata);
        echo json_encode($results);
	}

}
