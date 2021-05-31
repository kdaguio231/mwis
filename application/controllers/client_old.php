<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Client_old extends CI_Controller {
	function __contsruct()
	{
		parent::__construct();
		$this->load->model("client_model");

		if (!$this->session->userdata('user_id'))
		{ 
			redirect('/login');
		}
	}

	public function login()
	{
		$this->session->sess_destroy();	
		include_once APPPATH . "libraries/vendor/autoload.php";
		$google_client = new Google_Client();
		$google_client->setClientId('1018815963423-aq73qoa1l887jndlfvlqcqgm7m18hpfr.apps.googleusercontent.com');
		$google_client->setClientSecret('cdV2ncFkDcszAeD1QgZN959T');
		$google_client->setRedirectUri(base_url()."client/client_dashboard");

		$google_client->addScope('email');
		$google_client->addScope('profile');

		if(isset($_GET["code"]))
		{
			$token = $google_client->fetchAccessTokenWithAuthCode($_GET["code"]);
			if(!isset($token["error"]))
			{
				$google_client->setAccessToken($token['access_token']);
				$this->session->userdata('access_token', $token["access_token"]);

				$google_service = new Google_Service_Oauth2($google_client);
				$data = $google_service->userinfo->get();
				$current_datetime = date('Y-m-d H:i:s');

				if($this->client_model->isRegistered($data["id"]))
				{
					//update data
					$user_data = array(
						'customer_fname' => $data["given_name"],
						'customer_lname' => $data["family_name"],
						'email_address' => $data["email"],
						'date_modified' => $current_datetime
					);
					$this->client_model->update_user_data($user_data, $data["id"]);
				}
				else{
					// insert data
					$user_data = array(
						'login_oauth_uid' => $data["id"],
						'customer_fname' => $data["given_name"],
						'customer_lname' => $data["family_name"],
						'email_address' => $data["email"],
						'created_date' => $current_datetime
					);
					$this->client_model->insert_user_data($user_data);
				}
				$this->session->set_userdata('user_data', $user_data);
			}
		}
		// var_dump($this->session->userdata());
		// exit();
		$login_button = '';
		if(!$this->session->userdata('access_token'))
		{
			$login_button = '<a href="'.$google_client->createAuthUrl().'"><img width="70%" src="'.base_url().'assets/images/sign_in_with_google.png" /></a>';
			$data['login_button'] = $login_button;
   			$this->load->view('client/client_login', $data);
		}
		else{
			$this->load->view('client/client_login', $data);
		}
	}

	public function client_dashboard()
	{
		$data['mainmenu']='';
		$data['menu']='';
		$this->load->view('includes/client/header', $data);
		$this->load->view('includes/client/sidebar', $data);
		$this->load->view('client/client_dashboard');
	}
	public function logout()
	{
		$this->session->unset_userdata('access_token');

		$this->session->unset_userdata('user_data');
		$this->session->unset_userdata('user_data');
		redirect('client/login');
	}

	public function signup()
	{
		$this->load->view('client/signup');
	}

	public function register(){
		// $this->form_validation->set_rules('user_fname', 'First Name', 'max_length[250]|required');
		// $this->form_validation->set_rules('user_lname', 'Last Name', 'max_length[250]|required');
		// $this->form_validation->set_rules('email', 'Email', 'valid_email|required');
        // $this->form_validation->set_rules('password', 'Password', 'required|min_length[7]|max_length[30]');
        // $this->form_validation->set_rules('password_confirm', 'Confirm Password', 'required|matches[password]');
	

        // if ($this->form_validation->run() == FALSE) { 
        //  	$this->load->view('client/signup');
		// }
		// else{
			//get user inputs
			$lastname = $this->input->post('user_lname');
			$firstname = $this->input->post('user_fname');
			$mname = $this->input->post('user_mname');
			$bdate = $this->input->post('birthdate');
			$username = $this->input->post('username');
			$email = $this->input->post('email_address');
			$password = $this->input->post('password');
 
			//generate simple random code
			$set = '123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
			$code = substr(str_shuffle($set), 0, 12);
 
			//insert user to users table and get id

			$user['customer_lname'] = $lastname;
			$user['customer_fname'] = $firstname;
			$user['customer_mname'] = $mname;
			$user['birthdate'] = $bdate;
			$user['username'] = $username;
			$user['password'] = $password;
			$user['email_address'] = $email;
			$user['verified'] = 0;
			$user['verification_code'] = $code;
			$id = $this->client_model->insert_user_data($user);
 
			//set up email
			$config = array(
		  		'protocol' => 'smtp',
		  		'smtp_host' => 'ssl://smtp.googlemail.com',
		  		'smtp_port' => 465,
		  		'smtp_user' => 'trixie.ericson@gmail.com', // change it to yours
		  		'smtp_pass' => 'Freestyle231', // change it to yours
		  		'mailtype' => 'html',
		  		'charset' => 'iso-8859-1',
		  		'wordwrap' => TRUE
			);
 
			$message = 	"
						<html>
						<head>
							<title>Verification Code</title>
						</head>
						<body>
							<h2>Thank you for Registering.</h2>
							<p>Your Account:</p>
							<p>Email: ".$email."</p>
							<p>Password: ".$password."</p>
							<p>Please click the link below to activate your account.</p>
							<h4><a href='".base_url()."client/activate/".$id."/".$code."'>Activate My Account</a></h4>
						</body>
						</html>
						";
 
		    $this->load->library('email', $config);
		    $this->email->set_newline("\r\n");
		    $this->email->from($config['smtp_user']);
		    $this->email->to($email);
		    $this->email->subject('Signup Verification Email');
		    $this->email->message($message);
 
		    //sending email
		    if($this->email->send()){
		    	$this->session->set_flashdata('message','Activation code sent to email');
		    }
		    else{
		    	$this->session->set_flashdata('message', $this->email->print_debugger());
 
		    }
 
        	redirect('register');
		// }
 
	}

	public function activate(){
		$id =  $this->uri->segment(3);
		$code = $this->uri->segment(4);
		$date = new DateTime("now", new DateTimeZone('Asia/Kuala_Lumpur') );
		$currdate = $date->format('Y-m-d H:i:s');
		//fetch user details
		$user = $this->client_model->getUser($id);
 
		//if code matches
		if($user['verification_code'] == $code){
			//update user active status
			$data['verified'] = 1;
			$data['date_modified'] = $currdate;
			$query = $this->client_model->activate($data, $id);
 
			if($query){
				$this->session->set_flashdata('message', 'User activated successfully');
			}
			else{
				$this->session->set_flashdata('message', 'Something went wrong in activating account');
			}
		}
		else{
			$this->session->set_flashdata('message', 'Cannot activate account. Code didnt match');
		}
 
		redirect('client/register');
 
	}
}
