<?php defined('BASEPATH') OR exit('No direct script access allowed');


require APPPATH.'/libraries/REST_Controller.php';

class Villages extends REST_Controller {
	
	//CONSTRUCTOR
	function __construct() {
		parent::__construct();		
		$this->load->model('locations/Village_model', 'village');	
	}
		
	
	//GET 
	function village_get() {
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
				$this->village->limit($limit, $offset);
			}			
			
			//Sort
			if(!empty($sorter) && isset($sorter)){			
				$sort = array();
				for ($j = 0; $j < count($sorter); ++$j) {				
					$sort += array($sorter[$j]['field'] => $sorter[$j]['dir']);
				}
				$this->village->order_by($sort);
			}

			$data["results"] = $this->village->get_many_by($para);
			$data["total"] = $this->village->count_by($para);

			$this->response($data, 200);			
		}else{
			$data["results"] = $this->village->get_all();
			$data["total"] = $this->village->count_all();
			$this->response($data, 200);
		}			
	}
	
	//POST
	function village_post() {	
		$post = array(
			"name" 			=> $this->post("name"),			
			"commune_id" 	=> $this->post("commune_id")					
		);

		$id = $this->village->insert($post);
		$data["results"] = $this->village->get($id);

		$this->response($data, 201);		
	}
	
	//PUT
	function village_put() {
 		 $put = array(
			"name" 			=> $this->put("name"),
			"commune_id" 	=> $this->put("commune_id")
		);
		$result = $this->village->update($this->put('id'), $put);		
		$data = $this->village->get($this->put('id'));
		
		$this->response(array("updated"=>$result, "results"=>$data), 200);
	}
	
	//DELETE
	function village_delete() {
		//$this->response(array("status"=>$this->delete('id')), 200);
		$result = $this->village->delete($this->delete('id'));
		$this->response($result, 200);
	}

	//CASCADING
	function village_cascading_get() {
		$filter = $this->get("filter");
		if(!empty($filter) && isset($filter)){
			$data = $this->village->get_many_by("commune_id", $filter['filters'][0]['value']);
		}else{
			$data = $this->village->get_all();
		}							
		$this->response($data, 200);
	}
		
	
}//End Of Class