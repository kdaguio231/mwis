<?php

use PayMaya\API\Payments;
use PayMaya\PayMayaSDK;

defined('BASEPATH') OR exit('No direct script access allowed');
require FCPATH  . '/vendor/autoload.php';

// require_once(DIR_VENDOR . 'PayMaya-PHP-SDK-master/sample/autoload.php');

class Client extends CI_Controller {
	

	function __contsruct()
	{
		parent::__construct();
		$this->load->model("client_model");
		$this->load->helper('url', 'form');	
		$this->load->library('form_validation');
		// $this->load->library('PayMaya-PHP-SDK-master/lib/PayMaya/PayMayaSDK');
		$amount = 0;
		if (!$this->session->userdata('customer_id'))
		{ 
			redirect('/login');
		}
	}

	public function paymayaInit(){
        PayMayaSDK::getInstance()->initPayments("pk-Z0OSzLvIcOI2UIvDhdTGVVfRSSeiGStnceqwUE7n0Ah", "sk-X8qolYjy62kIzEbr0QRK1h4b4KDVHaNcwMYk39jInSl", "SANDBOX");
    }

	public function login()
	{
		$this->session->sess_destroy();	
		
		$this->load->view('client/client_login');
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
				
				$result=$this->client_model->validateuser($this->input->post('username'),$this->input->post('password'));
				
				if (count($result) > 0)
				{
					$data = array(
								'customer_id' 			=> $result[0]['customer_id'],
								'fullname' 			=> $result[0]['customer_fname'].' '.$result[0]['customer_lname'],
								'username'	=> $result[0]['username'],
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
				else{
					$response['login_status'] = 'invalid';
					header("Content-Type: application/json", true);
						$this->output->set_output(print(json_encode($response)));
						exit();
					$this->session->set_userdata('alert','Access Denied');
				}
				
			}
			redirect('/');
		}
		catch (Exception $e) 
		{
			
			$this->session->set_userdata('alert',  $e->getMessage());
			redirect('client/login');
		}
	}

	public function upload_valid_id()
	{
		$date = new DateTime("now", new DateTimeZone('Asia/Kuala_Lumpur') );
		$currdate = $date->format('Y-m-d H:i:s');
		$filedefined = isset($_FILES["validid_image"]["name"]);
		if($filedefined)
		{
			$img = $_FILES["validid_image"]["name"];
			$tmp = $_FILES["validid_image"]["tmp_name"];
			$errorimg = $_FILES["validid_image"]["error"];
			$postedrecord = $this->input->post();
			
			$valid_extensions = array('jpeg', 'jpg', 'png', 'gif', 'bmp' , 'pdf');
			$path = '.upload/';

			$img = $_FILES['validid_image']['name'];
			$tmp = $_FILES['validid_image']['tmp_name'];
			// get uploaded file's extension
			$ext = strtolower(pathinfo($img, PATHINFO_EXTENSION));
			// can upload same image using rand function
			$final_image = rand(1000,1000000).'_img'.$img;

			// check's valid format
			if(in_array($ext, $valid_extensions)) 
			{ 
				
				// $path = $path.strtolower($final_image); 
				$destination_path = getcwd().DIRECTORY_SEPARATOR;
				// $target_path = $destination_path . 'upload/' . basename( $_FILES["validid_image"]["name"]);
				$target_path = $destination_path . 'upload/' . $final_image;
				
				if(move_uploaded_file($tmp,$target_path)) 
				{
					//insert form data in the database
					$data = array(
						'verified_id' => $final_image,
						'customer_lname' => $postedrecord['customer_lname'],
						'customer_fname' => $postedrecord['customer_fname'],
						'customer_mname'=> $postedrecord['customer_mname'],
						'address_house_number'=> $postedrecord['address_house_number'],
						'address_province' => $postedrecord['district'],
						'address_barangay' => $postedrecord['brgy'],
						'occupation' => $postedrecord['occupation'],
						'birthdate' => $postedrecord['birthdate'],
						'date_modified' => $currdate
					);
					$this->db->where('customer_id', $this->session->userdata('customer_id'));
					$this->db->update('customers', $data);
					
				}
				echo 'Success';
				exit();
			} 
			else{
				echo 'invalid';
				exit();
			}
		}
		$postedrecord = $this->input->post();
		// var_dump($postedrecord);
		// exit();
		$data = array(
			'customer_lname' => $postedrecord['customer_lname'],
			'customer_fname' => $postedrecord['customer_fname'],
			'customer_mname'=> $postedrecord['customer_mname'],
			'address_house_number'=> $postedrecord['address_house_number'],
			'address_province' => $postedrecord['district'],
			'address_barangay' => $postedrecord['brgy'],
			'occupation' => $postedrecord['occupation'],
			'birthdate' => $postedrecord['birthdate'],
			'date_modified' => $currdate
		);
		$this->db->where('customer_id', $this->session->userdata('customer_id'));
		$this->db->update('customers', $data);
		
		echo 'Success saved';
		exit();
		

	}

