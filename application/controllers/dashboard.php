<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	function __construct()
	{	
		parent::__construct();
		// print_r($this->session->all_userdata());
		// exit();
		if (!$this->session->userdata('user_id'))
		{ 
			redirect('/');
		}
	}
	
	
	
	public function index()
	{
		// echo 'logged in';
		// exit();
		// $data=$this->data;
		$data['mainmenu']='';
		$data['menu']='';
		$this->load->view('includes/header',$data);
		$this->load->view('includes/sidebar',$data);
		$this->load->view('dashboard/home');
		$this->load->view('includes/footer');
	}
	
	
}
