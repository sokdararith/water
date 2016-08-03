<?php defined('BASEPATH') OR exit('No direct script access allowed');


require APPPATH.'/libraries/REST_Controller.php';

class People_types extends REST_Controller {
	
	
	//CONSTRUCTOR
	function __construct() {
		parent::__construct();		
		$this->load->model('people/people_type_model', 'people_type');		
	}
	
	//GET 
	function people_type_get() {
		$filters = $this->get("filter")["filters"];
		$logic = $this->get("filter")["logic"];
		$limit = $this->get("pageSize");
		$offset = $this->get('skip');
		$sorter = $this->get("sort");		
		$data["results"] = array();
		$data["total"] = 0;

		//Limit
		if(!empty($limit) && isset($limit)){
			$this->people_type->limit($limit, $offset);
		}

		//Sort
		if(!empty($sorter) && isset($sorter)){			
			$sort = array();
			foreach ($sorter as $row) {
				$sort += array($row["field"] => $row["dir"]);
			}			
			$this->people_type->order_by($sort);
		}

		if(!empty($filters) && isset($filters)){			
			$filter = array();			
			foreach ($filters as $row) {										
				$filter += array($row["field"] => $row["value"]);								
			}

			$data["results"] = $this->people_type->get_many_by($filter);
			$data["total"] = $this->people_type->count_by($filter);					
		}else{
			$data["results"] = $this->people_type->get_all();
			$data["total"] = $this->people_type->count_all();			
		}
		$this->response($data, 200);			
	}
	
	//POST
	function people_type_post() {
		$post = array(			
			"name" 		=> $this->post("name"),						
			"parent_id"	=> $this->post("parent_id")					
		);	
		$id = $this->people_type->insert($post);
		$data["results"] = $this->people_type->get($id);

		$this->response($data, 201);				
	}
	
	//PUT
	function people_type_put() {
		$put = array(			
			"name" 		=> $this->put("name"),						
			"parent_id"	=> $this->put("parent_id")					
		);
		$data["status"] = $this->people_type->update($this->put('id'), $put);		
		$data["results"] = $this->people_type->get($this->put('id'));
		
		$this->response($data, 200);
	}
	
	//DELETE
	function people_type_delete() {		
		$data["results"] = $this->people_type->get($this->delete("id"));		
		$data["status"] = $this->people_type->delete($this->delete("id"));

		$this->response($data, 200);
	}
}