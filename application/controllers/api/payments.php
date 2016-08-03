<?php defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH.'/libraries/REST_Controller.php';

class Payments extends REST_Controller {
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
		$filters 	= $this->get("filter")["filters"];		
		$page 		= $this->get('page') !== false ? $this->get('page') : 1;		
		$limit 		= $this->get('limit') !== false ? $this->get('limit') : 100;								
		$sort 	 	= $this->get("sort");		
		$data["results"] = array();
		$data["count"] = 0;

		$obj = new Payment(null, $this->entity);		

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
		    		}else{
		    			$obj->where($value["field"].' '.$value["operator"], $value["value"]);
		    		}
	    		}else{	    			
	    			$obj->where($value["field"], $value["value"]);	    				    			
	    		}
			}									 			
		}		
		
		//Results
		$obj->get_paged_iterated($page, $limit);
		$data["count"] = $obj->paged->total_rows;							

		if($obj->exists()){
			foreach ($obj as $value) {
				$reference = [];				
				if($value->type=="invoice"){
					$reference = new Invoice(null, $this->entity);					
					$reference = $reference->where("id", $value->reference_id)->get_raw()->result();
				}else if($value->type=="bill"){
					$reference = new Bill(null, $this->entity);					
					$reference = $reference->where("id", $value->reference_id)->get_raw()->result();
				}

				//Cashier
				$cashier = new Contact(null, $this->entity);
				$cashier->where("user_id", $value->cashier_id);
				
				$data["results"][] = array(
					"id" 				=> $value->id,
			   		"company_id"		=> $value->company_id,
					"contact_id" 		=> $value->contact_id,
					"cashier_id" 		=> $value->cashier_id,
					"meter_id" 			=> $value->meter_id,
					"reference_id" 		=> $value->reference_id,				   	
				   	"payment_method_id"	=> $value->payment_method_id,				   	
				   	"account_id"		=> $value->account_id,				   	
				   	"check_no"			=> $value->check_no,				   					   	
				   	"type" 				=> $value->type,				   			   	
				   	"amount" 			=> floatval($value->amount),
				   	"fine" 				=> floatval($value->fine),
				   	"discount" 			=> floatval($value->discount),
				   	"payment_date" 		=> $value->payment_date,			   	
				   	"locale" 			=> $value->locale,
				   	"rate"				=> floatval($value->rate),
				   	"deleted" 			=> $value->deleted,

				   	"contact" 			=> $value->contact->get_raw()->result(),
				   	"cashier" 			=> $cashier->get_raw()->result(),				   	
				   	"reference" 		=> $reference
				);
			}
		}		

		//Response Data		
		$this->response($data, 200);	
	}

	//POST	
	function index_post() {
		$models = json_decode($this->post('models'));				
		$data["results"] = array();
		$data["count"] = 0;
				
		foreach ($models as $value) {
			$obj = new Payment(null, $this->entity);

			$obj->company_id 		= isset($value->company_id)?$value->company_id:0;
			$obj->contact_id 		= isset($value->contact_id)?$value->contact_id:0;
			$obj->cashier_id		= isset($value->cashier_id)?$value->cashier_id:0;
			$obj->meter_id 			= isset($value->meter_id)?$value->meter_id:0;									
		   	$obj->reference_id 		= isset($value->reference_id)?$value->reference_id:0;
		   	$obj->payment_method_id	= isset($value->payment_method_id)?$value->payment_method_id:0;	   
		   	$obj->account_id		= isset($value->account_id)?$value->account_id:0;
		   	$obj->check_no			= isset($value->check_no)?$value->check_no:"";	   	
		   	$obj->type 				= isset($value->type)?$value->type:"";	   				   	
		   	$obj->amount 			= isset($value->amount)?$value->amount:0;
		   	$obj->fine 				= isset($value->fine)?$value->fine:0;
		   	$obj->discount 			= isset($value->discount)?$value->discount:0;
		   	$obj->payment_date 		= isset($value->payment_date)?$value->payment_date:"";	   	
		   	$obj->locale 			= isset($value->locale)?$value->locale:"";
		   	$obj->rate 				= isset($value->rate)?$value->rate:0;
		   	$obj->deleted			= isset($value->deleted)?$value->deleted:0;   		   	

	   		if($obj->save()){
	   			$reference = [];				
				if($obj->type=="invoice"){
					$reference = new Invoice(null, $this->entity);					
					$reference = $reference->where("id", $obj->reference_id)->get_raw()->result();
				}else if($obj->type=="bill"){
					$reference = new Bill(null, $this->entity);					
					$reference = $reference->where("id", $obj->reference_id)->get_raw()->result();
				}

				//Cashier
				$cashier = new Contact(null, $this->entity);
				$cashier->where("user_id", $obj->cashier_id);

			   	$data["results"][] = array(
			   		"id" 				=> $obj->id,
			   		"company_id"		=> $obj->company_id,
					"contact_id" 		=> $obj->contact_id,
					"cashier_id" 		=> $obj->cashier_id,
					"meter_id" 			=> $obj->meter_id,
					"reference_id" 		=> $obj->reference_id,				   	
				   	"payment_method_id"	=> $obj->payment_method_id,				   	
				   	"account_id"		=> $obj->account_id,
				   	"check_no"			=> $obj->check_no,				   				   	
				   	"type" 				=> $obj->type,				   			   	
				   	"amount" 			=> floatval($obj->amount),
				   	"fine" 				=> floatval($obj->fine),
				   	"discount" 			=> floatval($obj->discount),
				   	"payment_date" 		=> $obj->payment_date,			   	
				   	"locale" 			=> $obj->locale,
				   	"rate"				=> floatval($obj->rate),
				   	"deleted" 			=> $obj->deleted,

				   	"contact" 			=> $obj->contact->get_raw()->result(),
				   	"cashier" 			=> $cashier->get_raw()->result(),				   	
				   	"reference" 		=> $reference
			   	);
		    }	
		}
		
		$data["count"] = count($data["results"]);
		$this->response($data, 201);		
	}

	//PUT
	function index_put() {
		$models = json_decode($this->put('models'));
		$data["results"] = array();
		$data["count"] = 0;

		foreach ($models as $value) {			
			$obj = new Payment(null, $this->entity);
			$obj->get_by_id($value->id);
			
			$obj->company_id 		= isset($value->company_id)?$value->company_id:0;
			$obj->contact_id 		= isset($value->contact_id)?$value->contact_id:0;
			$obj->cashier_id		= isset($value->cashier_id)?$value->cashier_id:0;
			$obj->meter_id 			= isset($value->meter_id)?$value->meter_id:0;									
		   	$obj->reference_id 		= isset($value->reference_id)?$value->reference_id:0;
		   	$obj->payment_method_id	= isset($value->payment_method_id)?$value->payment_method_id:0;	   
		   	$obj->account_id		= isset($value->account_id)?$value->account_id:0;
		   	$obj->check_no			= isset($value->check_no)?$value->check_no:"";	   	
		   	$obj->type 				= isset($value->type)?$value->type:"";	   				   	
		   	$obj->amount 			= isset($value->amount)?$value->amount:0;
		   	$obj->fine 				= isset($value->fine)?$value->fine:0;
		   	$obj->discount 			= isset($value->discount)?$value->discount:0;
		   	$obj->payment_date 		= isset($value->payment_date)?$value->payment_date:"";	   	
		   	$obj->locale 			= isset($value->locale)?$value->locale:"";
		   	$obj->rate 				= isset($value->rate)?$value->rate:0;
		   	$obj->deleted			= isset($value->deleted)?$value->deleted:0;

			if($obj->save()){
				$reference = [];				
				if($obj->type=="invoice"){
					$reference = new Invoice(null, $this->entity);					
					$reference = $reference->where("id", $obj->reference_id)->get_raw()->result();
				}else if($obj->type=="bill"){
					$reference = new Bill(null, $this->entity);					
					$reference = $reference->where("id", $obj->reference_id)->get_raw()->result();
				}

				//Cashier
				$cashier = new Contact(null, $this->entity);
				$cashier->where("user_id", $obj->cashier_id);

				//Results
				$data["results"][] = array(
					"id" 				=> $obj->id,
			   		"company_id"		=> $obj->company_id,
					"contact_id" 		=> $obj->contact_id,
					"cashier_id" 		=> $obj->cashier_id,
					"meter_id" 			=> $obj->meter_id,
					"reference_id" 		=> $obj->reference_id,				   	
				   	"payment_method_id"	=> $obj->payment_method_id,				   	
				   	"account_id"		=> $obj->account_id,
				   	"check_no"			=> $obj->check_no,				   				   	
				   	"type" 				=> $obj->type,				   			   	
				   	"amount" 			=> $obj->amount,
				   	"fine" 				=> $obj->fine,
				   	"discount" 			=> $obj->discount,
				   	"payment_date" 		=> $obj->payment_date,			   	
				   	"locale" 			=> $obj->locale,
				   	"rate"				=> $obj->rate,
				   	"deleted" 			=> $obj->deleted,

				   	"contact" 			=> $obj->contact->get_raw()->result(),
				   	"cashier" 			=> $cashier->get_raw()->result(),				   	
				   	"reference" 		=> $reference
				);						
			}
		}
		$data["count"] = count($data["results"]);

		$this->response($data, 200);
	}
	
	//DELETE
	function index_delete() {
		$models = json_decode($this->delete('models'));

		foreach ($models as $key => $value) {
			$obj = new Payment(null, $this->entity);
			$obj->where("id", $value->id)->get();
			
			$data["results"][] = array(
				"data"   => $value,
				"status" => $obj->delete()
			);							
		}

		//Response data
		$this->response($data, 200);
	}
	
	//GET PAYMENT METHOD
    function method_get(){
		$filters = $this->get("filter")["filters"];		
		$page 	 = $this->get("page");		
		$limit 	 = $this->get("limit");								
		$sort 	 = $this->get("sort");		
		$data["results"] = array();
		$data["count"] = 0;

		$obj = new Payment_method(null, $this->entity);		

		//Sort
		if(!empty($sort) && isset($sort)){					
			foreach ($sort as $value) {
				$obj->order_by($value["field"], $value["dir"]);
			}
		}
		
		//Filter		
		if(!empty($filters) && isset($filters)){			
	    	foreach ($filters as $value) {	    		
	    		$obj->where($value["field"], $value["value"]);	    		
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
					"id" 			=> $value->id,
					"company_id"	=> $value->company_id,				
					"name" 			=> $value->name,
					"description"  	=> $value->description				
				);
			}
		}
		
		//Response Data		
		$this->response($data, 200);
	}

	//GET PAYMENT TERM
    function term_get(){
		$filters = $this->get("filter")["filters"];		
		$page 	 = $this->get("page");		
		$limit 	 = $this->get("limit");								
		$sort 	 = $this->get("sort");		
		$data["results"] = array();
		$data["count"] = 0;

		$obj = new Payment_term(null, $this->entity);		

		//Sort
		if(!empty($sort) && isset($sort)){					
			foreach ($sort as $value) {
				$obj->order_by($value["field"], $value["dir"]);
			}
		}
		
		//Filter		
		if(!empty($filters) && isset($filters)){			
	    	foreach ($filters as $value) {	    		
	    		$obj->where($value["field"], $value["value"]);	    		
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
					"id" 			=> $value->id,
					"company_id"	=> $value->company_id,				
					"name" 			=> $value->name,
					"term"  		=> $value->term,
					"discount_percentage" => $value->discount_percentage				
				);
			}
		}
		
		//Response Data		
		$this->response($data, 200);		
	}


	//GET WATER PAYMENT DETAIL
	function wsummary_get() {		
		$filters 	= $this->get("filter")["filters"];		
		$page 		= $this->get('page') !== false ? $this->get('page') : 1;		
		$limit 		= $this->get('limit') !== false ? $this->get('limit') : 100;								
		$sort 	 	= $this->get("sort");		
		$data["results"] = array();
		$data["count"] = 0;
		
		//Location
		$location = new Location(null, $this->entity);
		$location->where("utility_id", 2);
		$location->order_by("company_id");
		$location->get();							

		foreach ($location as $loc){		
			$sale = new Invoice(null, $this->entity);			
			$paid = new Payment(null, $this->entity);	

			//Filter		
			if(!empty($filters) && isset($filters)){
		    	foreach ($filters as $value) {
		    		$sale->where("issued_date ".$value["operation"], $value["value"]);
		    		$paid->where("payment_date ".$value["operation"], $value["value"]);
				}												 			
			}			

			//Sale
			$sale->select_sum('amount');		
			$sale->where("type", "wInvoice");
			$sale->where("location_id", $loc->id);
			$sale->where("deleted", 0);		
			$sale->get();

			//Paid
			$paid->select_sum('amount');		
			$paid->where("type", "invoice");
			$paid->where_in_related("contact", "wlocation_id", $loc->id);					
			$paid->get();

			$data["results"][] = array(
				"branch_name"		=> $loc->company->get()->name,
				"location_name"		=> $loc->name,				
				"sale"				=> floatval($sale->amount),
				"paid"				=> floatval($paid->amount)			
			);
		}		

		//Response Data		
		$this->response($data, 200);	
	}

	//GET WATER PAYMENT DETAIL
	function wdetail_get() {		
		$filters 	= $this->get("filter")["filters"];		
		$page 		= $this->get('page') !== false ? $this->get('page') : 1;		
		$limit 		= $this->get('limit') !== false ? $this->get('limit') : 100;								
		$sort 	 	= $this->get("sort");		
		$data["results"] = array();
		$data["count"] = 0;

		$obj = new Payment(null, $this->entity);		

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
		    		}else{
		    			$obj->where($value["field"].' '.$value["operator"], $value["value"]);
		    		}
	    		}else{	    			
	    			$obj->where($value["field"], $value["value"]);	    				    			
	    		}
			}									 			
		}		
		
		//Results
		$obj->get_paged_iterated($page, $limit);
		$data["count"] = $obj->paged->total_rows;							

		if($obj->result_count()>0){
			foreach ($obj as $value) {
				$employee = new Employee(null, $this->entity);
				$employee->get_by_id($value->cashier);

				$invoice = new Invoice(null, $this->entity);
				$invoice->get_by_id($value->reference_id);

				$data["results"][] = array(
					"id" 				=> $value->id,
					"payment_date" 		=> $value->payment_date,					
				   	"employee" 			=> $employee->surname ." ". $employee->name,
				   	"contact" 			=> $value->contact->get_raw()->result(),
				   	"invoice" 			=> $invoice->number,
				   	"amount" 			=> floatval($value->amount)				   
				);
			}
		}		

		//Response Data		
		$this->response($data, 200);	
	}

	//GET WATER PAYMENT BY SOURCE SUMMARY
	function wsource_summary_get() {		
		$filters 	= $this->get("filter")["filters"];		
		$page 		= $this->get('page') !== false ? $this->get('page') : 1;		
		$limit 		= $this->get('limit') !== false ? $this->get('limit') : 100;								
		$sort 	 	= $this->get("sort");		
		$data["results"] = array();
		$data["count"] = 0;

		//Location
		$location = new Location(null, $this->entity);
		$location->where("utility_id", 2);
		$location->order_by("company_id");
		$location->order_by("id");		
		$location->get();							

		foreach ($location as $loc){		
			$payment = new Payment(null, $this->entity);			
			
			//Filter		
			if(!empty($filters) && isset($filters)){
		    	foreach ($filters as $value) {
		    		if(!empty($value["operator"]) && isset($value["operator"])){
			    		if($value["operator"]=="between"){
			    			$payment->where_between($value["field"], $value["value1"], $value["value2"]);			    			
			    		}else{
			    			$payment->where($value["field"].' '.$value["operator"], $value["value"]);			    			
			    		}		    			
		    		}else{	    			
		    			$payment->where($value["field"], $value["value"]);		    							    			
		    		}		    		
				}												 			
			}			

			//Sale			
			$payment->where("type", "invoice");
			$payment->where_related("contact", "wlocation_id", $loc->id);
			$payment->where("deleted", 0);		
			$payment->get();

			
			$cash = 0;
			$check = 0;
			$bank = 0;
			$direct = 0;
			$internet = 0;
			foreach ($payment as $p) {
				if($p->payment_method_id==2){
					$check += floatval($p->amount);
				}else if($p->payment_method_id==3){
					$bank += floatval($p->amount);
				}else if($p->payment_method_id==4){
					$direct += floatval($p->amount);
				}else if($p->payment_method_id==5){
					$internet += floatval($p->amount);
				}else{
					$cash += floatval($p->amount);
				}				
			}			

			$data["results"][] = array(
				"branch_name"		=> $loc->company->get()->name,
				"location_name"		=> $loc->name,				
				"cash"				=> $cash,
				"check"				=> $check,
				"bank"				=> $bank,
				"direct"			=> $direct,
				"internet"			=> $internet			
			);			
		}

		$data["count"] = count($data["results"]);		

		//Response Data		
		$this->response($data, 200);	
	}

	//GET WATER PAYMENT BY SOURCE DETAIL 
	function wsource_detail_get() {		
		$filters 	= $this->get("filter")["filters"];		
		$page 		= $this->get('page') !== false ? $this->get('page') : 1;		
		$limit 		= $this->get('limit') !== false ? $this->get('limit') : 100;								
		$sort 	 	= $this->get("sort");		
		$data["results"] = array();
		$data["count"] = 0;

		$obj = new Payment(null, $this->entity);		

		//Sort
		if(!empty($sort) && isset($sort)){					
			foreach ($sort as $value) {								
				if($value["field"]=="contact_type_name"){
					$obj->order_by_related("contact", "contact_type_id", $value["dir"]);				
				}else{
					$obj->order_by($value["field"], $value["dir"]);
				}
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
		    			$obj->where_related($value["model"] ,$value["field"], $value["value"]);
		    		}else if($value["operator"]=="between"){
		    			$obj->where_between($value["field"], $value["value1"], $value["value2"]);
		    		}else{
		    			$obj->where($value["field"].' '.$value["operator"], $value["value"]);
		    		}
	    		}else{	    			
	    			$obj->where($value["field"], $value["value"]);	    				    			
	    		}
			}									 			
		}

		//Join other tables		
		$obj->include_related("payment_method", "name");
		$obj->include_related("contact/contact_type", "name");
		$obj->include_related("contact", array("contact_type_id", "wnumber", "surname", "name", "company"));
		
		//Results
		$obj->get_paged_iterated($page, $limit);
		$data["count"] = $obj->paged->total_rows;							

		if($obj->exists()){
			foreach ($obj as $value) {
				$fullname = $value->contact_surname.' '.$value->contact_name;
				if($value->contact_contact_type_id=="6" || $value->contact_contact_type_id=="7" || $value->contact_contact_type_id=="8"){
					$fullname = $value->contact_company;
				}

				$cashier = new Contact(null, $this->entity);
				$cashier->get_by_user_id($value->cashier_id);				

				$data["results"][] = array(
					"id" 					=> $value->id,
					"cashier_id" 			=> $value->cashier_id,
					"contact_id" 			=> $value->contact_id,
					"payment_method_id" 	=> $value->payment_method_id,
					"contact_number" 		=> $value->contact_wnumber,
					"fullname" 				=> $fullname,
					"contact_type_name" 	=> $value->contact_contact_type_name,
					"cashier_name" 			=> $cashier->surname ." ". $cashier->name,					
					"payment_method_name" 	=> $value->payment_method_name,
					"amount" 				=> floatval($value->amount)							
				);
			}
		}		

		//Response Data		
		$this->response($data, 200);	
	}

	//BY CASHIER
	function by_cashier_get() {		
		$filters = $this->get("filter")["filters"];				
		$data["results"] = array();
		$data["count"] = 1;	

		//Sum amount
		$obj = new Payment(null, $this->entity);
		$obj->select_sum("amount");
		$obj->where_in("type", array("invoice","deposit"));		
    	foreach ($filters as $value) {    				    		
    		$obj->where($value["field"], $value["value"]);    		
		}
		$obj->get();

		//Count customer
		$p = new Payment(null, $this->entity);		
		$p->where_in("type", array("invoice","deposit"));			
    	foreach ($filters as $value) {    			    		
    		$p->where($value["field"], $value["value"]);    		
		}
		$p->group_by("contact_id");
		$p->get();

		$data["results"][] = array(
			"id"				=> 0,
			"amount" 			=> floatval($obj->amount),												
		   	"total_customer" 	=> $p->result_count()
		);			

		//Response Data		
		$this->response($data, 200);	
	}



	
   	//GET BONG RITH
	function payment_get() {		
		$filters = $this->get("filter")["filters"];		
		$page 	 = $this->get("page");		
		$limit 	 = $this->get("limit");								
		$sort 	 = $this->get("sort");		
		$data["results"] = array();
		$data["count"] = 0;

		$obj = new Payment(null, $this->entity);		

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
		 	$today = date('Y-m-d');
		 	$num = 0;
		 	$todayAmount = 0;	
			foreach ($obj as $value) {				
				//Results
				$contact = new Contact(null, $this->entity);
				$contact->where('id', $value->contact_id)->get();
				$cashier = new Contact(null, $this->entity);
				$cashier->where('id', $value->cashier)->get();
				$bill 	 = new Bill(null, $this->entity);
				$bill->where('id', $value->reference_id)->get();
				if($today === $value->created_at) {
					$num++;
					$todayAmount += $value->amount;
				}

				$data["results"][] = array(
					"id" 			=> $value->id,												
				   	"type" 			=> $value->type,
				   	"contact"		=> array('id'=>$contact->id, 'name'=>$contact->name, 'surname'=>$contact->surname),
				   	"reference"		=> array('id'=>$bill->id,'invoice_number'=>$bill->invoice_number, 'type'=>$bill->type, 'due_date'=>$bill->due_date),
				   	"amount" 		=> floatval($value->amount),					   	
				   	"fine" 			=> $value->fine,
				   	"discount"		=> $value->discount,
				   	"cashier"		=> array('id'=>$cashier->id, 'name'=>$cashier->name, 'surname'=>$cashier->surname),
				   	"rate" 			=> floatval($value->rate),
				   	"locale" 		=> $value->locale,					   	
				   	"payment_date" 	=> $value->payment_date	
				);
			}
			$data['meta'] = array('num' => $num, 'todayAmount' => $todayAmount);	
			//Response Data		
			$this->response($data, 200);
		} else {
			$data["results"][] = array();
			$data['meta'] = array('num' => 0, 'todayAmount' => 0);
			$this->response($data, 200);
		}
			
	}

	//POST BONG RITH
	function payment_post() {
		$models = json_decode($this->post('models'));				
		$data["results"] = array();
		$data["count"] = 0;
		$ids = array();
		
		foreach ($models as $value) {
			$obj = new Payment(null, $this->entity);
			$obj->contact_id 	= $value->contact->id;
			$obj->cashier 		= $value->cashier->id;
			$obj->reference_id 	= $value->reference->id;
		   	$obj->type 			= $value->type;					   	
		   	$obj->amount 		= $value->amount;
		   	$obj->fine			= $value->fine;
		   	$obj->discount 		= $value->discount;
		   	$obj->rate 			= $value->rate;
		   	$obj->locale 		= $value->locale;						   
		   	$obj->payment_date 	= $value->payment_date;		   			   		   	
		   	
		   	//Save All
		   	if($obj->save()){			   		   		   		 		
		   		$contact = new Contact(null, $this->entity);
				$contact->where('id', $obj->contact_id)->get();
				$cashier = new Contact(null, $this->entity);
				$cashier->where('id', $obj->cashier)->get();
				if($obj->type === 'bill') {
					$reference 	= new Bill(null, $this->entity);
					$reference->where('id', $obj->reference_id)->get();
					$payments = new Payment(null, $this->entity);
					$payments->where('reference_id', $reference->id);
					$payments->where('deleted', 'false')->get();
					$amountPaid = 0;
					foreach($payments as $pmt) {
						$amountPaid += floatval($pmt->amount);
					}
					if($amountPaid === floatval($reference->amount)) {
						$reference->status = 'closed';
					} else {
						$reference->status = 'partial';
					}
					$reference->save();
				} else if($obj->type==='invoice') {
					$reference 	= new Invoice(null, $this->entity);
					$reference->where('id', $obj->reference_id)->get();
				}
			   	
			   	$data["results"][] = array(
			   		"id" 			=> $obj->id,												
				   	"type" 			=> $obj->type,
				   	"contact"		=> array('id'=>$contact->id, 'name'=>$contact->name, 'surname'=>$contact->surname),
				   	"reference"		=> array('id'=>$reference->id,'invoice_number'=>$reference->invoice_number, 'type'=>$reference->type, 'due_date'=>$reference->due_date),
				   	"amount" 		=> floatval($value->amount),					   	
				   	"fine" 			=> $value->fine,
				   	"discount"		=> $value->discount,
				   	"cashier"		=> array('id'=>$cashier->id, 'name'=>$cashier->name, 'surname'=>$cashier->surname),
				   	"rate" 			=> floatval($obj->rate),
				   	"locale" 		=> $obj->locale,					   	
				   	"payment_date" 	=> $value->payment_date
			   	);
			   	// $ids[] = $obj->id;
			   	// $log = new Log(null, $this->entity);
			   	// $log->user_id = $this->user;
			   	// $log->action  = "user $this->user created payments with ids ";
			   	// $log->save();
		    }
		}
		
		$data["count"] = count($data["results"]);
		$this->response($data, 201);		
	}	
}