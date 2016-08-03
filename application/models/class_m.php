<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Class_m extends MY_Model {
	public $before_create = array( 'created_at', 'updated_at' );
	public $before_update = array( 'updated_at' );

	public function group_by($arg) {
		$this->db->group_by($arg);
		return $this;
	}
}

/* End of file bill_model.php */
/* Location: ./application/models/bill_model.php */