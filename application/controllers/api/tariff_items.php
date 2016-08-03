<?php defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH.'/libraries/REST_Controller.php';

class Tariff_items extends REST_Controller {
	
	//CONSTRUCTOR
	function __construct() {
		parent::__construct();				
	}
	
		
	//GET 
	function index_get(){
		$filters = $this->get("filter")["filters"];		
		$limit 	 = $this->get("pageSize");
		$offset  = $this->get('skip');
		$sort 	 = $this->get("sort");		
		$data["results"] = array();
		$data["total"] = 0;

		$obj = new Tariff_item();		

		//Sort
		if(!empty($sort) && isset($sort)){					
			$obj->order_by($this->_get_sorts($sort));
		}

		//Limit
		if(!empty($limit) && isset($limit)){					
			$obj->limit($limit, $offset);
		}		

		//Filter
		if(!empty($filters) && isset($filters)){				
			$obj->get_where($this->_get_filters($filters));

			foreach ($obj as $value) {
				$data["results"][] = array(
					"id" 			=> $value->id,
					"fee_id" 		=> $value->fee_id, 		
					"usage" 		=> $value->usage, 		
					"price" 		=> $value->price,
					"is_flat"		=> $value->is_flat=="true"?true:false				
				);
			}			

			//Clear all items from the Active Record cache
			$obj->flush_cache();
			$data["total"] = $obj->get_where($this->_get_filters($filters))->result_count();			 			
		}		
		$this->response($data, 200);		
	}
	function index_post() {	

		$post = json_decode($this->post('models'));				
		$data["results"] = array();
		$data["total"] = 0;

		foreach ($post as $value) {
			$obj = new Tariff_item();		
			$obj->fee_id 		= $value->fee_id;
			$obj->usage 		= $value->usage;
			$obj->price 		= $value->price;						
		   	$obj->is_flat 		= $value->is_flat=="true"?true:false;	   		   	
		   	$obj->save();

		   	$data["results"][] = array(	   		
		   		
			"id" 			=> $obj->id,
			"fee_id" 		=> $obj->fee_id,
			"usage" 		=> $obj->usage,
			"price" 		=> $obj->price,
			"is_flat" 		=> $obj->is_flat=="true"?true:false
			
		
		   	);
		}	
		
		$data["total"] = count($data["results"]);
		$this->response($data, 201);				
	}
	function tariff_item_get() {
		$filters = $this->get("filter")["filters"];
		$logic = $this->get("filter")["logic"];
		$limit = $this->get("pageSize");
		$offset = $this->get('skip');
		$sorter = $this->get("sort");		
		$data["results"] = array();
		$data["total"] = 0;

		//Limit
		if(!empty($limit) && isset($limit)){
			$this->tariff_item->limit($limit, $offset);
		}

		//Sort
		if(!empty($sorter) && isset($sorter)){			
			$sort = array();
			foreach ($sorter as $row) {
				$sort += array($row["field"] => $row["dir"]);
			}			
			$this->tariff_item->order_by($sort);
		}

		if(!empty($filters) && isset($filters)){			
			$filter = array();			
			foreach ($filters as $row) {										
				$filter += array($row["field"] => $row["value"]);								
			}

			$data["results"] = $this->tariff_item->get_many_by($filter);
			$data["total"] = $this->tariff_item->count_by($filter);					
		}else{
			$data["results"] = $this->tariff_item->get_all();
			$data["total"] = $this->tariff_item->count_all();
		}
		$this->response($data, 200);			
	}
	
	//POST
	function tariff_item_post() {
		$post = array(								
			"tariff_id"		=> $this->post("tariff_id"),
			"usage"			=> $this->post("usage"),
			"price"			=> $this->post("price"),
			"is_flat"		=> $this->post("is_flat")
								
		);		
		$id = $this->tariff_item->insert($post);
		$data["results"] = $this->tariff_item->get($id);

		$this->response($data, 201);				
	}
	
	//PUT
	function tariff_item_put() {
		$put = array(								
			"tariff_id"		=> $this->put("tariff_id"),
			"usage"			=> $this->put("usage"),
			"price"			=> $this->put("price"),
			"is_flat"		=> $this->put("is_flat")
							
		);
		$data["status"] = $this->tariff_item->update($this->put('id'), $put);		
		$data["results"] = $this->tariff_item->get($this->put('id'));
		
		$this->response($data, 200);
	}
	
	//DELETE
	function tariff_item_delete() {		
		$data["results"] = $this->tariff_item->get($this->delete("id"));		
		$data["status"] = $this->tariff_item->delete($this->delete("id"));

		$this->response($data, 200);
	}

	//Sort
	private function _get_sorts($sorts) {
    	$sortList = array();
		foreach ($sorter as $row) {
			$sortList += array($row["field"] => $row["dir"]);
		}

		return $sortList;
    }

    //Filter
    private function _get_filters($filters) {
    	$filterList = array();
    	foreach ($filters as $value) {											
			$filterList += array($value["field"] => $value["value"]);						
		}

		return $filterList;
    }
	
		
	
}//End Of Class