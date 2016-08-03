<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Item_model extends MY_Model {
	
    public $before_create = array( 'created_at', 'updated_at' );
    public $before_update = array( 'updated_at' );
		
    function get_item_cost($id) {
    	$this->db->select("cost")
    			 ->where('id', $id)
    			 ->limit(1);
    	$query = $this->db->get("items");
        $cost = 0;
    	foreach($query->result() as $r) {
 			$cost = $r->cost;
    	}
    	return $cost;
    }

    function where_in($field, $value){        
        $this->db->where_in($field, $value);
        return $this;
    }

    function where_not_in($field, $value){        
        $this->db->where_not_in($field, $value);
        return $this;
    }

    function item_type($id){
        $this->db->select('item_type_id');
        $this->db->where('id', $id);        
        $query = $this->db->get('items');

        if($query->num_rows()>0){
            return $query->row()->item_type_id;
        }else{
            return '0';
        }
    }
    
    function get_quantity($item_id) {
    	$this->db->select("quantity")
    			 ->where("id", $item_id)
    			 ->limit(1);
    	$query = $this->db->get("items");
    	if($query->num_rows() > 0) {
    		$row = $query->row();
    		//return $row->quanity;
    		return $row->quantity;
    	} else {
    		return 0;
    	}
    }
    
    function select($fields) {
        $this->db->select($fields);
        return $this;
    }
}