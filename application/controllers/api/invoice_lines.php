<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); //disallow direct access to this file

require APPPATH.'/libraries/REST_Controller.php';

class Invoice_lines extends REST_Controller {	
	public $entity;
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
			$this->entity = $conn->inst_database;
		}
	}

	//GET 
	function index_get() {		
		$filters = $this->get("filter")["filters"];		
		$limit 	 = $this->get("pageSize");
		$offset  = $this->get('skip');
		$sort 	 = $this->get("sort");		
		$data["results"] = array();
		$data["count"] = 0;

		$obj = new Invoice_line(null, $this->entity);		

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
					"id" 				= $obj->id,
			   		"invoice_id"		= $obj->invoice_id,
					"item_id" 			= $obj->item_id,
					"currency_id" 		= $obj->currency_id,						
				   	"meter_record_id"	= $obj->meter_record_id,
				   	"description" 		= $obj->description,					   	
				   	"unit" 				= $obj->unit,
				   	"price"				= $obj->price,					   	
				   	"amount" 			= $obj->amount,
				   	"has_vat" 			= $obj->has_vat
				);
			}

			//Clear all items from the Active Record cache
			$obj->flush_cache();
			$data["count"] = $obj->get_where($this->_get_filters($filters))->result_count();			 			
		}		
		$this->response($data, 200);		
	}
	
	//POST
	function index_post() {
		$post = json_decode($this->post('models'));				
		$data["results"] = array();
		$data["count"] = 0;
		
		foreach ($post as $value) {
			$obj = new Invoice(null, $this->entity);
			$obj->invoice_id 		= $value->invoice_id;
			$obj->item_id 			= $value->item_id;
			$obj->currency_id		= $value->currency_id;						
		   	$obj->meter_record_id 	= $value->meter_record_id;
		   	$obj->description		= $value->description;					   	
		   	$obj->unit 				= $value->unit;
		   	$obj->price 			= $value->price;					   	
		   	$obj->amount 			= $value->amount;
		   	$obj->has_vat			= $value->has_vat;		   		   	
		   	$obj->save();

		   	$data["results"][] = array(
		   		"id" 				= $obj->id,
		   		"invoice_id"		= $obj->invoice_id,
				"item_id" 			= $obj->item_id,
				"currency_id" 		= $obj->currency_id,						
			   	"meter_record_id"	= $obj->meter_record_id,
			   	"description" 		= $obj->description,					   	
			   	"unit" 				= $obj->unit,
			   	"price"				= $obj->price,					   	
			   	"amount" 			= $obj->amount,
			   	"has_vat" 			= $obj->has_vat
		   	);
		}		

		$data["count"] = count($data["results"]);
		$this->response($data, 201);		
	}
	
	//DELETE
	function index_delete() {
		$obj = new Invoice(null, $this->entity);
		$obj->where("id", $this->delete("id"))->get();
		
		$data["status"] = $obj->delete();
		$data["results"] = $this->delete();		
		
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
    
}
/* End of file invoice_lines.php */
/* Location: ./application/controllers/api/invoice_lines.php */