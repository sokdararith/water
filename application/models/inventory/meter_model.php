<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Meter_model extends MY_Model {
	
    public $before_create = array( 'created_at', 'updated_at' );
    public $before_update = array( 'updated_at' );

    //Where
	function where($field, $value) {
		$this->db->where($field, $value);
		return $this;
	}

	//Where in	
	function where_in($field, $value) {
		$this->db->where_in($field, $value);		
		return $this;
	}

	//Where not in	
	function where_not_in($field, $value) {
		$this->db->where_not_in($field, $value);		
		return $this;
	}

	//Join transformer
    function join_transformer(){
    	$this->db->join('transformers', 'transformers.id = meters.transformer_id');
    	return $this;
    }

    //Join people
    function join_people(){
    	$this->db->join('people', 'people.id = meters.customer_id');
    	return $this;
    }

    //Join electicity box
    function join_electricity_box(){
    	$this->db->join('electricity_boxes', 'electricity_boxes.id = meters.electricity_box_id');
    	return $this;
    }
	
	//Get customer meter with type
	function get_customer_meter_with_type($customer_id=0, $status=-1, $parent_id=-1){		
		$this->db->select('meters.*, (items.name) AS typeName, electricity_boxes.box_no, 
						   electricity_boxes.electricity_pole_id, electricity_poles.transformer_id');
		$this->db->where('meters.customer_id', $customer_id);
		
		if($status==0){
			$this->db->where('meters.status', 0);
		}elseif ($status==1) {
			$this->db->where('meters.status', 1);
		}

		if($parent_id==0){
			$this->db->where('meters.parent_id', 0);
		}elseif ($parent_id==1) {
			$this->db->where('meters.parent_id>', 0);
		}		
		$this->db->join('items', 'items.id = meters.item_id');		
		$this->db->join('electricity_boxes', 'electricity_boxes.id = meters.electricity_box_id');
		$this->db->join('electricity_poles', 'electricity_poles.id = electricity_boxes.electricity_pole_id');		
	
		return $this;	
	}

	//Get customer meter by area id
	function get_customer_meter_by_area_id($transformer_id=0){		
		$this->db->select('meters.id, meters.meter_no, meters.customer_id, meters.parent_id, meters.tariff_id, 
						CONCAT(people.surname, " ", people.name) AS fullname, (items.name) AS typeName', FALSE);
		$this->db->where('meters.status', 1);
		$this->db->where('people.status', 1);
		$this->db->where('people.transformer_id', $transformer_id);
		$this->db->where('people_types.parent_id', 1);
		$this->db->join('people', 'people.id = meters.customer_id');		
		$this->db->join('people_types', 'people_types.id = people.people_type_id');
		$this->db->join('items', 'items.id = meters.item_id');
					
		return $this;	
	}

	//Get customer meter by meter number
	function get_customer_meter_by_meter_no($meter_no=''){		
		$this->db->select('meters.*, CONCAT(people.surname, " ", people.name) AS fullname, 
						(items.name) AS typeName', FALSE);
		$this->db->where('meters.meter_no', $meter_no);
		$this->db->join('people', 'people.id = meters.customer_id');		
		$this->db->join('items', 'items.id = meters.item_id');
					
		return $this;	
	}
		
	
}