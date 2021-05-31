<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

Class Users_model extends CI_Model
{
	function __construct()
    {
        parent::__construct();
    }
	
	function validateuser($username,$password)
	{
		$this->db->select("*");
		$this->db->from("users");
		$this->db->where("active", 1);
		$this->db->where("username", $username);
		$this->db->where("password", $password);
		$result = $this->db->get();
        $userdata = $result->result_array();
		// var_dump($userdata);
		// exit();
		return $userdata;
	}

	function manage_user_account($input)
	{
		$date = new DateTime("now", new DateTimeZone('Asia/Kuala_Lumpur') );
		$currdate = $date->format('Y-m-d H:i:s');
		$data = array(
			'employee_no' => "00002",
			'position' => $input['position'],
			'user_lname' => $input['user_lname'],
			'user_fname' => $input['user_fname'],
			'user_mname' => $input['user_mname'],
			'username' => $input['username'],
			'password' => $input['password'],
			'created_date' => $currdate
		);
		
		$this->db->insert('users', $data);

		return array(
			'result'    => 'success', 
			'header'    => 'SUCCESS', 
			'message'   => 'User account has been saved.',
			'redirect'  => base_url(),
		);
	}

	function user_list()
	{
		$this->db->select('employee_no, CONCAT(user_lname, ", ", user_fname, " ", user_mname) AS fullname, `position`, active');
		$this->db->from("users");
		$this->db->where("active", 1);
		$result = $this->db->get();
        $results = $result->result_array();
		// var_dump($userdata);
		// exit();
		return $results;
	}
}
