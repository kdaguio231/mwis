<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Maintenance extends CI_Controller {
	function __contsruct()
	{
		parent::__construct();
		$this->load->model('users_model');
		$this->load->model('interest_model');

	}

	public function user_accounts()
	{
		if(empty($this->session->userdata('user_id')))
		{
			redirect('site/index');
		}

		$data['mainmenu']='';
		$data['menu']='maintenance';
		$data['submenu']='user_accounts';
		$this->load->view('includes/header',$data);
		$this->load->view('includes/sidebar',$data);
		$this->load->view('maintenance/user_accounts');
		$this->load->view('includes/footer');

	}

	public function userlist()
	{
		$results = $this->users_model->user_list();
        echo json_encode($results);
	}

	public function interest_rate()
	{
		if(empty($this->session->userdata('user_id')))
		{
			redirect('site/index');
		}
		
		$data['mainmenu']='';
		$data['menu']='maintenance';
		$data['submenu'] = 'interest_rate';
		$this->load->view('includes/header',$data);
		$this->load->view('includes/sidebar',$data);
		$this->load->view('maintenance/interest_rate');
		$this->load->view('includes/footer');
	}

	public function interestratelist()
	{
		$columns = "interest_id, interest_rate, interest_description, active, created_date";
		
		$results = $this->interest_model->getInterest($columns);
        echo json_encode($results);
	}

	public function update_interest_rates()
	{
		$post_formdata = $this->input->post();
		// var_dump($post_formdata);
		// exit();
		$results = $this->interest_model->updateInterestDetails($post_formdata);
		echo json_encode($results);
	}

	public function interest_details()
	{
		$post_formdata = $this->input->post();
		$column = "interest_id, interest_rate, interest_description";
		$where = "interest_id =".$post_formdata['id'];
        $results = $this->interest_model->getInterest($column, $where);
		echo json_encode($results);
	}
}
