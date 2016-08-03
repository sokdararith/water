<?php defined('BASEPATH') OR exit('No direct script access allowed');


require APPPATH.'/libraries/REST_Controller.php';

class Items extends REST_Controller {
	public $_database;
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
			$this->_database = $conn->inst_database;
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

		$obj = new Item(null, $this->_database);		

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
		    			$obj->where($value["field"], $value["value"]);
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
				$priceList = array();				
				foreach ($value->price_list->get() as $p) {
					$priceList[] = array(
						"id" 			=> $p->id,
						"currency_id" 	=> $p->currency_id,
						"product_id" 	=> $p->product_id,
						"measurement_id"=> $p->measurement_id,
						"price" 		=> floatval($p->price),
						"unit_value" 	=> floatval($p->unit_value),
						
						"measurement" 	=> $p->measurement->get()->name,
						"currency" 		=> $p->currency->get_raw()->result()
					); 
				}

				$data["results"][] = array(
					"id" 					=> $value->id,
					"company_id" 			=> $value->company_id,
					"contact_id" 			=> $value->contact_id,
					"currency_id" 			=> $value->currency_id,
					"item_type_id"			=> $value->item_type_id,					
					"category_id" 			=> $value->category_id,
					"item_group_id"			=> $value->item_group_id,
					"item_sub_group_id"		=> $value->item_sub_group_id,
					"brand_id" 				=> $value->brand_id,					
					"measurement_id" 		=> $value->measurement_id,					
					"main_id" 				=> $value->main_id,
					"sku" 					=> $value->sku,
					"international_code" 	=> $value->international_code,
					"imei" 					=> $value->imei,
					"serial_number" 		=> $value->serial_number,
					"supplier_code"			=> $value->supplier_code,
					"color_code" 			=> $value->color_code,
				   	"name" 					=> $value->name,
				   	"description" 			=> $value->description,
				   	"catalogs" 				=> explode(",",$value->catalogs),				   	
				   	"cost" 					=> floatval($value->cost),
				   	"price" 				=> floatval($value->price),
				   	"amount" 				=> floatval($value->amount),
				   	"rate" 					=> floatval($value->rate),
				   	"on_hand" 				=> floatval($value->on_hand),
				   	"on_po" 				=> floatval($value->on_po),
				   	"on_so" 				=> floatval($value->on_so),
				   	"order_point" 			=> intval($value->order_point),
				   	"income_account_id" 	=> $value->income_account_id,
				   	"cogs_account_id"		=> $value->cogs_account_id,
				   	"inventory_account_id"	=> $value->inventory_account_id,
				   	"deposit_account_id" 	=> $value->deposit_account_id,
				   	"transaction_account_id"=> $value->transaction_account_id,			   	
				   	"preferred_vendor_id" 	=> $value->preferred_vendor_id,
				   	"image_url" 			=> $value->image_url,
				   	"favorite" 				=> $value->favorite=="true"?true:false,
				   	"is_catalog" 			=> $value->is_catalog,
				   	"is_assemble" 			=> $value->is_assemble,				  
				   	"status" 				=> $value->status,
				   	"deleted" 				=> $value->deleted, 					
 					
 					"category" 				=> $value->category->get()->name,
				   	"measurement"			=> $value->measurement->get()->name,
				   	"price_list"			=> $priceList
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
			$obj = new Item(null, $this->_database);			
			isset($value->company_id) 				? $obj->company_id 				= $value->company_id : "";
			isset($value->contact_id) 				? $obj->contact_id 				= $value->contact_id : "";			
			isset($value->currency_id) 				? $obj->currency_id 			= $value->currency_id : "";
			isset($value->item_type_id) 			? $obj->item_type_id			= $value->item_type_id : "";			
			isset($value->category_id) 				? $obj->category_id 			= $value->category_id : "";
			isset($value->item_group_id) 			? $obj->item_group_id 			= $value->item_group_id : "";
			isset($value->item_sub_group_id) 		? $obj->item_sub_group_id 		= $value->item_sub_group_id : "";
			isset($value->brand_id) 				? $obj->brand_id 				= $value->brand_id : "";						
			isset($value->measurement_id) 			? $obj->measurement_id 			= $value->measurement_id : "";		
			isset($value->main_id) 					? $obj->main_id 				= $value->main_id : "";
			isset($value->sku) 						? $obj->sku 					= $value->sku : "";
			isset($value->international_code) 		? $obj->international_code 		= $value->international_code : "";
			isset($value->imei) 					? $obj->imei 					= $value->imei : "";
			isset($value->serial_number) 			? $obj->serial_number 			= $value->serial_number : "";
			isset($value->supplier_code) 			? $obj->supplier_code 			= $value->supplier_code : "";
			isset($value->color_code) 				? $obj->color_code 				= $value->color_code : "";
		   	isset($value->name) 					? $obj->name 					= $value->name :  "";
		   	isset($value->description) 				? $obj->description 			= $value->description : "";
		   	isset($value->catalogs) 				? $obj->catalogs 				= implode(",",$value->catalogs) : "";	   			   	
		   	isset($value->cost) 					? $obj->cost 					= $value->cost : "";
		   	isset($value->price) 					? $obj->price 					= $value->price : "";
		   	isset($value->amount) 					? $obj->amount 					= $value->amount : "";
		   	isset($value->rate) 					? $obj->rate 					= $value->rate :0;
		   	isset($value->on_hand) 					? $obj->on_hand 				= $value->on_hand : "";
		   	isset($value->on_po) 					? $obj->on_po 					= $value->on_po : "";
		   	isset($value->on_so) 					? $obj->on_so 					= $value->on_so : "";
		   	isset($value->order_point) 				? $obj->order_point 			= $value->order_point : "";
		   	isset($value->income_account_id) 		? $obj->income_account_id 		= $value->income_account_id : "";
		   	isset($value->cogs_account_id) 			? $obj->cogs_account_id 		= $value->cogs_account_id : "";
		   	isset($value->inventory_account_id) 	? $obj->inventory_account_id 	= $value->inventory_account_id : "";
		   	isset($value->deposit_account_id) 		? $obj->deposit_account_id 		= $value->deposit_account_id : "";
		   	isset($value->transaction_account_id)	? $obj->transaction_account_id 	= $value->transaction_account_id : "";
		   	isset($value->preferred_vendor_id) 		? $obj->preferred_vendor_id 	= $value->preferred_vendor_id : "";
		   	isset($value->image_url) 				? $obj->image_url				= $value->image_url : "";
		   	isset($value->favorite) 				? $obj->favorite 				= $value->favorite : "";
		   	isset($value->is_catalog) 				? $obj->is_catalog 				= $value->is_catalog : "";
		   	isset($value->is_assemble) 				? $obj->is_assemble 			= $value->is_assemble : "";
		   	isset($value->status) 					? $obj->status 					= $value->status : "";	   	
		   	isset($value->deleted) 					? $obj->deleted 				= $value->deleted : "";

	   		if($obj->save()){
			   	$data["results"][] = array(
			   		"id" 					=> $obj->id,
					"company_id" 			=> $obj->company_id,
					"contact_id" 			=> $obj->contact_id,
					"currency_id" 			=> $obj->currency_id,
					"item_type_id"			=> $obj->item_type_id,					
					"category_id" 			=> $obj->category_id,
					"item_group_id"			=> $obj->item_group_id,
					"item_sub_group_id"		=> $obj->item_sub_group_id,
					"brand_id" 				=> $obj->brand_id,					
					"measurement_id" 		=> $obj->measurement_id,					
					"main_id" 				=> $obj->main_id,
					"sku" 					=> $obj->sku,
					"international_code" 	=> $obj->international_code,
					"imei" 					=> $obj->imei,
					"serial_number" 		=> $obj->serial_number,
					"supplier_code"			=> $obj->supplier_code,
					"color_code" 			=> $obj->color_code,
				   	"name" 					=> $obj->name,
				   	"description" 			=> $obj->description,
				   	"catalogs" 				=> explode(",",$obj->catalogs),				   	
				   	"cost" 					=> floatval($obj->cost),
				   	"price" 				=> floatval($obj->price),
				   	"amount" 				=> floatval($obj->amount),
				   	"rate" 					=> floatval($obj->rate),
				   	"on_hand" 				=> floatval($obj->on_hand),
				   	"on_po" 				=> floatval($obj->on_po),
				   	"on_so" 				=> floatval($obj->on_so),
				   	"order_point" 			=> intval($obj->order_point),
				   	"income_account_id" 	=> $obj->income_account_id,
				   	"cogs_account_id"		=> $obj->cogs_account_id,
				   	"inventory_account_id"	=> $obj->inventory_account_id,
				   	"deposit_account_id" 	=> $obj->deposit_account_id,
				   	"transaction_account_id"=> $obj->transaction_account_id,			   	
				   	"preferred_vendor_id" 	=> $obj->preferred_vendor_id,
				   	"image_url" 			=> $obj->image_url,
				   	"favorite" 				=> $obj->favorite=="true"?true:false,
				   	"is_catalog" 			=> $obj->is_catalog,
				   	"is_assemble" 			=> $obj->is_assemble,				  
				   	"status" 				=> $obj->status,
				   	"deleted" 				=> $obj->deleted
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
			$obj = new Item(null, $this->_database);
			$obj->get_by_id($value->id);

			isset($value->company_id) 				? $obj->company_id 				= $value->company_id : "";
			isset($value->contact_id) 				? $obj->contact_id 				= $value->contact_id : "";			
			isset($value->currency_id) 				? $obj->currency_id 			= $value->currency_id : "";
			isset($value->item_type_id) 			? $obj->item_type_id			= $value->item_type_id : "";			
			isset($value->category_id) 				? $obj->category_id 			= $value->category_id : "";
			isset($value->item_group_id) 			? $obj->item_group_id 			= $value->item_group_id : "";
			isset($value->item_sub_group_id) 		? $obj->item_sub_group_id 		= $value->item_sub_group_id : "";
			isset($value->brand_id) 				? $obj->brand_id 				= $value->brand_id : "";						
			isset($value->measurement_id) 			? $obj->measurement_id 			= $value->measurement_id : "";		
			isset($value->main_id) 					? $obj->main_id 				= $value->main_id : "";
			isset($value->sku) 						? $obj->sku 					= $value->sku : "";
			isset($value->international_code) 		? $obj->international_code 		= $value->international_code : "";
			isset($value->imei) 					? $obj->imei 					= $value->imei : "";
			isset($value->serial_number) 			? $obj->serial_number 			= $value->serial_number : "";
			isset($value->supplier_code) 			? $obj->supplier_code 			= $value->supplier_code : "";
			isset($value->color_code) 				? $obj->color_code 				= $value->color_code : "";
		   	isset($value->name) 					? $obj->name 					= $value->name :  "";
		   	isset($value->description) 				? $obj->description 			= $value->description : "";
		   	isset($value->catalogs) 				? $obj->catalogs 				= implode(",",$value->catalogs) : "";	   			   	
		   	isset($value->cost) 					? $obj->cost 					= $value->cost : "";
		   	isset($value->price) 					? $obj->price 					= $value->price : "";
		   	isset($value->amount) 					? $obj->amount 					= $value->amount : "";
		   	isset($value->rate) 					? $obj->rate 					= $value->rate :0;
		   	isset($value->on_hand) 					? $obj->on_hand 				= $value->on_hand : "";
		   	isset($value->on_po) 					? $obj->on_po 					= $value->on_po : "";
		   	isset($value->on_so) 					? $obj->on_so 					= $value->on_so : "";
		   	isset($value->order_point) 				? $obj->order_point 			= $value->order_point : "";
		   	isset($value->income_account_id) 		? $obj->income_account_id 		= $value->income_account_id : "";
		   	isset($value->cogs_account_id) 			? $obj->cogs_account_id 		= $value->cogs_account_id : "";
		   	isset($value->inventory_account_id) 	? $obj->inventory_account_id 	= $value->inventory_account_id : "";
		   	isset($value->deposit_account_id) 		? $obj->deposit_account_id 		= $value->deposit_account_id : "";
		   	isset($value->transaction_account_id)	? $obj->transaction_account_id 	= $value->transaction_account_id : "";
		   	isset($value->preferred_vendor_id) 		? $obj->preferred_vendor_id 	= $value->preferred_vendor_id : "";
		   	isset($value->image_url) 				? $obj->image_url				= $value->image_url : "";
		   	isset($value->favorite) 				? $obj->favorite 				= $value->favorite : "";
		   	isset($value->is_catalog) 				? $obj->is_catalog 				= $value->is_catalog : "";
		   	isset($value->is_assemble) 				? $obj->is_assemble 			= $value->is_assemble : "";
		   	isset($value->status) 					? $obj->status 					= $value->status : "";	   	
		   	isset($value->deleted) 					? $obj->deleted 				= $value->deleted : "";

			if($obj->save()){				
				//Results
				$data["results"][] = array(
					"id" 					=> $obj->id,
					"company_id" 			=> $obj->company_id,
					"contact_id" 			=> $obj->contact_id,
					"currency_id" 			=> $obj->currency_id,
					"item_type_id"			=> $obj->item_type_id,					
					"category_id" 			=> $obj->category_id,
					"item_group_id"			=> $obj->item_group_id,
					"item_sub_group_id"		=> $obj->item_sub_group_id,
					"brand_id" 				=> $obj->brand_id,					
					"measurement_id" 		=> $obj->measurement_id,					
					"main_id" 				=> $obj->main_id,
					"sku" 					=> $obj->sku,
					"international_code" 	=> $obj->international_code,
					"imei" 					=> $obj->imei,
					"serial_number" 		=> $obj->serial_number,
					"supplier_code"			=> $obj->supplier_code,
					"color_code" 			=> $obj->color_code,
				   	"name" 					=> $obj->name,
				   	"description" 			=> $obj->description,
				   	"catalogs" 				=> explode(",",$obj->catalogs),				   	
				   	"cost" 					=> floatval($obj->cost),
				   	"price" 				=> floatval($obj->price),
				   	"amount" 				=> floatval($obj->amount),
				   	"rate" 					=> floatval($obj->rate),
				   	"on_hand" 				=> floatval($obj->on_hand),
				   	"on_po" 				=> floatval($obj->on_po),
				   	"on_so" 				=> floatval($obj->on_so),
				   	"order_point" 			=> intval($obj->order_point),
				   	"income_account_id" 	=> $obj->income_account_id,
				   	"cogs_account_id"		=> $obj->cogs_account_id,
				   	"inventory_account_id"	=> $obj->inventory_account_id,
				   	"deposit_account_id" 	=> $obj->deposit_account_id,
				   	"transaction_account_id"=> $obj->transaction_account_id,			   	
				   	"preferred_vendor_id" 	=> $obj->preferred_vendor_id,
				   	"image_url" 			=> $obj->image_url,
				   	"favorite" 				=> $obj->favorite=="true"?true:false,
				   	"is_catalog" 			=> $obj->is_catalog,
				   	"is_assemble" 			=> $obj->is_assemble,				  
				   	"status" 				=> $obj->status,
				   	"deleted" 				=> $obj->deleted
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
			$obj = new Item(null, $this->_database);
			$obj->where("id", $value->id)->get();
			
			$data["results"][] = array(
				"data"   => $value,
				"status" => $obj->delete()
			);							
		}

		//Response data
		$this->response($data, 200);
	}


	//GET RECORD
	function record_get() {		
		$filters 	= $this->get("filter")["filters"];		
		$page 		= $this->get('page') !== false ? $this->get('page') : 1;		
		$limit 		= $this->get('limit') !== false ? $this->get('limit') : 100;								
		$sort 	 	= $this->get("sort");		
		$data["results"] = array();
		$data["count"] = 0;

		$obj = new Item_record(null, $this->_database);		

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
				$data["results"][] = array(
					"id" 					=> $value->id,
					"contact_id" 			=> $value->contact_id,
					"reference_id" 			=> $value->reference_id,
					"invoice_id" 			=> $value->invoice_id,
					"currency_id" 			=> $value->currency_id,
					"adjustment_account_id"	=> $value->adjustment_account_id,
					"measurement_id" 		=> $value->measurement_id,					
					"item_id"				=> $value->item_id,
					"unit" 					=> floatval($value->unit),					
				   	"cost" 					=> floatval($value->cost),
				   	"price" 				=> floatval($value->price),
				   	"amount" 				=> floatval($value->amount),
				   	"rate" 					=> floatval($value->rate),
				   	"reference_no" 			=> $value->reference_no,
				   	"movement" 				=> $value->movement,
				   	"issued_date" 			=> $value->issued_date,
				   	"segments" 				=> explode(",", $value->sgements),
				   	"memo" 					=> $value->memo,
				   	"deleted"				=> $value->deleted
				);
			}
		}		

		//Response Data		
		$this->response($data, 200);	
	}	
	
	//POST RECORD
	function record_post() {
		$models = json_decode($this->post('models'));				
		$data["results"] = array();
		$data["count"] = 0;				
		
		foreach ($models as $value) {
			$obj = new Item_record(null, $this->_database);						
			$obj->contact_id 			= isset($value->contact_id)?$value->contact_id:0;			
			$obj->reference_id 			= isset($value->reference_id)?$value->reference_id:0;
			$obj->invoice_id 			= isset($value->invoice_id)?$value->invoice_id:0;
			$obj->currency_id 			= isset($value->currency_id)?$value->currency_id:0;						
			$obj->adjustment_account_id	= isset($value->adjustment_account_id)?$value->adjustment_account_id:0;
			$obj->measurement_id		= isset($value->measurement_id)?$value->measurement_id:0;		
			$obj->item_id 				= isset($value->item_id)?$value->item_id:0;
			$obj->unit 					= isset($value->unit)?$value->unit:0;
			$obj->cost 					= isset($value->cost)?$value->cost:0;
			$obj->price 				= isset($value->price)?$value->price:0;
			$obj->amount 				= isset($value->amount)?$value->amount:0;
		   	$obj->rate 					= isset($value->rate)?$value->rate:0;
		   	$obj->reference_no 			= isset($value->reference_no)?$value->reference_no:0;
		   	$obj->movement 				= isset($value->movement)?$value->movement:"";
		   	$obj->issued_date 			= isset($value->issued_date)?$value->issued_date:"";
		   	$obj->segments 				= isset($value->segments)?implode(",", $value->segments):"";
		   	$obj->memo 					= isset($value->memo)?$value->memo:"";		   	
		   	$obj->deleted 				= isset($value->deleted)?$value->deleted:0;

	   		if($obj->save()){
			   	$data["results"][] = array(
			   		"id" 					=> $obj->id,
					"contact_id" 			=> $obj->contact_id,
					"reference_id" 			=> $obj->reference_id,
					"invoice_id" 			=> $obj->invoice_id,
					"currency_id" 			=> $obj->currency_id,
					"adjustment_account_id"	=> $obj->adjustment_account_id,
					"measurement_id" 		=> $obj->measurement_id,					
					"item_id"				=> $obj->item_id,
					"unit" 					=> floatval($obj->unit),
					"cost" 					=> floatval($obj->cost),					
				   	"price" 				=> floatval($obj->price),
				   	"amount" 				=> floatval($obj->amount),
				   	"rate" 					=> floatval($obj->rate),
				   	"reference_no" 			=> $obj->reference_no,
				   	"movement" 				=> $obj->movement,
				   	"issued_date" 			=> $obj->issued_date,
				   	"segments" 				=> explode(",", $obj->sgements),
				   	"memo" 					=> $obj->memo,
				   	"deleted"				=> $obj->deleted
			   	);
		    }	
		}
		
		$data["count"] = count($data["results"]);
		$this->response($data, 201);		
	}
	
	//PUT RECORD
	function record_put() {
		$models = json_decode($this->put('models'));
		$data["results"] = array();
		$data["count"] = 0;

		foreach ($models as $value) {			
			$obj = new Item_record(null, $this->_database);
			$obj->get_by_id($value->id);

			$obj->contact_id 			= isset($value->contact_id)?$value->contact_id:0;			
			$obj->reference_id 			= isset($value->reference_id)?$value->reference_id:0;
			$obj->invoice_id 			= isset($value->invoice_id)?$value->invoice_id:0;
			$obj->currency_id 			= isset($value->currency_id)?$value->currency_id:0;						
			$obj->adjustment_account_id	= isset($value->adjustment_account_id)?$value->adjustment_account_id:0;
			$obj->measurement_id		= isset($value->measurement_id)?$value->measurement_id:0;		
			$obj->item_id 				= isset($value->item_id)?$value->item_id:0;
			$obj->unit 					= isset($value->unit)?$value->unit:0;
			$obj->cost 					= isset($value->cost)?$value->cost:0;
			$obj->price 				= isset($value->price)?$value->price:0;
			$obj->amount 				= isset($value->amount)?$value->amount:0;
		   	$obj->rate 					= isset($value->rate)?$value->rate:0;
		   	$obj->reference_no 			= isset($value->reference_no)?$value->reference_no:0;
		   	$obj->movement 				= isset($value->movement)?$value->movement:"";
		   	$obj->issued_date 			= isset($value->issued_date)?$value->issued_date:"";
		   	$obj->segments 				= isset($value->segments)?implode(",", $value->segments):"";
		   	$obj->memo 					= isset($value->memo)?$value->memo:"";		   	
		   	$obj->deleted 				= isset($value->deleted)?$value->deleted:0;

			if($obj->save()){				
				//Results
				$data["results"][] = array(
					"id" 					=> $obj->id,
					"contact_id" 			=> $obj->contact_id,
					"reference_id" 			=> $obj->reference_id,
					"invoice_id" 			=> $obj->invoice_id,
					"currency_id" 			=> $obj->currency_id,
					"adjustment_account_id"	=> $obj->adjustment_account_id,
					"measurement_id" 		=> $obj->measurement_id,					
					"item_id"				=> $obj->item_id,
					"unit" 					=> floatval($obj->unit),
					"cost" 					=> floatval($obj->cost),					
				   	"price" 				=> floatval($obj->price),
				   	"amount" 				=> floatval($obj->amount),
				   	"rate" 					=> floatval($obj->rate),
				   	"reference_no" 			=> $obj->reference_no,
				   	"movement" 				=> $obj->movement,
				   	"issued_date" 			=> $obj->issued_date,
				   	"segments" 				=> explode(",", $obj->sgements),
				   	"memo" 					=> $obj->memo,
				   	"deleted"				=> $obj->deleted
				);						
			}
		}
		$data["count"] = count($data["results"]);

		$this->response($data, 200);
	}
	
	//DELETE RECORD
	function record_delete() {
		$models = json_decode($this->delete('models'));

		foreach ($models as $key => $value) {
			$obj = new Item_record(null, $this->_database);
			$obj->where("id", $value->id)->get();
			
			$data["results"][] = array(
				"data"   => $value,
				"status" => $obj->delete()
			);							
		}

		//Response data
		$this->response($data, 200);
	}


	//GET ASSEMBLY
	function assembly_get() {		
		$filters 	= $this->get("filter")["filters"];		
		$page 		= $this->get('page') !== false ? $this->get('page') : 1;		
		$limit 		= $this->get('limit') !== false ? $this->get('limit') : 100;								
		$sort 	 	= $this->get("sort");		
		$data["results"] = array();
		$data["count"] = 0;

		$obj = new Price_list(null, $this->_database);		

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
				$pl = new Price_list(null, $this->_database);
				
				$priceList = array();				
				foreach ($pl->get_by_id($value->assembly_id) as $p) {
					$priceList[] = array(
						"id" 			=> $p->id,
						"currency_id" 	=> $p->currency_id,
						"product_id" 	=> $p->product_id,
						"measurement_id"=> $p->measurement_id,
						"price" 		=> floatval($p->price),
						"unit_value" 	=> floatval($p->unit_value),
						
						"measurement" 	=> $p->measurement->get()->name,
						"currency" 		=> $p->currency->get_raw()->result()
					); 
				}

				$data["results"][] = array(
					"id" 				=> $value->id,
					"item_id" 			=> $value->item_id,
					"assembly_id" 		=> $value->assembly_id,
					"currency_id" 		=> $value->currency_id,
					"measurement_id" 	=> $value->measurement_id,
					"quantity" 			=> $value->quantity,
					"unit_value" 		=> $value->unit_value,
					"price" 			=> $value->price,
					"amount" 			=> $value->amount,					 					
 					
 					"currency" 			=> $value->currency->get_raw()->result(),
 					"price_list" 		=> $priceList,
 					"assembly" 			=> $value->assembly->get_raw()->result()					
				);
			}
		}		

