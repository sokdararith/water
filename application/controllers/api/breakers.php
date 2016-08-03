<?php defined('BASEPATH') OR exit('No direct script access allowed');


require APPPATH.'/libraries/REST_Controller.php';

class Breakers extends REST_Controller {
	
	
	//CONSTRUCTOR
	function __construct() {
		parent::__construct();		
		$this->load->model('inventory/breaker_model', 'breaker');		
	}
	
	
	
	//GET 
	function breaker_get() {
		$filters = $this->get("filter")["filters"];
		$logic = $this->get("filter")["logic"];
		$limit = $this->get("pageSize");
		$offset = $this->get('skip');
		$sorter = $this->get("sort");		
		$data["results"] = array();
		$data["total"] = 0;

		//Limit
		if(!empty($limit) && isset($limit)){
			$this->breaker->limit($limit, $offset);
		}

		//Sort
		if(!empty($sorter) && isset($sorter)){			
			$sort = array();
			foreach ($sorter as $row) {
				$sort += array($row["field"] => $row["dir"]);
			}			
			$this->breaker->order_by($sort);
		}

		if(!empty($filters) && isset($filters)){			
			$filter = array();			
			foreach ($filters as $row) {										
				$filter += array($row["field"] => $row["value"]);								
			}

			$data["results"] = $this->breaker->get_many_by($filter);
			$data["total"] = $this->breaker->count_by($filter);					
		}else{
			$data["results"] = $this->breaker->get_all();
			$data["total"] = $this->breaker->count_all();			
		}
		$this->response($data, 200);			
	}
	
	//POST
	function breaker_post() {
		$post = array(
			"name" 			=> $this->post("name"),
			"status" 		=> $this->post("status"),
			"customer_id" 	=> $this->post("customer_id"),
			"item_id" 		=> $this->post("item_id"),
			"date_used" 	=> date("Y-m-d", strtotime($this->post("date_used")))			
		);

		$id = $this->breaker->insert($post);
		$data["results"] = $this->breaker->get($id);

		$this->response($data, 201);				
	}
	
	//PUT
	function breaker_put() {
		$date_used = new DateTime($this->put("date_used"));

		$put = array(
			"name" 			=> $this->put("name"),
			"status" 		=> $this->put("status"),
			"customer_id" 	=> $this->put("customer_id"),
			"item_id" 		=> $this->put("item_id"),			
			"date_used" 	=> $date_used->format('Y-m-d')	
		);
		$data["status"] = $this->breaker->update($this->put('id'), $put);		
		$data["results"] = $this->breaker->get($this->put('id'));
		
		$this->response($data, 200);
	}
	
	//DELETE
	function breaker_delete() {
		$data["results"] = $this->breaker->get($this->delete("id"));		
		$data["status"] = $this->breaker->delete($this->delete("id"));
				
		$this->response($data, 200);
	}


}//End Of Class