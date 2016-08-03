<?php defined('BASEPATH') OR exit('No direct script access allowed');

class People_model extends MY_Model {
	
	public $_table = 'people';
	
	public $before_create = array( 'created_at', 'updated_at' );
    public $before_update = array( 'updated_at' );
	
	//Get people by type
	function get_people_by_type($parent_id){
		$this->db->select('people.*, CONCAT(people.surname, " ", people.name) AS fullname, people_types.name AS typeName,
						   amperes.ampere, phases.phase, voltages.voltage, tariff_plans.name AS tariff, maintenances.name AS maintenance, exemptions.name AS exemption', FALSE);
		$this->db->from('people');
		$this->db->join('people_types', 'people_types.id = people.people_type_id');
		$this->db->join('amperes', 'amperes.id = people.ampere_id');
		$this->db->join('phases', 'phases.id = people.phase_id');
		$this->db->join('voltages', 'voltages.id = people.voltage_id');
		$this->db->join('tariff_plans', 'tariff_plans.id = people.tariff_plan_id');
		$this->db->join('maintenances', 'maintenances.id = people.maintenance_id');
		$this->db->join('exemptions', 'exemptions.id = people.exemption_id');
		$this->db->where('people_types.parent_id', $parent_id);
		
		$q = $this->db->get();
		
		if ( $q->num_rows() > 0 ) :
			return $q->result();
		endif;		
	}

	//Get people by type
	function people_by_type($parent_id=1){
		$this->db->select('people.*, CONCAT(people.surname, " ", people.name) AS fullname, people_types.name AS typeName', FALSE);
		$this->db->join('people_types', 'people_types.id = people.people_type_id');		
		$this->db->where('people_types.parent_id', $parent_id);
		
		return $this;
	}
	
	//Get people by parameter
	function get_people_by_parameter($parent_id=1, $para='', $transformer_id=0){		
		$this->db->select('people.*, CONCAT(people.surname, " ", people.name) AS fullname, people_types.name AS typeName,
						   amperes.ampere, phases.phase, voltages.voltage, tariff_plans.name AS tariff, maintenances.name AS maintenance, exemptions.name AS exemption', FALSE);
		$this->db->join('people_types', 'people_types.id = people.people_type_id');
		$this->db->join('amperes', 'amperes.id = people.ampere_id');
		$this->db->join('phases', 'phases.id = people.phase_id');
		$this->db->join('voltages', 'voltages.id = people.voltage_id');
		$this->db->join('tariff_plans', 'tariff_plans.id = people.tariff_plan_id');
		$this->db->join('maintenances', 'maintenances.id = people.maintenance_id');
		$this->db->join('exemptions', 'exemptions.id = people.exemption_id');
		$this->db->where('people_types.parent_id', $parent_id);
		if($para != ''){			
			$this->db->where('people.number LIKE', $para);
			$this->db->or_where('people.surname LIKE', $para);
			$this->db->or_where('people.name LIKE', $para);
			$this->db->or_where('people.id LIKE', $para);			
		}
		if($transformer_id>0){
			$this->db->where('people.transformer_id', $transformer_id);
		}

		return $this;
	}
		
	//Like	
	function like($field, $value=NULL, $wildcard='none') {
		if(is_array($field)) {
			$this->db->like($field, $wildcard);
		} else {
			$this->db->like($field, $value, $wildcard);
		}	
				
		return $this;
	}

	//Or Like
	function or_like($field, $value=NULL, $wildcard='none') {
		if(is_array($field)) {
			$this->db->or_like($field, $wildcard);
		} else {
			$this->db->or_like($field, $value, $wildcard);
		}	
				
		return $this;
	}

	//Havning
	function having($field, $value) {
		$this->db->having($field, $value);
		return $this;
	}

	//Where
	function where($field, $value) {
		$this->db->where($field, $value);
		return $this;
	}

	//Or Where
	function or_where($field, $value) {
		$this->db->or_where($field, $value);
		return $this;
	}

	//Where in	
	function where_in($field, $value) {
		$this->db->where_in($field, $value);		
		return $this;
	}

	//Type
	function type($type=1){        
        $ids = $this->_peopleType($type);
        $this->db->where_in('people_type_id', $ids);
        return $this;
    }

	//Update balance as batch
    function balance_batch($data){
    	foreach($data as $row) {
			$query  =  array("balance" => $row->balance);
			$this->db->where("id", $row->id)->update('people', $query);											
		}
    	return $this->db->affected_rows();  
    }

    //Check existing number
    function existing_number($number=""){
    	$this->db->select('number');
    	$this->db->where('number', $number);
        $query = $this->db->get('people')->num_rows();
        if($query == 0){
        	return FALSE;        	
        }else{
        	return TRUE;
        } 
    }
    
	//by Rith
	public function customer($type ="",$value = "") {
		$parent_id = $this->_peopleType();
		if($value!=="") {
			$this->db->like($type, $value);
			$this->db->where_in('people_type_id', $parent_id);
		} else {
			$this->db->where_in('people_type_id', $parent_id);
		}
		
		return $this;
	}

	public function vendor() {
		$parent_id = $this->_peopleType(2);
		// $this->db->where("status", $type);
		$this->db->where_in('people_type_id', $parent_id);
		return $this;
	}	

	private function _peopleType($id= 1) {
		//the default id is one which is customer
		$parent_ids = array();
		$this->db->select("id")
				 ->from("people_types")
				 ->where("parent_id", $id);
		$res 	= $this->db->get();
		foreach($res->result() as $r) {
			$parent_ids[] = $r->id;
		}
		return $parent_ids;
	}

	private function _days_overdue($billId, $date) {
		$this->db->select("due_date");
		$this->db->from("journals");
		$this->db->where("id", $billId);
		$this->db->where("due_date <=", Date('Y-m-d', strtotime($date)));
		$this->db->limit(1);
		$query = $this->db->get();
		if($query->num_rows() > 0) {
			$due_date = new DateTime(date($query->row()->due_date));
			$as_of 	  = new DateTime(date($date));
			if($due_date < $as_of) {
				$dDiff 	  = $due_date->diff($as_of);
				return $dDiff->days;
			}	
		}
		return FALSE;

	}

	private function _bill_payment($billID) {
		$payment_made = 0;
		$this->db->select("amount_paid");
		$this->db->from("bill_payments");
		$this->db->where("bill_id", $billID);
		$query = $this->db->get();

		if($query->result() > 0) {
			foreach($query->result() as $row) {
				$payment_made += $row->amount_paid;
			}
		}

		return $payment_made;
	}

	public function vendor_aging_report($vendorID, $as_of, $class) {
		$age = array(
				"current"=>0,
				"in_thirty"=>0,
				"in_sixty"=>0,
				"in_ninety"=>0,
				"over_ninety"=>0
			);
		if(isset($vendorID)) {

			$this->db->from("journals");
			$this->db->where("status", 0);
			if($class !== "") {
				$this->db->where('class_id', $class);
			} 
			// else {
			// 	$this->db->where('class_id', $class);
			// }
			$this->db->where("people_id", $vendorID);
			$query = $this->db->get();

			if($query->result() > 0) {
				foreach( $query->result() as $row) {
					$days = $this->_days_overdue($row->id, $as_of);
					
					if ($days > 1 || $days === 1 && $days < 31) {
						$age['in_thirty'] += $row->amount_billed - $this->_bill_payment($row->id);
					}
					if ($days > 30 && $days < 61) {
						$age['in_sixty'] += $row->amount_billed - $this->_bill_payment($row->id);
					}
					if ($days > 60 && $days < 91) {
						$age['in_ninety'] += $row->amount_billed - $this->_bill_payment($row->id);
					}
					if ($days > 90) {
						$age['over_ninety'] += $row->amount_billed - $this->_bill_payment($row->id);
					} 
					if ($days < 1) {
						$age['current'] += $row->amount_billed - $this->_bill_payment($row->id);
					}
 
				}
			}
		}
		return $age;
	}
	
}