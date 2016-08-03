<?php defined('BASEPATH') OR exit('No direct script access allowed');


require APPPATH.'/libraries/REST_Controller.php';

class People_api extends REST_Controller {
	
	//CONSTRUCTOR
	function __construct() {
		parent::__construct();
		$this->load->model('people/people_model', 'people');
		$this->load->model('people/people_type_model', 'people_type');		
	}
	
	
	
	/* --- PEOPLE --- */
	
	//GET 
	function people_get() {		
		$type_id = 1;//$this->get('type_id');
				
		if(!empty($type_id) && isset($type_id)) {			
			$data = $this->people->get_people_by_type($type_id);				
		}		
		else {
			$data = $this->people->get_all();
		}
						
		$this->response($data, 200);
	}
	
	//POST
	function people_post() {			
		$this->people->insert($this->post());
		$this->response($this->post(), 200);		
	}
	
	//PUT
	function people_put() {
 		 $this->people->update($this->put('id'), $this->put());
	}
	
	//DELETE
	function people_delete() {
		//$this->response(array("status"=>$this->delete('id')), 200);
		$this->people->delete($this->delete('id'));
	}
	
	//CUSTOMER SEARCH
	function customer_search_get() {
		$limit 	= $this->get('pageSize');
		$offset = $this->get('skip');
		$this->people->limit($limit, $offset);		
		$filter = $this->get('filter');
		
		$this->people->get_people_by_parameter(1, $filter['filters'][0]['value']);				 		 					
  		
		$data['people'] = $this->people->get_all();
		
		$data['total'] = $this->people->count_by("people.status", 1);
		$this->response($data, 200);
	}
		
	
	/* --- PEOPLE TYPES --- */
	
	//GET 
	function people_type_get() {
		$parent_id = $this->get('parent_id');		
		if (!empty($parent_id) && isset($parent_id)) {
			$data = $this->people_type->get_many_by('parent_id', $parent_id);
		}else{
			$data = $this->people_type->get_all();	
		}				
		$this->response($data, 200);
	}
	
	//POST
	function people_type_post() {	
		$this->people_type->insert($this->post());		
	}
	
	//PUT
	function people_type_put() {
 		 $this->people_type->update($this->put('id'), $this->put());
	}
	
	//DELETE
	function people_type_delete() {
		//$this->response(array("status"=>$this->delete('id')), 200);
		$this->people_type->delete($this->delete('id'));
	}
	
	
	
	
	
}