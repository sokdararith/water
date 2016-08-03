<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Employee_m extends MY_Model {
		
	public $before_create = array( 'created_at', 'updated_at' );
	public $before_update = array( 'updated_at' );
	
	function active() {
		$this->db->where("exited", 0);
		return $this;
	}

	function like($field, $value) {
		$this->db->or_like($field, $value);
		return $this;
	}

	function or_like($field, $value) {
		$this->db->or_like($field, $value);
		return $this;
	}

	function user_company() {
		$this->db->select('company_id');
		return $this;
	}
}