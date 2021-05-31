<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

Class Interest_model extends CI_Model
{
	function __construct()
    {
        parent::__construct();
		
    }

	public function getInterestAll()
	{
		$this->db->select("*");
		$this->db->from("interest");
		$result = $this->db->get();
		$result_set = $result->result_array();
		return $result_set;
	}

	public function getInterest($column, $where=null)
	{
		$this->db->select($column);
		$this->db->from("interest");
		if($where != null)
		{
			$this->db->where($where);
		}
		$this->db->order_by("interest_id","DESC");

		$result = $this->db->get();
        $result_set = $result->result_array();
		return $result_set;
	}

	public function getInterestJoin($column, $table2, $joinOn, $joinType, $where=null)
	{
		$this->db->select($column);
		$this->db->from("interest");
		$this->db->join($table2, $joinOn, $joinType );
		if($where != null)
		{
			$this->db->where($where);
		}
		
		$result = $this->db->get();
        $result_set = $result->result_array();
		return $result_set;
	}

	public function insertInterestDetails($input)
	{

		$interestdetails = array(
			'interest_rate' => $input["interest_rate"],
			'interest_description' =>  $input["interest_description"],
			'active' => 0,
		);

		$this->db->insert('interest', $interestdetails);
	}

	public function updateInterestDetails($input)
	{
		$date = new DateTime("now", new DateTimeZone('Asia/Kuala_Lumpur') );
		$currdate = $date->format('Y-m-d H:i:s');
		$data = array(
			'interest_rate' => $input['interest_rate'],
			'interest_description' => $input['interest_description'],
			'active' => 0,
			'date_modified' => $currdate
		);
		$this->db->where('interest_id', $input['interest_id']);
		$this->db->update('interest', $data);

		return $input['interest_id'];
	}
	
}
