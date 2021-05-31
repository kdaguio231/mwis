<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {
	function __contsruct()
	{
		parent::__construct();
		$this->load->model('users_model');

	}

	public function signup()
	{
		$this->load->view('users/signup');
	}

	public function validation()
	{
		// var_dump($this->input->post());
		// exit();
		$results = $this->users_model->manage_user_account( $this->input->post() );
        echo json_encode($results);
	}

	
}
