<?php defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH.'/libraries/REST_Controller.php';

class Tariffs extends REST_Controller {
	
	//CONSTRUCTOR
	function __construct() {
		parent::__construct();
		$this->load->model('tariffs/tariff_model', 'tariff');		
	}
	
		
	//GET 
	function tariff_get() {
		$filters = $this->get("filter")["filters"];
		$logic = $this->get("filter")["logic"];
		$limit = $this->get("pageSize");
		$offset = $this->get('skip');
		$sorter = $this->get("sort");		
		$data["results"] = array();
		$data["total"] = 0;

		//Limit
		if(!empty($limit) && isset($limit)){
			$this->tariff->limit($limit, $offset);
		}

		//Sort
		if(!empty($sorter) && isset($sorter)){			
			$sort = array();
			foreach ($sorter as $row) {
				$sort += array($row["field"] => $row["dir"]);
			}			
			$this->tariff->order_by($sort);
		}

		if(!empty($filters) && isset($filters)){			
			$filter = array();			
			foreach ($filters as $row) {										
				$filter += array($row["field"] => $row["value"]);								
			}

			$data["results"] = $this->tariff->get_many_by($filter);
			$data["total"] = $this->tariff->count_by($filter);					
		}else{
			$data["results"] = $this->tariff->get_all();
			$data["total"] = $this->tariff->count_all();			
		}
		$this->response($data, 200);			
	}
	
	//POST
	function tariff_post() {
		$post = array(								
			"name"			=> $this->post("name"),			
			"company_id"	=> $this->post("company_id")		
		);		
		$id = $this->tariff->insert($post);
		$data["results"] = $this->tariff->get($id);

		$this->response($data, 201);				
	}
	
	//PUT
	function tariff_put() {
		$put = array(								
			"name"			=> $this->put("name"),			
			"company_id"	=> $this->put("company_id")		
		);
		$data["status"] = $this->tariff->update($this->put('id'), $put);		
		$data["results"] = $this->tariff->get($this->put('id'));
		
		$this->response($data, 200);
	}
	
	//DELETE
	function tariff_delete() {		
		$data["results"] = $this->tariff->get($this->delete("id"));		
		$data["status"] = $this->tariff->delete($this->delete("id"));

		$this->response($data, 200);
	}	
		
	
}//End Of Class