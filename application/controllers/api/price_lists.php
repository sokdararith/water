<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); //disallow direct access to this file

require APPPATH.'/libraries/REST_Controller.php';

class Price_lists extends REST_Controller {	
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

		$obj = new Price_list(null, $this->entity);		

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

		//Result		
		$obj->get_paged_iterated($page, $limit);
		$data["count"] = $obj->paged->total_rows;				

		if($obj->result_count()>0){			
			foreach ($obj as $value) {							
				$data["results"][] = array(
					"id" 				=> $value->id,
					"currency_id" 		=> $value->currency_id,
					"item_id" 			=> $value->item_id,
					"assembly_id" 		=> $value->assembly_id,
					"measurement_id" 	=> $value->measurement_id,
					"quantity" 			=> intval($value->quantity),
					"price" 			=> floatval($value->price),
					"unit_value" 		=> floatval($value->unit_value),

					"currency" 			=> $value->currency->get_raw()->result(),
					"measurement" 		=> $value->measurement->get()->name					
				);
			}
		}

		//Response Data		
		$this->response($data, 200);		
	}
	
	//POST
	function index_post() {
		$models = json_decode($this->post('models'));

		foreach ($models as $value) {
			$obj = new Price_list(null, $this->entity);			
			$obj->currency_id 		= $value->currency_id;
			$obj->item_id 			= $value->item_id;
			$obj->assembly_id 		= isset($value->assembly_id)?$value->assembly_id:0;			
			$obj->measurement_id 	= $value->measurement_id;
			$obj->quantity 		 	= isset($value->quantity)?$value->quantity:0;
			$obj->price 			= $value->price;
			$obj->unit_value 		= $value->unit_value;

			if($obj->save()){				
				//Respsone
				$data["results"][] = array(
					"id" 				=> $obj->id,
					"currency_id" 		=> $obj->currency_id,
					"item_id" 			=> $obj->item_id,
					"assembly_id" 		=> $obj->assembly_id,
					"measurement_id" 	=> $obj->measurement_id,
					"quantity" 			=> intval($obj->quantity),
					"price" 			=> floatval($obj->price),
					"unit_value" 		=> floatval($obj->unit_value),

					"currency" 			=> $obj->currency->get_raw()->result(),
					"measurement" 		=> $obj->measurement->get()->name
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
			$obj = new Price_list(null, $this->entity);
			$obj->get_by_id($value->id);

			$obj->currency_id 		= $value->currency_id;
			$obj->item_id 			= $value->item_id;			
			$obj->assembly_id 		= isset($value->assembly_id)?$value->assembly_id:0;			
			$obj->measurement_id 	= $value->measurement_id;
			$obj->quantity 		 	= isset($value->quantity)?$value->quantity:0;
			$obj->price 			= $value->price;
			$obj->unit_value 		= $value->unit_value;

			if($obj->save()){				
				//Results
				$data["results"][] = array(
					"id" 				=> $obj->id,
					"currency_id" 		=> $obj->currency_id,
					"item_id" 			=> $obj->item_id,
					"assembly_id" 		=> $obj->assembly_id,
					"measurement_id" 	=> $obj->measurement_id,
					"quantity" 			=> intval($obj->quantity),
					"price" 			=> floatval($obj->price),
					"unit_value" 		=> floatval($obj->unit_value),

					"currency" 			=> $obj->currency->get_raw()->result(),
					"measurement" 		=> $obj->measurement->get()->name
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
			$obj = new Price_list(null, $this->entity);
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
/* End of file products.php */
/* Location: ./application/controllers/api/products.php */