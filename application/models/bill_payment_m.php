<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Bill_Payment_m extends MY_Model {

	public $_table = "bill_payments";
	public $before_create = array( 'created_at', 'updated_at' );
	public $before_update = array( 'updated_at' );

	public function amount_paid($arg=0) {
		$this->db->select("amount_paid")
		    	 ->where("bill_id", $arg)
		    	 ->from("bill_payments");
		$amounts = $this->db->get();
		$amount_paid = 0;
		if ( count($amounts->row()) > 0 ) {
			foreach($amounts->result() as $r) {
				$amount_paid = $amount_paid + $r->amount_paid;
			}
		}
		
		return $amount_paid;
	}

	public function amount_paid_by($arg=0) {
		$ids = $this->_bill_by_vendor($arg);
		$this->db->select("amount_paid")
		    	 ->where_in("bill_id", $ids)
		    	 ->from("bill_payments");
		$amounts = $this->db->get();
		$amount_paid = 0;
		if ( count($amounts->row()) > 0 ) {
			foreach($amounts->result() as $r) {
				$amount_paid = $amount_paid + $r->amount_paid;
			}
		}
		
		return $amount_paid;

	}
	private function _bill_by_vendor($vendor = 0) {
		if($vendor > 0) {
			$this->db->select('id')
			 		 ->from('bills')
			 		 ->where('status', 0)
			 		 ->where('vendor_id', $vendor);
			$q = $this->db->get();
			if($q->num_rows() > 0) {
				foreach($q->result() as $r) {
					$ids[] = $r->id;
 				}
 				return $ids;
			} else {
				return FALSE;
			}
		}
	}
}