		//Response Data		
		$this->response($data, 200);	
	}	
	
	//POST ASSEMBLY
	function assembly_post() {
		$models = json_decode($this->post('models'));				
		$data["results"] = array();
		$data["count"] = 0;
				
		$sku = "";
		foreach ($models as $value) {
			$obj = new Price_list(null, $this->_database);

			$obj->item_id 			= $value->item_id;
			$obj->assembly_id 		= $value->assembly_id;
			$obj->currency_id 		= $value->currency_id;
			$obj->measurement_id 	= $value->measurement_id;
			$obj->quantity 			= $value->quantity;
			$obj->unit_value 		= $value->unit_value;
			$obj->price 			= $value->price;
			$obj->amount 			= $value->amount;			
			
	   		if($obj->save()){
			   	$data["results"][] = array(
			   		"id" 				=> $obj->id,
					"item_id" 			=> $obj->item_id,
					"assembly_id" 		=> $obj->assembly_id,
					"currency_id" 		=> $obj->currency_id,
					"measurement_id" 	=> $obj->measurement_id,
					"quantity" 			=> $obj->quantity,
					"unit_value" 		=> $obj->unit_value,
					"price" 			=> $obj->price,
					"amount" 			=> $obj->amount
			   	);
		    }	
		}
		
		$data["count"] = count($data["results"]);
		$this->response($data, 201);		
	}
	
	//PUT ASSEMBLY
	function assembly_put() {
		$models = json_decode($this->put('models'));
		$data["results"] = array();
		$data["count"] = 0;

		foreach ($models as $value) {			
			$obj = new Price_list(null, $this->_database);
			$obj->get_by_id($value->id);

			$obj->item_id 			= $value->item_id;
			$obj->assembly_id 		= $value->assembly_id;
			$obj->currency_id 		= $value->currency_id;
			$obj->measurement_id 	= $value->measurement_id;
			$obj->quantity 			= $value->quantity;
			$obj->unit_value 		= $value->unit_value;
			$obj->price 			= $value->price;
			$obj->amount 			= $value->amount;

			if($obj->save()){				
				//Results
				$data["results"][] = array(
					"id" 				=> $obj->id,
					"item_id" 			=> $obj->item_id,
					"assembly_id" 		=> $obj->assembly_id,
					"currency_id" 		=> $obj->currency_id,
					"measurement_id" 	=> $obj->measurement_id,
					"quantity" 			=> $obj->quantity,
					"unit_value" 		=> $obj->unit_value,
					"price" 			=> $obj->price,
					"amount" 			=> $obj->amount
				);						
			}
		}
		$data["count"] = count($data["results"]);

		$this->response($data, 200);
	}
	
	//DELETE ASSEMBLY
	function assembly_delete() {
		$models = json_decode($this->delete('models'));

		foreach ($models as $key => $value) {
			$obj = new Price_list(null, $this->_database);
			$obj->where("id", $value->id)->get();
			
			$data["results"][] = array(
				"data"   => $value,
				"status" => $obj->delete()
			);							
		}

		//Response data
		$this->response($data, 200);
	}


	//GET ITEM GROUP
	function group_get() {		
		$filters 	= $this->get("filter")["filters"];		
		$page 		= $this->get('page') !== false ? $this->get('page') : 1;		
		$limit 		= $this->get('limit') !== false ? $this->get('limit') : 100;								
		$sort 	 	= $this->get("sort");		
		$data["results"] = array();
		$data["count"] = 0;

		$obj = new Item_group(null, $this->_database);		

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
		    			$obj->where($value["field"], $value["value"]);
		    		}
	    		}else{
	    			$obj->where($value["field"], $value["value"]);
	    		}
			}									 			
		}
		
		$obj->get_paged_iterated($page, $limit);
		$data["count"] = $obj->paged->total_rows;		

		if($obj->result_count()>0){			
			foreach ($obj as $value) {				
				//Results				
				$data["results"][] = array(
					"id" 			=> $value->id,
					"category_id" 	=> $value->category_id,					
					"sub_of" 		=> $value->sub_of,
					"code" 			=> $value->code,
					"name" 	 		=> $value->name,
					"abbr" 			=> $value->abbr,
					"is_system"		=> $value->is_system	
				);
			}
		}

		//Response Data		
		$this->response($data, 200);		
	}
	
	//POST ITEM GROUP
	function group_post() {
		$models = json_decode($this->post('models'));

		foreach ($models as $value) {
			$obj = new Item_group(null, $this->_database);			
			$obj->category_id 	= $value->category_id;
			$obj->sub_of 		= $value->sub_of;
			$obj->code 			= $value->code;
			$obj->name 			= $value->name;
			$obj->abbr 			= $value->abbr;
			$obj->is_system 	= $value->is_system;
						
			if($obj->save()){
				$data["results"][] = array(
					"id" 			=> $obj->id,
					"category_id" 	=> $obj->category_id,					
					"sub_of" 		=> $obj->sub_of,
					"code" 			=> $obj->code,
					"name" 	 		=> $obj->name,
					"abbr" 			=> $obj->abbr,
					"is_system"		=> $obj->is_system	
				);
			}
		}
		$data["count"] = count($data["results"]);
		
		$this->response($data, 201);						
	}

	//PUT ITEM GROUP
	function group_put() {
		$models = json_decode($this->put('models'));
		$data["results"] = array();
		$data["count"] = 0;

		foreach ($models as $value) {			
			$obj = new Item_group(null, $this->_database);
			$obj->get_by_id($value->id);

			$obj->category_id 	= $value->category_id;
			$obj->sub_of 		= $value->sub_of;
			$obj->code 			= $value->code;
			$obj->name 			= $value->name;
			$obj->abbr 			= $value->abbr;
			$obj->is_system 	= $value->is_system;

			if($obj->save()){				
				$data["results"][] = array(
					"id" 			=> $obj->id,
					"category_id" 	=> $obj->category_id,					
					"sub_of" 		=> $obj->sub_of,
					"code" 			=> $obj->code,
					"name" 	 		=> $obj->name,
					"abbr" 			=> $obj->abbr,
					"is_system"		=> $obj->is_system	
				);		
			}
		}
		$data["count"] = count($data["results"]);

		$this->response($data, 200);
	}
	
	//DELETE ITEM GROUP
	function group_delete() {
		$models = json_decode($this->delete('models'));

		foreach ($models as $key => $value) {
			$obj = new Item_group(null, $this->_database);
			$obj->where("id", $value->id)->get();
			
			$data["results"][] = array(
				"data"   => $value,
				"status" => $obj->delete()
			);							
		}

		//Response data
		$this->response($data, 200);
	}


	//GET ITEM CONTACT
	function contact_get() {		
		$filters 	= $this->get("filter")["filters"];		
		$page 		= $this->get('page') !== false ? $this->get('page') : 1;		
		$limit 		= $this->get('limit') !== false ? $this->get('limit') : 100;								
		$sort 	 	= $this->get("sort");		
		$data["results"] = array();
		$data["count"] = 0;

		$obj = new Item_contact(null, $this->_database);		

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
		    			$obj->where($value["field"], $value["value"]);
		    		}
	    		}else{
	    			$obj->where($value["field"], $value["value"]);
	    		}
			}									 			
		}
		
		$obj->get_paged_iterated($page, $limit);
		$data["count"] = $obj->paged->total_rows;		

		if($obj->result_count()>0){			
			foreach ($obj as $value) {				
				//Results				
				$data["results"][] = array(
					"id" 			=> $value->id,
					"item_id" 		=> $value->item_id,					
					"contact_id" 	=> $value->contact_id,					
					"code"			=> $value->code,
					"type"			=> $value->type	
				);
			}
		}

		//Response Data		
		$this->response($data, 200);		
	}
	
	//POST ITEM CONTACT
	function contact_post() {
		$models = json_decode($this->post('models'));

		foreach ($models as $value) {
			$obj = new Item_contact(null, $this->_database);			
			isset($value->item_id) 		? $obj->item_id 	= $value->item_id : "";
			isset($value->contact_id) 	? $obj->contact_id 	= $value->contact_id : "";			
			isset($value->code) 		? $obj->code 		= $value->code : "";
			isset($value->type) 		? $obj->type 		= $value->type : "";
									
			if($obj->save()){
				$data["results"][] = array(
					"id" 			=> $obj->id,
					"item_id" 		=> $obj->item_id,					
					"contact_id" 	=> $obj->contact_id,
					"code"			=> $obj->code,					
					"type"			=> $obj->type	
				);
			}
		}
		$data["count"] = count($data["results"]);
		
		$this->response($data, 201);						
	}

	//PUT ITEM CONTACT
	function contact_put() {
		$models = json_decode($this->put('models'));
		$data["results"] = array();
		$data["count"] = 0;

		foreach ($models as $value) {			
			$obj = new Item_contact(null, $this->_database);
			$obj->get_by_id($value->id);

			isset($value->item_id) 		? $obj->item_id 	= $value->item_id : "";
			isset($value->contact_id) 	? $obj->contact_id 	= $value->contact_id : "";
			isset($value->code) 		? $obj->code 		= $value->code : "";			
			isset($value->type) 		? $obj->type 		= $value->type : "";

			if($obj->save()){				
				$data["results"][] = array(
					"id" 			=> $obj->id,
					"item_id" 		=> $obj->item_id,					
					"contact_id" 	=> $obj->contact_id,
					"code"			=> $obj->code,					
					"type"			=> $obj->type	
				);		
			}
		}
		$data["count"] = count($data["results"]);

		$this->response($data, 200);
	}
	
	//DELETE ITEM CONTACT
	function contact_delete() {
		$models = json_decode($this->delete('models'));

		foreach ($models as $key => $value) {
			$obj = new Item_contact(null, $this->_database);
			$obj->where("id", $value->id)->get();
			
			$data["results"][] = array(
				"data"   => $value,
				"status" => $obj->delete()
			);							
		}

		//Response data
		$this->response($data, 200);
	}	


	//GENERATE NUMBER
	private function _generate_number($type_id){		
		$header = "";
    	switch($type_id){
		case "2":
		  	$header = "NIP";
		  	break;
		case "3":
		  	$header = "FXA";
		  	break;
		case "4":
		  	$header = "SVR";
		  	break;
		case "5":
		  	$header = "DEP";
		  	break;
		case "6":
		  	$header = "VAT";
		  	break;
		case "7":
		  	$header = "OCH";
		  	break;
		case "8":
		  	$header = "TRA";
		  	break;									
		default:
		  	$header = "INP";
		}
		
		$YY = date("y");
		$MM = date("m");
		$headerWithDate = $header . $YY . $MM;

		$inv = new Item(null, $this->_database);
		$inv->where('item_type_id', $type_id);
		$inv->order_by('id', 'desc');
		$inv->get();

		$last_no = "";		
		if(count($inv)>0){
			$last_no = $inv->sku;
		}
		$no = 0;
		$curr_YY = 0;
		if(strlen($last_no)>10){
			$no = intval(substr($last_no, strlen($last_no) - 5));
			$curr_YY = intval(substr($last_no, strlen($last_no) - 9, 2));			
		}				 
		
		//Reset invoice number back to 1 for the new year starts
		if(intval($YY)>$curr_YY){
			$no = 1;
		}else{
			$no++;
		}
								
		$number = $headerWithDate . str_pad($no, 5, "0", STR_PAD_LEFT);					
		
		return $number;				
	}

	//GET DASHBOARD
	function dashboard_get() {		
		$filters 	= $this->get("filter")["filters"];		
		$page 		= $this->get('page') !== false ? $this->get('page') : 1;		
		$limit 		= $this->get('limit') !== false ? $this->get('limit') : 100;								
		$sort 	 	= $this->get("sort");		
		$data["results"] = [];
		$data["count"] = 0;

		$type = new Item_type(null, $this->_database);				
		$gpm = new Invoice_line(null, $this->_database);
		$item = new Item(null, $this->_database);
		
		if(!empty($filters) && isset($filters)){			
	    	foreach ($filters as $value) {			    				
	    		$gpm->where_related("invoice", $value["field"], $value["value"]);		    		
			}									 			
		}

		//Gross Profit Margin
		$gpm->where_in_related("invoice", "type", array("Invoice", "Receipt"));
		$gpm->where_in_related("item", "item_type_id", 1);
		$gpm->get();

		$cogs = 0; $sale = 0;
		foreach ($gpm as $m) {
			$cogs += floatval($m->unit) * floatval($m->cost);
			$sale += floatval($m->unit) * floatval($m->price); 
		}

		$gp = $sale - $cogs;
		$margin = 0;
		if($sale>0){
			$margin = $gp / $sale;
		}

		//Total Inventory Value
		$item->where("item_type_id", 1);
		$item->where("is_catalog", 0);
		$item->where("is_assemble", 0);
		$item->get();

		$total_cost = 0; $total_cogs = 0; $as_of = date("Y-m-d"); $sdate = date("Y-m-d");
		foreach ($item as $i) {
			$line = new Invoice_line(null, $this->_database);
			$lineA = new Invoice_line(null, $this->_database);			

			if(!empty($filters) && isset($filters)){			
		    	foreach ($filters as $value) {			    				
			    	$line->where_related("invoice", $value["field"], $value["value"]);			    			    	
			    	$as_of = $value["value"];		    		
				}									 			
			}

			//Total Cost
			$line->where_in_related("invoice", "type", array("Invoice","Receipt"));
			$line->where("item_id", $i->id);
			$line->order_by("issued_date", "desc");
			$line->limit(1);			
			$line->get();

			$total_cost += floatval($line->on_hand) * floatval($line->cost);

			//Total COGS
			$sdate = date('Y', strtotime($as_of)).'-01-01';
			
			$lineA->where_related("invoice", "issued_date >=", $sdate);
			$lineA->where_related("invoice", "issued_date <=", $as_of);
			$lineA->where_in_related("invoice", "type", array("Invoice","Receipt"));
			$lineA->where("item_id", $i->id);					
			$lineA->get();
			
			foreach ($lineA as $la) {				
				$total_cogs += intval($la->unit) * floatval($la->cost);
			}									
		}

		//Inventory Turnover Day		
		$diff = strtotime($as_of) - strtotime($sdate);
		$diff = floor($diff/(60*60*24));

		$days = 0;
		if($total_cogs>0){
			$days = ($total_cost / $total_cogs) * $diff;
		}

		$data["results"][] = array(
			"id" 					=> 1,
			"type" 					=> $type->count(),
			"gross_profit_margin"	=> $margin,
			"turnover_day"			=> $days,
			"total_value" 			=> $total_cost
		);			

		//Response Data		
		$this->response($data, 200);	
	}

	//GET INVENTORY POSITION SUMMARY
	function inventory_position_summary_get() {		
		$filters 	= $this->get("filter")["filters"];		
		$page 		= $this->get('page') !== false ? $this->get('page') : 1;		
		$limit 		= $this->get('limit') !== false ? $this->get('limit') : 100;								
		$sort 	 	= $this->get("sort");		
		$data["results"] = array();
		$data["count"] = 0;

		$obj = new Item(null, $this->_database);		

		//Sort
		if(!empty($sort) && isset($sort)){					
			foreach ($sort as $value) {
				$obj->order_by($value["field"], $value["dir"]);
			}
		}
		
		$obj->where("item_type_id", 1);
		$obj->where("is_catalog", 0);
		$obj->where("is_assemble", 0);		
		
		//Results
		$obj->get_paged_iterated($page, $limit);
		$data["count"] = $obj->paged->total_rows;							

		if($obj->result_count()>0){
			foreach ($obj as $value) {
				$record = $value->invoice_line;				
				
				if(!empty($filters) && isset($filters)){			
			    	foreach ($filters as $val) {			    				
			    		$record->where_related("invoice", $val["field"], $val["value"]);		    		
					}									 			
				}
				
				//Record
				$record->order_by_related("invoice", "issued_date", "desc");
				$record->limit(1);
				$record->get();

				$data["results"][] = array(
					"id" 			=> $value->id,
					"item_id" 		=> $value->item_id,
					"category_id" 	=> $value->category_id,
					"item_group_id" => $value->item_group_id,					
					"sku"			=> $value->sku,
					"name" 			=> $value->name,									
					"category" 		=> $value->category->get_raw()->result(),
					"item_group" 	=> $value->item_group->get_raw()->result(),
					"on_hand" 		=> intval($record->on_hand),
					"on_po" 		=> intval($record->on_po),
					"on_so" 		=> intval($record->on_so),
					"cost" 			=> floatval($record->cost),					
					"price_avg" 	=> floatval($record->price_avg)
				);
			}
		}		

		//Response Data		
		$this->response($data, 200);	
	}

	//GET INVENTORY POSITION DETAIL
	function inventory_position_detail_get() {		
		$filters 	= $this->get("filter")["filters"];		
		$page 		= $this->get('page') !== false ? $this->get('page') : 1;		
		$limit 		= $this->get('limit') !== false ? $this->get('limit') : 100;								
		$sort 	 	= $this->get("sort");		
		$data["results"] = array();
		$data["count"] = 0;

		$obj = new Invoice_line(null, $this->_database);		

		//Sort
		if(!empty($sort) && isset($sort)){					
			foreach ($sort as $value) {
				$obj->order_by($value["field"], $value["dir"]);
			}
		}
		
		//Filter		
		if(!empty($filters) && isset($filters)){			
	    	foreach ($filters as $value) {	    			    			
	    		$obj->where_related("invoice", $value["field"], $value["value"]);	    		
			}									 			
		}

		$obj->where_in_related("invoice", "type", array("Invoice", "Receipt", "Purchase", "Adjustment"));		
		
		//Results
		$obj->get_paged_iterated($page, $limit);
		$data["count"] = $obj->paged->total_rows;							

		if($obj->result_count()>0){
			foreach ($obj as $value) {
				$data["results"][] = array(
					"id" 			=> $value->id,
					"item_id" 		=> $value->item_id,
					"on_hand" 		=> intval($value->on_hand),
					"unit" 			=> intval($value->unit),
					"cost" 			=> floatval($value->cost),
					"price" 		=> floatval($value->price),
					"amount" 		=> floatval($value->amount),
					"rate" 			=> floatval($value->rate),
					"locale" 		=> $value->locale,
					"movement" 		=> intval($value->movement),										
					"issued_date" 	=> $value->issued_date,							
					
					"invoice" 		=> $value->invoice->get_raw()->result(),
					"item" 			=> $value->item->get_raw()->result()				
				);
			}
		}				

		//Response Data		
		$this->response($data, 200);	
	}

	//GET INVENTORY SALE BY ITEM
	function inventory_sale_by_item_get() {		
		$filters 	= $this->get("filter")["filters"];		
		$page 		= $this->get('page') !== false ? $this->get('page') : 1;		
		$limit 		= $this->get('limit') !== false ? $this->get('limit') : 100;								
		$sort 	 	= $this->get("sort");		
		$data["results"] = array();
		$data["count"] = 0;

		$obj = new Item(null, $this->_database);		

		//Sort
		if(!empty($sort) && isset($sort)){					
			foreach ($sort as $value) {
				$obj->order_by($value["field"], $value["dir"]);
			}
		}
		
		$obj->where("item_type_id", 1);
		$obj->where("is_catalog", 0);
		$obj->where("is_assemble", 0);		
		
		//Results
		$obj->get_paged_iterated($page, $limit);
		$data["count"] = $obj->paged->total_rows;							

		if($obj->result_count()>0){
			foreach ($obj as $value) {
				$record = $value->invoice_line;				
				
				if(!empty($filters) && isset($filters)){			
			    	foreach ($filters as $val) {			    				
			    		$record->where_related("invoice", $val["field"], $val["value"]);		    		
					}									 			
				}
				$record->get();
				
				$qty = 0; $cost = 0; $price = 0;
				foreach ($record as $r) {
					$qty += intval($r->unit);
					$price = floatval($r->price_avg);
					$cost = floatval($r->cost);
				}				

				$data["results"][] = array(
					"id" 			=> $value->id,
					"item_id" 		=> $value->item_id,
					"category_id" 	=> $value->category_id,
					"item_group_id" => $value->item_group_id,					
					"sku"			=> $value->sku,
					"name" 			=> $value->name,									
					"category" 		=> $value->category->get_raw()->result(),
					"item_group" 	=> $value->item_group->get_raw()->result(),
					"qty" 			=> $qty,
					"price" 		=> $price,
					"cost" 			=> $cost
				);
			}
		}		

		//Response Data		
		$this->response($data, 200);	
	}

	//GET INVENTORY TURNOVER LIST
	function inventory_turnover_list_get() {		
		$filters 	= $this->get("filter")["filters"];		
		$page 		= $this->get('page') !== false ? $this->get('page') : 1;		
		$limit 		= $this->get('limit') !== false ? $this->get('limit') : 100;								
		$sort 	 	= $this->get("sort");		
		$data["results"] = array();
		$data["count"] = 0;

		$obj = new Item(null, $this->_database);		

		//Sort
		if(!empty($sort) && isset($sort)){					
			foreach ($sort as $value) {
				$obj->order_by($value["field"], $value["dir"]);
			}
		}
		
		$obj->where("item_type_id", 1);
		$obj->where("is_catalog", 0);
		$obj->where("is_assemble", 0);		
		
		//Results
		$obj->get_paged_iterated($page, $limit);
		$data["count"] = $obj->paged->total_rows;							

		if($obj->result_count()>0){
			foreach ($obj as $value) {
				$sale = new Invoice_line(null, $this->_database);
				$record = $value->invoice_line;				
				$edate = date("Y-m-d");				

				if(!empty($filters) && isset($filters)){			
			    	foreach ($filters as $val) {			    		
			    		$record->where_related("invoice", $val["field"], $val["value"]);
			    		$edate = $val["value"];			    				    		
					}									 			
				}
				$record->order_by_related("invoice", "issued_date", "desc");
				$record->limit(1);
				$record->get();
				
				$inventory = floatval($record->on_hand) * floatval($record->cost);				

				$sdate = date('Y', strtotime($edate)).'-01-01';
				$diff = strtotime($edate) - strtotime($sdate);
				$diff = floor($diff/(60*60*24));

				$sale->select_sum("unit");
				$sale->where_related("invoice", "issued_date >=", $sdate);
				$sale->where_related("invoice", "issued_date <=", $edate);
				$sale->where_in_related("invoice", "type", array("Invoice", "Receipt"));
				$sale->get();
				
				$cogs = intval($sale->unit) * floatval($record->cost);

				$days = 0;
				if($cogs>0){
					$days = ($inventory / $cogs) * $diff;
				}

				$data["results"][] = array(
					"id" 			=> $value->id,					
					"category_id" 	=> $value->category_id,
					"item_group_id" => $value->item_group_id,					
					"sku"			=> $value->sku,
					"name" 			=> $value->name,									
					"category" 		=> $value->category->get_raw()->result(),
					"item_group" 	=> $value->item_group->get_raw()->result(),					
					"cost" 			=> $inventory,
					"days" 			=> $days
				);
			}
		}		

		//Response Data		
		$this->response($data, 200);	
	}

	//GET INVENTORY MOVEMENT SUMMARY
	function inventory_movement_summary_get() {		
		$filters 	= $this->get("filter")["filters"];		
		$page 		= $this->get('page') !== false ? $this->get('page') : 1;		
		$limit 		= $this->get('limit') !== false ? $this->get('limit') : 100;								
		$sort 	 	= $this->get("sort");		
		$data["results"] = [];
		$data["count"] = 0;

		$obj = new Item(null, $this->_database);		

		//Sort
		if(!empty($sort) && isset($sort)){					
			foreach ($sort as $value) {
				$obj->order_by($value["field"], $value["dir"]);
			}
		}
		
		$obj->where("item_type_id", 1);
		$obj->where("is_catalog", 0);
		$obj->where("is_assemble", 0);		
		
		//Results
		$obj->get_paged_iterated($page, $limit);
		$data["count"] = $obj->paged->total_rows;							

		if($obj->exists()){
			foreach ($obj as $value) {
				$begin = new Invoice_line(null, $this->_database);
				$purchase = new Invoice_line(null, $this->_database);
				$sale = new Invoice_line(null, $this->_database);
				$adj = new Invoice_line(null, $this->_database);							
				
				if(!empty($filters) && isset($filters)){			
			    	foreach ($filters as $val) {			    				
			    		$begin->where_related("invoice", $val["field"], $val["value"]);
			    		$purchase->where_related("invoice", $val["field"], $val["value"]);
			    		$sale->where_related("invoice", $val["field"], $val["value"]);
			    		$adj->where_related("invoice", $val["field"], $val["value"]);		    		
					}									 			
				}
				
				//Begining
				$begin->where("item_id", $value->id);
				$begin->order_by_related("invoice", "issued_date", "asc");
				$begin->limit(1);
				$begin->get();

				//Purchase
				$purchase->where("item_id", $value->id);
				$purchase->select_sum("unit");
				$purchase->where_related("invoice", "type", "PO");							
				$purchase->get();

				//Sale
				$sale->where("item_id", $value->id);
				$sale->select_sum("unit");
				$sale->where_related("invoice", "type", "SO");							
				$sale->get();

				//Adjustment
				$adj->where("item_id", $value->id);
				$adj->select_sum("unit");
				$adj->where_related("invoice", "type", "Adjustment");							
				$adj->get();

				$data["results"][] = array(
					"id" 			=> $value->id,					
					"category_id" 	=> $value->category_id,
					"item_group_id" => $value->item_group_id,					
					"sku"			=> $value->sku,
					"name" 			=> $value->name,									
					"category" 		=> $value->category->get_raw()->result(),
					"item_group" 	=> $value->item_group->get_raw()->result(),
					"begining" 		=> intval($begin->on_hand),
					"purchase" 		=> intval($purchase->unit),
					"adjustment" 	=> intval($adj->unit),
					"sale" 			=> intval($sale->unit)
				);
			}
		}		

		//Response Data		
		$this->response($data, 200);	
	}

	//GET INVENTORY MOVEMENT DETAIL
	function inventory_movement_detail_get() {		
		$filters 	= $this->get("filter")["filters"];		
		$page 		= $this->get('page') !== false ? $this->get('page') : 1;		
		$limit 		= $this->get('limit') !== false ? $this->get('limit') : 100;								
		$sort 	 	= $this->get("sort");		
		$data["results"] = [];
		$data["count"] = 0;

		$obj = new Invoice_line(null, $this->_database);		

		//Sort
		if(!empty($sort) && isset($sort)){					
			foreach ($sort as $value) {
				$obj->order_by($value["field"], $value["dir"]);
			}
		}
			
		//Filter		
		if(!empty($filters) && isset($filters)){			
	    	foreach ($filters as $value) {	    			    			
	    		$obj->where_related("invoice", $value["field"], $value["value"]);	    		
			}									 			
		}

		$obj->where_in_related("invoice", "type", array("Invoice", "Receipt", "Purchase", "Adjustment"));		
		
		//Results
		$obj->get_paged_iterated($page, $limit);
		$data["count"] = $obj->paged->total_rows;							

		if($obj->result_count()>0){
			foreach ($obj as $value) {
				if($value->item_id>0){
					$data["results"][] = array(
						"id" 			=> $value->id,
						"item_id" 		=> $value->item_id,
						"on_hand" 		=> intval($value->on_hand),
						"unit" 			=> intval($value->unit),
						"cost" 			=> floatval($value->cost),
						"price" 		=> floatval($value->price),
						"amount" 		=> floatval($value->amount),
						"rate" 			=> floatval($value->rate),
						"locale" 		=> $value->locale,
						"movement" 		=> intval($value->movement),											
						
						"invoice" 		=> $value->invoice->get_raw()->result(),						
						"item" 			=> $value->item->get_raw()->result()								
					);
				}
			}
		}				

		//Response Data		
		$this->response($data, 200);	
	}

	//GET PURCHASE BY VENDOR SUMMARY
	function purchase_by_vendor_summary_get() {		
		$filters 	= $this->get("filter")["filters"];		
		$page 		= $this->get('page') !== false ? $this->get('page') : 1;		
		$limit 		= $this->get('limit') !== false ? $this->get('limit') : 100;								
		$sort 	 	= $this->get("sort");		
		$data["results"] = [];
		$data["count"] = 0;

		$obj = new Contact(null, $this->_database);		

		//Sort
		if(!empty($sort) && isset($sort)){					
			foreach ($sort as $value) {
				$obj->order_by($value["field"], $value["dir"]);
			}
		}

		$obj->where_related("contact_type", "parent_id", 2);		
				
		//Results
		$obj->get_paged_iterated($page, $limit);
		$data["count"] = $obj->paged->total_rows;							

		if($obj->exists()){
			foreach ($obj as $value) {
				$line = new Invoice_line(null, $this->_database);

				if(!empty($filters) && isset($filters)){			
			    	foreach ($filters as $val) {			    				
			    		$line->where_related("invoice", $val["field"], $val["value"]);			    				    		
					}									 			
				}

				$line->select_sum("amount");
				$line->select_sum("unit");
				$line->where_related("invoice", "contact_id", $value->id);
				$line->where_related("invoice", "type", "Purchase");
				$line->get();

				if($line->amount>0){
					$data["results"][] = array(
						"id" 			=> $value->id,					
						"name" 			=> $value->company,					
						"unit" 		=> intval($line->unit),
						"amount" 		=> floatval($line->amount)
					);
				}
			}
		}		

		//Response Data		
		$this->response($data, 200);	
	}

	//GET PURCHASE BY VENDOR SUMMARY
	function purchase_by_vendor_detail_get() {		
		$filters 	= $this->get("filter")["filters"];		
		$page 		= $this->get('page') !== false ? $this->get('page') : 1;		
		$limit 		= $this->get('limit') !== false ? $this->get('limit') : 100;								
		$sort 	 	= $this->get("sort");		
		$data["results"] = [];
		$data["count"] = 0;

		$obj = new Invoice_line(null, $this->_database);		

		//Sort
		if(!empty($sort) && isset($sort)){					
			foreach ($sort as $value) {
				$obj->order_by($value["field"], $value["dir"]);
			}
		}

		if(!empty($filters) && isset($filters)){			
	    	foreach ($filters as $val) {			    				
	    		$obj->where_related("invoice", $val["field"], $val["value"]);			    				    		
			}									 			
		}		
		
		$obj->include_related('invoice', array('number','type','issued_date'));
		$obj->include_related('invoice/contact', 'company');
		$obj->where_related("invoice", "type", "Purchase");
				
		//Results
		$obj->get_paged_iterated($page, $limit);
		$data["count"] = $obj->paged->total_rows;							

		if($obj->exists()){
			foreach ($obj as $value) {				
				$data["results"][] = array(
					"id" 			=> $value->id,
					"item_id" 		=> $value->item_id,
					"issued_date" 	=> $value->invoice_issued_date,
					"number" 		=> $value->invoice_number,
					"type" 			=> $value->invoice_type,										
					"name" 			=> $value->invoice_contact_company,
					"item" 			=> $value->item->get_raw()->result(),
					"unit" 			=> intval($value->unit),
					"price" 		=> floatval($value->price),					
					"amount" 		=> floatval($value->amount)
				);				
			}
		}		

		//Response Data		
		$this->response($data, 200);	
	}

	//GET SUMMARY
	function summary_get() {		
		$filters 	= $this->get("filter")["filters"];		
		$page 		= $this->get('page') !== false ? $this->get('page') : 1;		
		$limit 		= $this->get('limit') !== false ? $this->get('limit') : 100;								
		$sort 	 	= $this->get("sort");		
		$data["results"] = [];
		$data["count"] = 0;

		$obj = new Item(null, $this->_database);		

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
		    			$obj->where_related($value["model"], $value["field"], $value["value"]);
		    		}else if($value["operator"]=="where_in_related"){
		    			$obj->where_in_related($value["model"], $value["field"], $value["value"]);		    			    		
		    		}else{
		    			$obj->where($value["field"], $value["value"]);
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
				if($value->item_id>0){
					$data["results"][] = array(
						"id" 			=> $value->id,
						"item_id" 		=> $value->item_id,
						"on_hand" 		=> intval($value->on_hand),
						"unit" 			=> intval($value->unit),
						"cost" 			=> floatval($value->cost),
						"price" 		=> floatval($value->price),
						"amount" 		=> floatval($value->amount),
						"rate" 			=> floatval($value->rate),
						"locale" 		=> $value->locale,
						"movement" 		=> intval($value->movement),											
						
						"invoice" 		=> $value->invoice->get_raw()->result(),						
						"item" 			=> $value->item->get_raw()->result()								
					);
				}
			}
		}				

		//Response Data		
		$this->response($data, 200);	
	}

	//GET MOVEMENT
	function movement_get() {		
		$filters 	= $this->get("filter")["filters"];		
		$page 		= $this->get('page') !== false ? $this->get('page') : 1;		
		$limit 		= $this->get('limit') !== false ? $this->get('limit') : 100;								
		$sort 	 	= $this->get("sort");		
		$data["results"] = [];
		$data["count"] = 0;

		$obj = new Invoice_line(null, $this->_database);		

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
		    			$obj->where_related($value["model"], $value["field"], $value["value"]);
		    		}else if($value["operator"]=="where_in_related"){
		    			$obj->where_in_related($value["model"], $value["field"], $value["value"]);		    			    		
		    		}else{
		    			$obj->where($value["field"], $value["value"]);
		    		}
	    		}else{	    			
	    			$obj->where($value["field"], $value["value"]);	    				    			
	    		}
			}									 			
		}

		$obj->order_by_related("invoice", "issued_date", "desc");
				
		//Results
		$obj->get_paged_iterated($page, $limit);
		$data["count"] = $obj->paged->total_rows;							

		if($obj->result_count()>0){
			foreach ($obj as $value) {
				if($value->item_id>0){
					$data["results"][] = array(
						"id" 			=> $value->id,
						"item_id" 		=> $value->item_id,
						"on_hand" 		=> intval($value->on_hand),
						"unit" 			=> intval($value->unit),
						"cost" 			=> floatval($value->cost),
						"price" 		=> floatval($value->price),
						"amount" 		=> floatval($value->amount),
						"rate" 			=> floatval($value->rate),
						"locale" 		=> $value->locale,
						"movement" 		=> intval($value->movement),											
						
						"invoice" 		=> $value->invoice->get_raw()->result(),						
						"item" 			=> $value->item->get_raw()->result()								
					);
				}
			}
		}				

		//Response Data		
		$this->response($data, 200);	
	}	


	//Bong Rith
	public function item_get() {
		$requested_data = $this->get('filter');
		$filters = $requested_data['filters'];
		$limit = $this->get('limit') !== false ? $this->get('limit') : 100;
		$page = $this->get('page') !== false ? $this->get('page') : 1;

		$items = new Item(null, $this->_database);
		if(isset($filters)) {
			foreach($filters as $f) {
				if(!empty($f["operator"]) && isset($f["operator"])){
					if($f["operator"]=="where_in"){
		    			$items->where_in($f["field"], $f["value"]);
		    		}
				}else{
					$items->where($f['field'], $f['value']);
				}
			}
		} 
		$items->include_related('category', null);
		$items->get_paged($page, $limit);
		
		if($items->exists()) {
			$this->benchmark->mark('benchmark_start');
			foreach($items as $item) {
				$item->item->get();
				if($item->item->exists()) {
					$main = array(
							'id' 	=> $item->item->id,
							'sku'	=> $item->item->sku,
							'name'	=> $item->item->name
						);
				} else {
					$main = null;
				}
				$income = $item->income_account->get();
				$cogs = $item->cogs_account->get();
				$inventory = $item->inventory_account->get();
				$accounts = array();
				if($item->income_account->exists()) {
					// taken out
					$accounts[] = array('id' => $income->id, 'name'=>$income->name, 'type'=> 'income');
				}
				if($item->cogs_account->exists()) {
					// taken out
					$accounts[] = array('id' => $cogs->id, 'name'=>$cogs->name, 'type'=> 'cogs');
				}
				if($item->inventory_account->exists()) {
					// when purchase
					$accounts[] = array('id' => $inventory->id, 'name'=>$inventory->name, 'type'=> 'inventory');
				}
				$data[] = array(
						'id' 		=> intval($item->id),
						'sku' 		=> $item->sku,
						'name'		=> $item->name,
						'description'=> $item->description,
						'cost'		=> floatval($item->cost),
						'on_hand'	=> intval($item->on_hand),
						'main'		=> $main,
						'category'  => array(
							'id'	=> $item->category_id,
							'name' => $item->category_name
						),
						'accounts' 	=> $accounts
				);
			}
			$this->benchmark->mark('benchmark_end');
			$this->response(array('results'=>$data, 'msg' => 'result found', 'count'=>$items->paged->total_rows, 'generatedIn'=>$this->benchmark->elapsed_time('benchmark_start', 'benchmark_end')), 200);
		} else {
			$this->response(array('error'=>'no criteria.', 'msg' => 'no result found'), 200);	
		}
	}

	public function item_post() {
		$requested_data = json_decode($this->post('models'));
		$data = array();
		foreach($requested_data as $j) {
			$item = new Item(null, $this->_database);
			$item->sku = $j->sku;
			$item->name = $j->name;
			$item->description = $j->description;
			$item->cost = $j->cost;
			$item->order_point = $j->order_point;
			$item->on_hand = $j->on_hand;
			$item->main_id = $j->main->id;
				
			foreach($j->accounts as $account) {
				if($account->type === 'income') {
					$item->income_account_id = $account->id;
				}
				if($account->type === 'cogs') {
					$item->cogs_account_id = $account->id;
				}
				if($account->type === 'inventory') {
					$item->inventory_account_id = $account->id;
				}
			}

			if($item->save()) {
				$income = $item->income_account->get();
				$cogs   = $item->cogs_account->get();
				$inventory = $item->inventory_account->get();
				$data[] = array(
						'id' 		=> intval($item->id),
						'sku' 		=> $item->sku,
						'name'		=> $item->name,
						'description'=> $item->description,
						'cost'		=> floatval($item->cost),
						'on_hand'	=> intval($item->on_hand),
						'main'		=> $main,
						'category'  => array(
							'id'	=> $item->category_id,
							'name' => $item->category_name
						),
						'accounts' 	=> array(
							array('id' => $income->id, 'name'=>$income->name, 'type'=> 'income'),
							array('id' => $cogs->id, 'name'=>$cogs->name, 'type'=> 'cogs'),
							array('id' => $inventory->id, 'name'=>$inventory->name, 'type'=> 'inventory')
						)
				);
			}	
		}
		if(count($data)>0) {
			$this->response(array('results'=>$data, 'count'=>count($data)), 200);
		} else {
			$this->response(array('error'=>array('code'=>400, 'msg'=>'can not create.'), 'count'=>count($data)), 200);
		}
	}

	public function item_put() {
		$requested_data = json_decode($this->put('models'));
		$data = array();

		foreach($requested_data as $j) {
			$item = new Item(null, $this->_database);
			$item->where('id', $j->id)->get();
			$item->sku = $j->sku;
			$item->name = $j->name;
			$item->description = $j->description;
			$item->cost = $j->cost;
			$item->order_point = $j->order_point;
			$item->on_hand = $j->on_hand;
			$item->main_id = $j->main->id;
			if($item->save()) {
				$income = $item->income_account->get();
				$cogs = $item->cogs_account->get();
				$inventory = $item->inventory_account->get();
				$accounts = array();
				if($item->income_account->exists()) {
					$accounts[] = array('id' => $income->id, 'name'=>$income->name, 'type'=> 'income');
				}
				if($item->cogs_account->exists()) {
					$accounts[] = array('id' => $cogs->id, 'name'=>$cogs->name, 'type'=> 'cogs');
				}
				if($item->inventory_account->exists()) {
					$accounts[] = array('id' => $inventory->id, 'name'=>$inventory->name, 'type'=> 'inventory');
				}
				$data[] = array(
						'id' 		=> intval($item->id),
						'sku' 		=> $item->sku,
						'name'		=> $item->name,
						'description'=> $item->description,
						'cost'		=> floatval($item->cost),
						'on_hand'	=> intval($item->on_hand),
						'main'		=> $main,
						'category'  => array(
							'id'	=> $item->category_id,
							'name' => $item->category_name
						),
						'accounts' 	=> $accounts
				);
			}	
		}
		if(count($data)>0) {
			$this->response(array('results'=>$data, 'count'=>count($data)), 200);
		} else {
			$this->response(array('error'=>array('code'=>400, 'msg'=>'can not create.'), 'count'=>count($data)), 200);
		}
	}

	public function item_delete() {
		$requested_data = json_decode($this->put('models'));
		$data = array();

		foreach($requested_data as $j) {
			$item = new Journal();
			$item->where('id', $j->id)->get();
			$item->deleted = 'true';
			
			if($item->save()) {
				$income = $item->income_account->get();
				$cogs = $item->cogs_account->get();
				$inventory = $item->inventory_account->get();
				$accounts = array();
				if($item->income_account->exists()) {
					$accounts[] = array('id' => $income->id, 'name'=>$income->name, 'type'=> 'income');
				}
				if($item->cogs_account->exists()) {
					$accounts[] = array('id' => $cogs->id, 'name'=>$cogs->name, 'type'=> 'cogs');
				}
				if($item->inventory_account->exists()) {
					$accounts[] = array('id' => $inventory->id, 'name'=>$inventory->name, 'type'=> 'inventory');
				}
				$data[] = array(
						'id' 		=> intval($item->id),
						'sku' 		=> $item->sku,
						'name'		=> $item->name,
						'description'=> $item->description,
						'cost'		=> floatval($item->cost),
						'on_hand'	=> intval($item->on_hand),
						'main'		=> $main,
						'category'  => array(
							'id'	=> $item->category_id,
							'name' => $item->category_name
						),
						'accounts' 	=> $accounts
				);
			}	
		}
		if(count($data)>0) {
			$this->response(array('results'=>$data, 'count'=>count($data)), 200);
		} else {
			$this->response(array('error'=>array('code'=>400, 'msg'=>'can not create.'), 'count'=>count($data)), 200);
		}
	}

	// get all records based on item id
	public function records_get() {}

	// models = {id: null, amount: 0.00, unit: 1, is_in: true, item:{id: 1, sku: 'ewew', name: 'dfsfds'}}
	public function records_post() {
		$requested_data = json_decode($this->post('models'));
		// weighted average cost formula
		// (cost beginning + cost purchase) / (inventory unit beginning + inventory purchase)
		// cost begining = cost before purchase; inventory unit beginning = inventory before purchase
		$data = array();
		foreach($requested_data as $res) {
			$entry = new Itemrecord(null, $this->_database);
			$entry->item_id = $res->item->id;
			$entry->amount = floatval($res->amount);
			$entry->unit = intval($res->unit);
			$entry->is_in = $res->is_in;
				
			if($entry->save()){
				$item = new Item(null, $this->_database);
				$item->where('id', $res->item->id)->get();
				// $data[] = array('is_in'=>$entry->is_in);
				if($entry->is_in === true) {
					$cost = floatval($item->cost) * intval($item->on_hand);
					$wac = ($cost + ($res->amount * $res->unit)) / ($item->on_hand + $res->unit);
					$item->cost = $wac;
					$item->on_hand = $entry->unit + $item->on_hand;
				} else {
					$item->on_hand = $item->on_hand - $res->unit;
				}
				if($item->save()) {
					$data[] = array(
						'id' => $entry->id,
						'amount' => floatval($entry->amount),
						'is_in' =>  $entry->is_in,
						'unit' => intval($entry->unit),
						'item' =>  $res->item
					);
				}
			}
		}
		if(count($data) > 0) {
			$this->response(array('results'=>$data, 'count'=>count($data)), 201);
		} else {
			$this->response(array('error'=>array('msg'=>'no data was saved'), 'count'=>count($data)), 200);
		}
	}

	// item adjust	
	public function records_put() {
		// take wac as base
		$requested_data = json_decode($this->put('models'));
		$data = array();
		foreach($requested_data as $res) {
			$record = new Itemrecord(null, $this->_database);
			$record->where('id', $res->id)->get();

			$item = new Item(null, $this->_database);
			$item->where('id', $res->item->id)->get();
			if($res->is_in) {
				if($res->unit > $record->unit) {
					// add to on hand
					$temp = intval($res->unit) - intval($record->unit);
					$tUnit= intval($item->unit);
					$item->unit = $tUnit + $temp;
					$item->save();
				} else {
					// deduct from on hand
					$temp = intval($record->unit) - intval($res->unit);
					$tUnit= intval($item->unit);
					$item->unit = $tUnit - $temp;
					$item->save();
				}
			}
		}
	}

	public function records_delete() {

	}

	public function tax_get() {
		$items = new Item(null, $this->_database);
		// if(isset($filters)) {
		// 	foreach($filters as $f) {
		// 		if(!empty($f["operator"]) && isset($f["operator"])){
		// 			if($f["operator"]=="where_in"){
		//     			$items->where_in($f["field"], $f["value"]);
		//     		}
		// 		}else{
		// 			$items->where($f['field'], $f['value']);
		// 		}
		// 	}
		// } 
		$items->where('item_type_id', 6)->get();
		if($items->exists()) {
			foreach($items as $item) {
				$data[] = array('id' => $item->id, 'name' => $item->name, 'rate' => $item->cost);
			}
			
 		}
 		if(count($data) > 0) {
 			$this->response(array('error' => false, 'results' => $data), 200);
 		} else {
 			$this->response(array('error' => true, 'results' => array()), 200);
 		}
	}
}