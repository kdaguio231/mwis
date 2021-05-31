<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Site extends CI_Controller {
	function __contsruct()
	{
		parent::__construct();
		$this->load->model('users_model');

	}

	public function index()
	{
		$this->session->sess_destroy();	
		
		$this->load->view('system_login');
	}

	public function validation()
	{
		try
		{
			$this->form_validation->set_rules('username', 'Username', 'trim|required|xss_clean');
			$this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');
			if ($this->form_validation->run() == FALSE)
			{
				throw new Exception(validation_errors());
			}
			
			if ($this->input->post('btnSignIn'))
			{
				
				$result=$this->users_model->validateuser($this->input->post('username'),$this->input->post('password'));
				
				if ($result)
				{
					$data = array(
								'user_id' 			=> $result[0]['user_id'],
								'fullname' 			=> $result[0]['user_fname'].' '.$result[0]['user_lname'],
								'empcode' 			=> $result[0]['employee_no']
						);
					$this->session->set_userdata($data);
					$response['login_status'] = 'success';
					// var_dump($data);
					// exit();
					header("Content-Type: application/json", true);
					$this->output->set_output(print(json_encode($response)));
					exit();
					// redirect('member/');
				}
				$this->session->set_userdata('alert','Access Denied');
			}
			redirect('/');
		}
		catch (Exception $e) 
		{
			var_dump("error heere");
				exit();
			$this->session->set_userdata('alert',  $e->getMessage());
			redirect('/');
		}
	}

	public function logout()
	{
		$user_data = $this->session->all_userdata();
		// var_dump($user_data);
		// exit();
        foreach ($user_data as $key => $value) {
            if ($key != 'session_id' && $key != 'ip_address' && $key != 'user_agent' && $key != 'last_activity') {
                $this->session->unset_userdata($key);
            }
        }
		$this->session->sess_destroy();
		redirect('/');
	}

}
