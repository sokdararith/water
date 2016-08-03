<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class grn_model extends MY_Model {
	public $before_create = array( 'created_at', 'updated_at' );
	public $before_update = array( 'updated_at' );

	/**
	* @param is string of fields to be displayed
	* 
	*/
	public function select($args) {
		$this->db->select($arg);
		return $this;
	}
}