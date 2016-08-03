<?php defined('BASEPATH') OR exit('No direct script access allowed');


require APPPATH.'/libraries/REST_Controller.php';

class Reconcile_items extends REST_Controller {
	
	
	//CONSTRUCTOR
	function __construct() {
		parent::__construct();		
		$this->load->model('accounting/reconcile_item_model', 'reconcile_item');
			
	}
	
	
	
	//GET 
	function reconcile_item_get() {		
		$filters = $this->get("filter")["filters"];
		$logic = $this->get("filter")["logic"];
		$limit = $this->get("pageSize");
		$offset = $this->get('skip');
		$sorter = $this->get("sort");		
		$data["results"] = array();
		$data["total"] = 0;

		//Limit
		if(!empty($limit) && isset($limit)){
			$this->reconcile_item->limit($limit, $offset);
		}

		//Sort
		if(!empty($sorter) && isset($sorter)){			
			$sort = array();
			foreach ($sorter as $row) {
				$sort += array($row["field"] => $row["dir"]);
			}			
			$this->reconcile_item->order_by($sort);
		}

		if(!empty($filters) && isset($filters)){			
			$filter = array();			
			foreach ($filters as $row) {										
				$filter += array($row["field"] => $row["value"]);								
			}

			$data["results"] = $this->reconcile_item->get_many_by($filter);
			$data["total"] = $this->reconcile_item->count_by($filter);					
		}
		$this->response($data, 200);		
	}
	
	//POST
	function reconcile_item_post() {
		$models = json_decode($this->post("models"));

		if(!empty($models) && isset($models)){			
			foreach ($models as $key => $value) {				
				$id = $this->reconcile_item->insert($value);
				$data["results"][] = $this->reconcile_item->get($id);
			}			
		}else{
			$post = array('reconcile_id'	=> $this->post('reconcile_id'),
						'denomination' 		=> $this->post('denomination'),					
						'qty_usd' 			=> $this->post('qty_usd'),
						'qty_khr' 			=> $this->post('qty_khr'),
						'reconcile_type'	=> $this->post('reconcile_type')															 
			);
			$id = $this->reconcile_item->insert($post);		
			$data["results"] = $this->reconcile_item->get($id);
		}

		$this->response($data, 200);						
	}
	
	//PUT
	function reconcile_item_put() {
		$put = array('reconcile_id'		=> $this->post('reconcile_id'),
					'denomination' 		=> $this->put('denomination'),					
					'qty_usd' 			=> $this->put('qty_usd'),
					'qty_khr' 			=> $this->put('qty_khr'),
					'reconcile_type'	=> $this->put('reconcile_type')															 
		);	
		$data["status"] = $this->reconcile_item->update($this->put('id'), $put);		
		$data["results"] = $this->reconcile_item->get($this->put('id'));
		
		$this->response($data, 200);
	}
	
	//DELETE
	function reconcile_item_delete() {
		$data["results"] = $this->reconcile_item->get($this->delete("id"));		
		$data["status"] = $this->reconcile_item->delete($this->delete("id"));

		$this->response($data, 200);
	}

}//End Of Class