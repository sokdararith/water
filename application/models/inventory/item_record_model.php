<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Item_record_model extends MY_Model {
	
    public $before_create = array( 'created_at', 'updated_at' );
    public $before_update = array( 'updated_at'  );
		
	//Get item record with item_receipt_id
	function get_item_record_by_item_receipt_id($item_receipt_id)
	{
		$this->db->select('item_records.*');
		$this->db->from('item_records');
		$this->db->where('item_receipt_id', $item_receipt_id);
		
		$q = $this->db->get();
		
		if ( $q->num_rows() > 0 ) :
			return $q->result();
		endif;		
	} 

	function last_balance_of($id=0) {
		$balance = 0;
		$this->db->select("balance")
				 ->order_by("id", "desc")
				 ->where("item_id", $id)
				 ->limit(1);
		$query = $this->db->get("item_records");
		foreach($query->result() as $r) {
			$balance = $r->balance;
		}
		return $balance;
	}

	function sales_qty($id, $from, $to) {
		$amount = 0;
		$this->db->select("quantity")
				 ->where("item_id", $id)
				 ->where('created_at >=', Date('Y-m-d', strtotime($from)))
				 ->where('created_at <=', Date('Y-m-d', strtotime($to)));
		$query = $this->db->get("item_records");
		if($query->num_rows() > 0) {
			foreach($query->result() as $r) {
				if($r->quantity < 0) {
					$amount += $r->quantity;
				}				
			}
			return abs($amount);
		} else {
			return 0;
		}
		
	}

	function avg_price($id, $from, $to)	{
		$amount = 0;
		$qty = 0;
		$this->db->select("price, quantity")
				 ->where("item_id", $id)
				 ->where('quantity <', 0)
				 ->where('created_at >=', Date('Y-m-d', strtotime($from)))
				 ->where('created_at <=', Date('Y-m-d', strtotime($to)));
		$query = $this->db->get("item_records");
		foreach($query->result() as $r) {
			$amount = $amount + $r->price;
			$qty = $qty + abs($r->quantity);
		}
		if($amount > 0) {
			return $amount/$qty;
		} else {
			return 0;
		}
	} 

	function in($field, $array) {
		$this->db->where_in($field, $array);
		return $this;
	}
}

