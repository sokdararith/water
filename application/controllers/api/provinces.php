<?php defined('BASEPATH') OR exit('No direct script access allowed');


require APPPATH.'/libraries/REST_Controller.php';

class Provinces extends REST_Controller {
	
	//CONSTRUCTOR
	function __construct() {
		parent::__construct();		
		$this->load->model('locations/Province_model', 'province');	
	}
		
	
	//GET 
	function province_get() {
		$filter = $this->get("filter");
		$limit = $this->get("pageSize");
		$offset = $this->get('skip');
		$sorter = $this->get("sort");

		if(!empty($filter) && isset($filter)){			
			//Filter
			$para = array();				
			for ($i = 0; $i < count($filter['filters']); ++$i) {				
				$para += array($filter['filters'][$i]['field'] => $filter['filters'][$i]['value']);
			}
			
			//Limit
			if(!empty($limit) && isset($limit)){
				$this->province->limit($limit, $offset);
			}			
			
			//Sort
			if(!empty($sorter) && isset($sorter)){			
				$sort = array();
				for ($j = 0; $j < count($sorter); ++$j) {				
					$sort += array($sorter[$j]['field'] => $sorter[$j]['dir']);
				}
				$this->province->order_by($sort);
			}

			$data["results"] = $this->province->get_many_by($para);
			$data["total"] = $this->province->count_by($para);

			$this->response($data, 200);			
		}else{
			$data["results"] = $this->province->get_all();
			$data["total"] = $this->province->count_all();
			$this->response($data, 200);
		}
	}
	
	//POST
	function province_post() {	
		$post = array(
			"name" 			=> $this->post("name")					
		);

		$id = $this->province->insert($post);
		$data["results"] = $this->province->get($id);

		$this->response($data, 201);		
	}
	
	//PUT
	function province_put() {
 		 $put = array(
			"name" 			=> $this->put("name")
		);
		$result = $this->province->update($this->put('id'), $put);		
		$data = $this->province->get($this->put('id'));
		
		$this->response(array("updated"=>$result, "results"=>$data), 200);
	}
	
	//DELETE
	function province_delete() {
		$result = $this->province->delete($this->delete('id'));
		$this->response($result, 200);
	}
		
	
}//End Of Class