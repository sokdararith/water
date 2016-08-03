<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); //disallow direct access to this file

require APPPATH.'/libraries/REST_Controller.php';

class Payment_terms extends REST_Controller {	
	public $entity;
	//CONSTRUCTOR
	function __construct() {
		parent::__construct();
		$institute = new Institute();
		$institute->where('name', $this->input->get_request_header('Entity'))->get();
		if($institute->exists()) {
			$conn = $institute->connection->get();
			// $this->entity = $conn->server_name;
			// $this->user = $conn->user;
			// $this->pwd = $conn->password;	
			$this->entity = $conn->inst_database;
		}
	}
	
	//GET 
	function index_get() {
		$filters 	= $this->get("filter")["filters"];		
		$page 		= $this->get('page') !== false ? $this->get('page') : 1;		
		$limit 		= $this->get('limit') !== false ? $this->get('limit') : 100;								
		$sort 	 	= $this->get("sort");		
		$data["results"] = array();
		$data["count"] = 0;

		$obj = new Payment_term(null, $this->entity);

		//Sort
		if(!empty($sort) && isset($sort)){					
			foreach ($sort as $value) {
				$obj->order_by($value["field"], $value["dir"]);
			}
		}
		
		//Filter		
		if(!empty($filters) && isset($filters)){			
	    	foreach ($filters as $value) {
	    		if(!empty($value["operator"]) && isset($value["operator"])){
		    		if($value["operator"]=="where_in"){
		    			$obj->where_in($value["field"], $value["value"]);
		    		}else if($value["operator"]=="or_where_in"){
		    			$obj->or_where_in($value["field"], $value["value"]);
		    		}else if($value["operator"]=="where_not_in"){
		    			$obj->where_not_in($value["field"], $value["value"]);
		    		}else if($value["operator"]=="or_where_not_in"){
		    			$obj->or_where_not_in($value["field"], $value["value"]);
		    		}else if($value["operator"]=="like"){
		    			$obj->like($value["field"], $value["value"]);
		    		}else if($value["operator"]=="or_like"){
		    			$obj->or_like($value["field"], $value["value"]);
		    		}else if($value["operator"]=="not_like"){
		    			$obj->not_like($value["field"], $value["value"]);
		    		}else if($value["operator"]=="or_not_like"){
		    			$obj->or_not_like($value["field"], $value["value"]);
		    		}else if($value["operator"]=="startswith"){
		    			$obj->like($value["field"], $value["value"], "after");
		    		}else if($value["operator"]=="endswith"){
		    			$obj->like($value["field"], $value["value"], "before");
		    		}else if($value["operator"]=="contains"){
		    			$obj->like($value["field"], $value["value"], "both");
		    		}else if($value["operator"]=="or_where"){
		    			$obj->or_where($value["field"], $value["value"]);		    				    		
		    		}else{
		    			$obj->where($value["field"].' '.$value["operator"], $value["value"]);
		    		}
	    		}else{	    			
	    			$obj->where($value["field"], $value["value"]);	    				    			
	    		}
			}									 			
		}		
		
		//Results
		$obj->get_paged_iterated($page, $limit);
		$data["count"] = $obj->paged->total_rows;							

		if($obj->result_count()>0){			
			foreach ($obj as $value) {								
				$data["results"][] = array(
					"id" 				=> $value->id,
					"name" 				=> $value->name,
					"net_due" 			=> $value->net_due,
					"discount_period" 	=> $value->discount_period,
					"discount_percentage" => $value->discount_percentage,
					"is_system" 		=> $value->is_system
				);
			}
		}		

		//Response Data		
		$this->response($data, 200);			
	}
	
	//POST
	function index_post() {
		$models = json_decode($this->post('models'));				
		$data["results"] = array();
		$data["count"] = 0;				
		
		foreach ($models as $value) {
			$obj = new Payment_term(null, $this->entity);
			$obj->name 				= $value->name;
			$obj->net_due 			= $value->net_due;
			$obj->discount_period 	= $value->discount_period;
			$obj->discount_percentage = $value->discount_percentage;
			$obj->is_system 		= $value->is_system;			
			
	   		if($obj->save()){		   		
			   	$data["results"][] = array(
			   		"id" 				=> $obj->id,
					"name" 				=> $obj->name,
					"net_due" 			=> $obj->net_due,
					"discount_period" 	=> $obj->discount_period,
					"discount_percentage" => $obj->discount_percentage,
					"is_system" 		=> $value->is_system
			   	);
		    }	
		}
		
		$data["count"] = count($data["results"]);
		$this->response($data, 201);		
	}
	
	//PUT
	function index_put() {
		$models = json_decode($this->put('models'));
		$data["results"] = array();
		$data["count"] = 0;

		foreach ($models as $value) {			
			$obj = new Payment_term(null, $this->entity);
			$obj->get_by_id($value->id);

			$obj->name 				= $value->name;
			$obj->net_due 			= $value->net_due;
			$obj->discount_period 	= $value->discount_period;
			$obj->discount_percentage = $value->discount_percentage;
			$obj->is_system 		= $value->is_system;		

			if($obj->save()){				
				//Results
				$data["results"][] = array(
					"id" 				=> $obj->id,
					"name" 				=> $obj->name,
					"net_due" 			=> $obj->net_due,
					"discount_period" 	=> $obj->discount_period,
					"discount_percentage" => $obj->discount_percentage,
					"is_system" 		=> $value->is_system
				);						
			}
		}
		$data["count"] = count($data["results"]);

		$this->response($data, 200);
	}
	
	//DELETE
	function index_delete() {
		$models = json_decode($this->delete('models'));

		foreach ($models as $key => $value) {
			$obj = new Payment_term(null, $this->entity);
			$obj->where("id", $value->id)->get();
			
			$data["results"][] = array(
				"data"   => $value,
				"status" => $obj->delete()
			);							
		}

		//Response data
		$this->response($data, 200);
	}
	
}
/* End of file payment_methods.php */
/* Location: ./application/controllers/api/payment_methods.php */