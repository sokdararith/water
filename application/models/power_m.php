<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Power_m extends MY_Model {
	public $_table = "power_purchases";
	public $before_create = array( 'created_at', 'updated_at' );
	public $before_update = array( 'updated_at' );

	public function between_dates($from = "", $to = "") {
		if($from != "" && $to != "") {
			$this->db->where('date_recorded >= ', $from)
				 ->where('date_recorded <= ', $to);
		}elseif ($from != "" && $to == "") {
			$this->db->where('date_recorded >= ', $from);
		}
		
		return $this;
	}	
}