<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Credential_m extends MY_Model {
	public $_table 			= "login_credential";
	
	public $before_create 	= array( 'created_at', 'updated_at' );
	public $before_update 	= array( 'updated_at' );

	public function add_role () {

	}

	public function delete_role() {
		//
	}

	public function edit_role() {
		//
	}

	public function get_role_by($id="") {
		$this->db->select('id, name')->from("user_roles")->where('id', $id)->limit(1);
		$row = $this->db->get();

		return $row->result();
	}
}