<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Meter_record_model extends MY_Model {
	
    public $before_create = array( 'created_at', 'updated_at' );
    public $before_update = array( 'updated_at' );

    	
	//Get usage average
	function avg($meter_id=0) {		
		$this->db->select("prev_reading, new_reading, new_round");
		$this->db->from('meter_records');
		$this->db->limit(3);
		$this->db->order_by("id", "desc");
		$this->db->where('meter_id', $meter_id);
		$query = $this->db->get();
		
		$avg = 0;
		$counter = 0;
		$usage = 0;		
		if($query->num_rows() > 0 ) {
			foreach($query->result() as $row) {
				$counter ++;					
				$new_read = $row->new_reading;
				$pre_read = $row->prev_reading;
								
				//New round 9999
				if($row->new_round > 0){
					$new_read += 10000;					
				}				
				$usage += ($new_read - $pre_read);				
			}
			//Find avg
			if($counter>0){
				$avg = ($usage / $counter);
			}			
		}
					
		return $avg;	
	}

	//Min	
	function min($field) {
		$this->db->select_min($field);
		
		return $this;
	}

	//Max	
	function max($meter_id) {
		$this->db->select_max('id');
		$this->db->where('meter_id', $meter_id);		
		$query = $this->db->get('meter_records');

		return $query->row()->id>0 ? $query->row()->id : 0;
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

	//Group by	
	function group_by($field) {
		$this->db->group_by($field);		
		return $this;
	}

	//Distinct	
	function distinct($field) {
		$this->db->distinct($field); 		
		return $this;
	}

	//Join select with meter
	function join_select_meter(){
		$this->db->select('meter_records.id AS meter_record_id, meter_records.*, meters.*');
		$this->db->join('meters', 'meters.id = meter_records.meter_id');
		return $this;
	}

	//Join meter
	function join_meter(){
		$this->db->join('meters', 'meters.id = meter_records.meter_id');
		return $this;
	}

	//Having
	function having($field, $value) {
		$this->db->having($field, $value);
		return $this;
	}

	//Sum
	function sum($field){
		$this->db->select_sum($field);
		return $this;
	}

	//Get usage by meter id
	function active_usage($meter_id=0, $invoice_id=0){		
		$this->db->select("prev_reading, new_reading, new_round");
		$this->db->from('meter_records');
		$this->db->where('invoice_id', $invoice_id);
		$this->db->where('meter_id', $meter_id);
		$query = $this->db->get();
		
		$usage = 0;
		if($query->num_rows() > 0 ) {
			foreach($query->result() as $row) {								
				$new_read = $row->new_reading;
				$pre_read = $row->prev_reading;
								
				//New round 9999
				if($row->new_round > 0){
					$new_read += 10000;					
				}				
				$usage += ($new_read - $pre_read);				
			}					
		}
					
		return $usage;	
	}

	//Get reactive usage by meter id
	function reactive_usage($meter_id=0, $invoice_id=0){		
		$this->db->select("reactive_prev_reading, reactive_new_reading, reactive_new_round");
		$this->db->from('meter_records');
		$this->db->where('invoice_id', $invoice_id);
		$this->db->where('meter_id', $meter_id);
		$query = $this->db->get();
		
		$usage = 0;
		if($query->num_rows() > 0 ) {
			foreach($query->result() as $row) {								
				$new_read = $row->reactive_new_reading;
				$pre_read = $row->reactive_prev_reading;
								
				//New round 9999
				if($row->reactive_new_round > 0){
					$new_read += 10000;					
				}				
				$usage += ($new_read - $pre_read);				
			}					
		}
					
		return $usage;	
	}

	//Get min reading by meter id
	function min_active_reading($meter_id=0){
		$this->db->select_min('prev_reading', 'minRead');
		$this->db->from('meter_records');		
		$this->db->where('invoice_id', 0);
		$this->db->where('meter_id', $meter_id);
		$query = $this->db->get();

		$min = 0;
		if($query->num_rows() > 0 ) {
			foreach($query->result() as $row) {								
				$min = $row->minRead;							
			}					
		}					
		return $min;
	}	

	//Get reactive min reading by meter id
	function min_reactive_reading($meter_id=0){
		$this->db->select_min('reactive_prev_reading', 'minRead');
		$this->db->from('meter_records');		
		$this->db->where('invoice_id', 0);
		$this->db->where('meter_id', $meter_id);
		$query = $this->db->get();

		$min = 0;
		if($query->num_rows() > 0 ) {
			foreach($query->result() as $row) {								
				$min = $row->minRead;							
			}					
		}					
		return $min;
	}

	//Get meter record by customer id
	function meter_record_by_customer($customer_id=0){		
		$this->db->select("meter_records.*, meters.meter_no");		
		$this->db->join('meters', 'meters.id = meter_records.meter_id');		
		$this->db->where('meter_records.invoice_id', 0);
		$this->db->where('meters.parent_id', 0);
		$this->db->where('meters.customer_id', $customer_id);				
		
		return $this;	
	}
	
	//Update batch	
    function update_batch($data){
    	foreach($data as $row) {
			$query  =  array("invoice_id" => $row->invoice_id);
			$this->db->where("id", $row->id)->update('meter_records', $query);											
		}
    	return $this->db->affected_rows();
    }	
}