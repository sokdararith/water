<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class iTransrecord_m extends MY_Model {
	public $_table = "transformer_irecords";
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

	public function sales($transID) {
		$query = $this->db->select('new_reading, prev_reading, created_at')
						  ->from('transformer_records')
						  ->where('transformer_id', $transID)						  
						  ->order_by('created_at', "DESC")
						  ->limit(10)
						  ->get();

		if($query->num_rows() > 0) {
			foreach($query->result() as $row) {
				$data[] = array(
						"usage" => $row->new_reading - $row->prev_reading,
						"month"	=> date('M', strtotime($row->created_at))
					);
			}
			return $data;
		} else {
			return 0;
		}
		
	}
}