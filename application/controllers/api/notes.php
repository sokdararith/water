<?php defined('BASEPATH') OR exit('No direct script access allowed');


require APPPATH.'/libraries/REST_Controller.php';

class Notes extends REST_Controller {
	public $_database;
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
			$this->_database = $conn->inst_database;
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

		$obj = new Note(null, $this->_database);		

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
		
		if($obj->exists()){
			foreach ($obj as $value) {
				$creator = new Contact(null, $this->_database);
				$creator->where("user_id", $value->created_by);
				$creator->get();

		 		$data["results"][] = array(
		 			"id" 			=> $value->id,
					"contact_id" 	=> $value->contact_id,					
					"note"			=> $value->note,
					"noted_date"	=> $value->noted_date,
					"created_by" 	=> $value->created_by,

					"creator" 		=> $creator->surname ." ". $creator->name
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
			$obj = new Note(null, $this->_database);
			$obj->contact_id 	= $value->contact_id;
			$obj->note 			= $value->note;
			$obj->noted_date	= $value->noted_date;			
		   	$obj->created_by 	= $value->created_by;					   	
		   				
			if($obj->save()){
				$creator = new Contact(null, $this->_database);
				$creator->where("user_id", $obj->created_by);
				$creator->get();

				//Respsone
				$data["results"][] = array(					
					"id" 			=> $obj->id,
					"contact_id" 	=> $obj->contact_id,					
					"note"			=> $obj->note,
					"noted_date"	=> $obj->noted_date,
					"created_by" 	=> $obj->created_by,

					"creator" 		=> $creator->surname ." ". $creator->name
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
			$obj = new Note(null, $this->_database);
			$obj->get_by_id($value->id);

			$obj->contact_id 	= $value->contact_id;
			$obj->note 			= $value->note;
			$obj->noted_date	= $value->noted_date;			
		   	$obj->created_by 	= $value->created_by;

			if($obj->save()){
				$creator = new Contact(null, $this->_database);
				$creator->where("user_id", $obj->created_by);
				$creator->get();
								
				//Results
				$data["results"][] = array(
					"id" 			=> $obj->id,
					"contact_id" 	=> $obj->contact_id,					
					"note"			=> $obj->note,
					"noted_date"	=> $obj->noted_date,
					"created_by" 	=> $obj->created_by,

					"creator" 		=> $creator->surname ." ". $creator->name
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
			$obj = new Note(null, $this->_database);
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
/* End of file contact_persons.php */
/* Location: ./application/controllers/api/contact_persons.php */