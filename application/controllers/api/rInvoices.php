<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); //disallow direct access to this file

require APPPATH.'/libraries/REST_Controller.php';

class rInvoices extends REST_Controller {	
	public $entity;
	//CONSTRUCTOR
	function __construct() {
		parent::__construct();
		$this->entity = $this->input->get_request_header('Entity');
	}

	//GET 
	function index_get() {		
		$filters = $this->get("filter")["filters"];		
		$page 	 = $this->get("page");		
		$limit 	 = $this->get("limit");								
		$sort 	 = $this->get("sort");		
		$data["results"] = array();
		$data["count"] = 0;

		$obj = new rInvoice(null, $this->entity);		

		//Sort
		if(!empty($sort) && isset($sort)){					
			foreach ($sort as $value) {
				$obj->order_by($value["field"], $value["dir"]);
			}
		}
		
		//Filter		
		if(!empty($filters) && isset($filters)){			
	    	foreach ($filters as $value) {
	    		if(!empty($value["operator"]) && isset($value["operator"])){
		    		if($value["operator"]=="where_in"){
		    			$obj->where_in($value["field"], $value["value"]);
		    		}else if($value["operator"]=="or_where_in"){
		    			$obj->or_where_in($value["field"], $value["value"]);
		    		}else if($value["operator"]=="where_not_in"){
		    			$obj->where_not_in($value["field"], $value["value"]);
		    		}else if($value["operator"]=="or_where_not_in"){
		    			$obj->or_where_not_in($value["field"], $value["value"]);
		    		}else if($value["operator"]=="like"){
		    			$obj->like($value["field"], $value["value"]);
		    		}else if($value["operator"]=="or_like"){
		    			$obj->or_like($value["field"], $value["value"]);
		    		}else if($value["operator"]=="not_like"){
		    			$obj->not_like($value["field"], $value["value"]);
		    		}else if($value["operator"]=="or_not_like"){
		    			$obj->or_not_like($value["field"], $value["value"]);
		    		}else if($value["operator"]=="startswith"){
		    			$obj->like($value["field"], $value["value"], "after");
		    		}else if($value["operator"]=="endswith"){
		    			$obj->like($value["field"], $value["value"], "before");
		    		}else if($value["operator"]=="contains"){
		    			$obj->like($value["field"], $value["value"], "both");
		    		}else if($value["operator"]=="or_where"){
		    			$obj->or_where($value["field"], $value["value"]);
		    		}else if($value["operator"]=="where_related"){
		    			$obj->include_related($value["table"], "id");		    					    			
		    			$obj->where_related($value["table"], $value["field"], $value["value"]);		    		
		    		}else{
		    			$obj->where($value["field"].' '.$value["operator"], $value["value"]);
		    		}
	    		}else{	    			
	    			$obj->where($value["field"], $value["value"]);	    				    			
	    		}
			}									 			
		}		

		if(!empty($limit) && !empty($page)){
			$obj->get_paged_iterated($page, $limit);
			$data["count"] = $obj->paged->total_rows;							
		}

		if($obj->result_count()>0){			
			foreach ($obj as $value) {
				//Results				
				$data["results"][] = array(
					"id" 				=> $value->id,								   			   						   
				   	"number" 			=> $value->number,				   	
				   	"room_number" 		=> $value->room_number,
				   	"customer_name" 	=> $value->customer_name,
				   	"month_of" 			=> $value->month_of,
				   	"date_in" 			=> $value->date_in,
				   	"wfrom"				=> $value->wfrom,
				   	"wto"				=> $value->wto,
				   	"wqty" 				=> $value->wqty,
				   	"wadd_on" 			=> $value->wadd_on,
				   	"wprice" 			=> floatval($value->wprice),
				   	"wamt" 				=> floatval($value->wamt),
				   	"trash" 			=> floatval($value->trash),
				   	"service" 			=> floatval($value->service),
				   	"deposit" 			=> floatval($value->deposit),
				   	"rental" 			=> floatval($value->rental),
				   	"total" 			=> floatval($value->total)
				);
			}
		}		

		//Response Data		
		$this->response($data, 200);	
	}	
	
}
/* End of file rInvoices.php */
/* Location: ./application/controllers/api/invoices.php */