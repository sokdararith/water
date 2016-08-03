<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Item_receipt_model extends MY_Model {
	
    public $before_create = array( 'created_at', 'updated_at' );
    public $before_update = array( 'updated_at'  );
		
		
	//Get item receipt with receipt_type
	function get_item_receipt_by_receipt_type($receipt_type)
	{
		$this->db->select('item_receipts.*');
		$this->db->from('item_receipts');
		$this->db->where('receipt_type', $receipt_type);
		
		$q = $this->db->get();
		
		if ( $q->num_rows() > 0 ) :
			return $q->result();
		endif;		
	}   	    	 
}