	public function profile()
	{
		if(empty($this->session->userdata('customer_id')))
		{
			redirect('client/login');
		}
		
		$id = $this->session->userdata('customer_id');
		$results = $this->client_model->get_user_array($id);
		$district = $this->client_model->get_district_list();
		$occupation = $this->client_model->get_occupation();
	// var_dump($occupation);
	// exit();
		$data["occupation"] = $occupation;
		$data["district"] = $district;
		$data['details'] = $results;
		$data['mainmenu']='';
		$data['menu']='';
		$this->load->view('includes/client/header', $data);
		$this->load->view('includes/client/sidebar', $data);
		$this->load->view('client/client_profile', $data);
	}
	public function logout()
	{
		$this->session->unset_userdata('access_token');

		$this->session->unset_userdata('userdata');
		// $this->session->unset_userdata('userdata');
		redirect('client/login');
	}

	public function signup()
	{
		$district = $this->client_model->get_district_list();
		$data['district'] = $district;
		$this->load->view('client/signup', $data);
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
			$postform = $this->input->post();
			// var_dump($postform);
			// exit();
			
			$lastname = $postform['user_lname'];
			$firstname = $postform['user_fname'];
			$mname = $postform['user_mname'];
			$bdate = $postform['birthdate'];
			$username = $postform['username'];
			$email = $postform['email_address'];
			$password = $postform['password'];
			$district = $postform['district'];
			$brgy = $postform['brgy'];
 
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
			$user['address_barangay'] = $brgy;
			$user['address_province'] = $district;
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
			$response = "";
		    //sending email
		    if($this->email->send()){
		    	$response = $this->session->set_flashdata('message','Activation code sent to email');
		    }
		    else{
		    	$response = $this->session->set_flashdata('message', $this->email->print_debugger());
 
		    }
			header("Content-Type: application/json", true);
			$this->output->set_output(print(json_encode($response)));
			exit();
        	// redirect('client/login');
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
 
		redirect('client/login');
 
	}

	public function loan_application()
	{
		if(empty($this->session->userdata('customer_id')))
		{
			redirect('client/login');
		}

		$result = $this->client_model->get_customer_status($this->session->userdata('customer_id'));
		$disablebutton = "enable";

		if($result)
		{
			if(($result[0]['loan_release_status'] == 1 || $result[0]['loan_release_status'] == 2) || $result[0]['payment_status'] == 1 || $result[0]['payment_status'] == 3)
			{
				$disablebutton = 'disable';
			}
		}

		$data['buttonstat'] = $disablebutton;
		$data['mainmenu']='';
		$data['menu']='';
		$this->load->view('includes/client/header', $data);
		$this->load->view('includes/client/sidebar', $data);
		$this->load->view('client/loan_application', $data);
	}

	public function loan_and_payment_history()
	{
		if(empty($this->session->userdata('customer_id')))
		{
			redirect('client/login');
		}

		$data['mainmenu']='';
		$data['menu']='';
		$this->load->view('includes/client/header', $data);
		$this->load->view('includes/client/sidebar', $data);
		$this->load->view('client/loan_and_payment', $data);
	}

	public function billing_payment()
	{
		if(empty($this->session->userdata('customer_id')))
		{
			redirect('client/login');
		}
		$date = new DateTime("now", new DateTimeZone('Asia/Kuala_Lumpur') );
		$currdate = $date->format('Y-m-d H:i:s');
		$due_date = $date->format('Y-m-d');
		$paymentId =  "";
		$column = "application_id";
		$where = "customer_id =".$this->session->userdata('customer_id')." AND `application`.`application_status` = 1 AND application.payment_status = 1";
        $results = $this->application_model->getApplication($column, $where);
		$interest = $this->interest_model->getInterestAll();
		
		if(!empty($this->uri->segment(3)))
		{
			$retpaymentId = $this->uri->segment(3);
			$data = array(
				'payment_id' => $retpaymentId,
				'date_modified' => $currdate,
				'amount_paid' => $this->session->userdata('amount'),
				'paid_date' => $currdate,
				'created_date' => $currdate,
				'application_id' => $results[0]['application_id'],
				'interest_rate_id' => $interest[0]['interest_rate']
			);
			$this->db->insert('loan_details', $data);
			
			$getbilling = $this->client_model->get_totalbill($this->session->userdata('customer_id'));
			$total = $getbilling[0]['remittance'];
			if($total == $getbilling[0]['loan_amount'])
			{
				$data_application = array(
					'payment_status' => 2,
					'loan_release_status' => 3,
					'date_updated' => $currdate
				);

				$this->db->where('application_id', $results[0]['application_id']);
				$this->db->where('customer_id', $this->session->userdata('customer_id'));
		
				$this->db->update('application', $data_application);
			}
			
			redirect('client/billing_payment');
		}

		$totalbill_amount = $this->client_model->get_totalbill($this->session->userdata('customer_id'));
		
		$data['remittance'] = $totalbill_amount[0]['remittance'];
		$data['loan_amount'] = $totalbill_amount[0]['loan_amount'];
		$data['balance'] = $totalbill_amount[0]['balance'];
		$data['minimum_amount_due'] = $totalbill_amount[0]['amount_due'];
		$data['application_id'] = "";
		if($results)
		{
			$data['application_id'] = $results[0]['application_id'];
		}
		
		$data['mainmenu']='';
		$data['menu']='';
		$this->load->view('includes/client/header', $data);
		$this->load->view('includes/client/sidebar', $data);
		$this->load->view('client/billing_payment', $data);
	}

