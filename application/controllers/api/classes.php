<?php defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH.'/libraries/REST_Controller.php';

class Classes extends REST_Controller {
	
	//CONSTRUCTOR
	function __construct() {
		parent::__construct();		
		$this->load->model('accounting/class_model', 'classes');
		$this->load->model('company_m', 'company');	
	}
	
		
	//GET 
	function class_get() {
		$filter = $this->get("filter");		
		if(!empty($filter) && isset($filter)){
			$para = array();				
			for ($i = 0; $i < count($filter['filters']); ++$i) {				
				$para += array($filter['filters'][$i]['field'] => $filter['filters'][$i]['value']);
			}
			$query = $this->classes->get_many_by($para);			
			if(count($query)>0) {
				foreach($query as $row) {
					$data[] = array(
						"id" => $row->id,
						"company" => $this->company->get($row->company_id),
						"name" => $row->name,
						"type" => $row->type,
						"description" => $row->description,
						"url" => array(
							"href"=> base_url() ."classes/class/".$row->id,
							"title"=> $row->name
						)
					);
				}				
				$this->response(array('error'=>'false', 
					'meta'=>array(
						'code'=>200,
						'message'=>"data found.", 
						'dataAccessed'=>Date('d-m-Y'),
						'action'=>"GET"), 
					'results'=>$data), 
				200);	

			} else {				
				$this->response(array('error'=>'false','code'=>404,'message'=>'no data found.', 'results'=>array()), 404);	
			}	
		}else{
			$this->response(array('error'=>'false','code'=>401,'message'=>'no query passed.', 'results'=>array()), 401);
		}			
	}
	
	//POST
	function class_post() {	
		$postedData['company_id'] = $this->post('company_id');
		$postedData['name'] = $this->post('name');
		$postedData['description'] = $this->post('description');
		$postedData['type'] = $this->post('type');

		if($this->_check_class_name($this->post('company_id'), $this->post('name'))=== FALSE) {
			$id = $this->classes->insert($postedData);
			$this->response($id, 200);
		} else {
			$this->response(array("status"=>"failed","error"=>TRUE,"msg"=>"Class already existed."), 200);
		}		
	}
	
	//PUT
	function class_put() {
 		$result = $this->classes->update($this->put('id'), $this->put());
 		$this->response($result, 200);
	}
	
	//DELETE
	function class_delete() {
		//$this->response(array("status"=>$this->delete('id')), 200);
		$result = $this->classes->delete($this->delete('id'));
		$this->response($result, 200);
	}
	
	private function _check_class_name($company_id, $className) {
		$query = $this->classes->get_by(array("company_id"=>$company_id, "name"=>$className));
		if(count($query)>0) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	//BY DAWINE 
	function index_get() {
		$filters = $this->get("filter")["filters"];
		$logic = $this->get("filter")["logic"];
		$limit = $this->get("pageSize");
		$offset = $this->get('skip');
		$sorter = $this->get("sort");		
		$data["results"] = array();
		$data["total"] = 0;

		//Limit
		if(!empty($limit) && isset($limit)){
			$this->classes->limit($limit, $offset);
		}

		//Sort
		if(!empty($sorter) && isset($sorter)){			
			$sort = array();
			foreach ($sorter as $row) {
				$sort += array($row["field"] => $row["dir"]);
			}			
			$this->classes->order_by($sort);
		}

		if(!empty($filters) && isset($filters)){			
			$filter = array();			
			foreach ($filters as $row) {										
				$filter += array($row["field"] => $row["value"]);								
			}

			$data["results"] = $this->classes->get_many_by($filter);
			$data["total"] = $this->classes->count_by($filter);					
		}else{
			$data["results"] = $this->classes->get_all();
			$data["total"] = $this->classes->count_all();			
		}
		$this->response($data, 200);			
	}

	
}//End Of Class