	public function apply_loan()
	{
		if(empty($this->session->userdata('customer_id')))
		{
			redirect('client/login');
		}
		$post_formdata = $this->input->post();
        $results = $this->client_model->apply_loan($post_formdata);
		echo json_encode($results);
	}

	public function loan_list()
	{
		$results = $this->client_model->get_customer_status($this->session->userdata('customer_id'));
        echo json_encode($results);
	}

	public function payment_history()
	{
		$results = $this->client_model->get_all_payment_history($this->session->userdata('customer_id'));
        echo json_encode($results);
	}

	public function load_breakdown()
	{
		$results = $this->client_model->get_billing($this->session->userdata('customer_id'));
        echo json_encode($results);
	}

	public function edit_loan_application()
	{
		$post_formdata = $this->input->post();
		$column = "application_id, amount_borrowed, reason_for_loan";
		$where = "application_id =".$post_formdata['id'];
        $results = $this->application_model->getApplication($column, $where);
		echo json_encode($results);
	}

	public function load_brgy()
	{
		
		$district_id = $this->input->post('id');
		$results = $this->client_model->get_barangay_by_district($district_id);
		echo json_encode($results);
	}

	public function cancel_loan_application()
	{
		$post_formdata = $this->input->post();
        $results = $this->client_model->cancel_loan($post_formdata);
		echo json_encode($results);
	}

	public function checkout()
	{
		if(empty($this->session->userdata('customer_id')))
		{
			redirect('client/login');
		}
		$date = new DateTime("now", new DateTimeZone('Asia/Kuala_Lumpur') );
		$currdate = $date->format('Y-m-d H:i:s');
		$due_date = $date->format('Y-m-d');
		
		$post_formdata = $this->input->post();
		$amount = $post_formdata['amount'];

		$userdataarray = array(
			'amount' => $amount
		);
		$this->session->set_userdata($userdataarray);

		$application_id = $post_formdata['application_id'];
		// $totalbill_amount = $this->client_model->get_totalbill($this->session->userdata('customer_id'));
		$random = time() . rand(10*45, 100*98);

		$column = "application_id";
		$where = "application_id =".$application_id." AND `application`.`application_status` = 1 AND application.payment_status = 1";
        $results = $this->application_model->getApplication($column, $where);
		

		$paymentId = "";
		$totamount = array(
			"currency"=> "PHP",
			"value" => $amount
		);
		$itemCheckout = array();
		$itemCheckout["totalAmount"] = $totamount;
		$itemCheckout["requestReferenceNumber"] = $random;
		$itemCheckout["redirectUrl"] = array(
			"success" => base_url()."client/billing_payment/".$random,
			"failure" => base_url()."client/billing_payment/failed".$random,
			"cancel" => base_url()."client/billing_payment/cancelled".$random
			);
		$itemCheckout["metadata"] = array();

		$session = curl_init();
		curl_setopt($session, CURLOPT_URL, "https://pg-sandbox.paymaya.com/payby/v2/paymaya/payments");
		// curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($session, CURLOPT_HEADER, false);
		curl_setopt($session, CURLOPT_HTTPHEADER,  array("Content-Type: application/json", "Authorization: Basic cGstTU9mTkt1M0ZtSE1WSHRqeWpHN3Zocjd2RmV2UmtXeG14WUwxWXE2aUZrNTo="));
		curl_setopt($session, CURLOPT_POST, true);
		curl_setopt($session, CURLOPT_POSTFIELDS, json_encode($itemCheckout, JSON_FORCE_OBJECT));
			
		$response = curl_exec($session);

		$responseArr = json_decode($response);

		curl_close($session);
		
	}
	
}
