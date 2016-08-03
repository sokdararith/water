<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); //disallow direct access to this file

require APPPATH.'/libraries/REST_Controller.php';

class Invoices extends REST_Controller {	
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

		$obj = new Invoice(null, $this->entity);		

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
				$data["results"][] = array(
					"id" 				=> $value->id,
					"company_id" 		=> $value->company_id,
					"location_id" 		=> $value->location_id,
					"contact_id" 		=> $value->contact_id,					
					"payment_term_id" 	=> $value->payment_term_id,
					"payment_method_id" => $value->payment_method_id,
					"reference_id" 		=> $value->reference_id,					
					"account_id" 		=> $value->account_id,					
					"vat_id"			=> $value->vat_id,
					"biller_id" 		=> $value->biller_id,					   			   						   
				   	"number" 			=> $value->number,
				   	"type" 				=> $value->type,
				   	"sub_total"			=> floatval($value->sub_total),			   	
				   	"amount" 			=> floatval($value->amount),
				   	"amount_paid"		=> floatval($value->amount_paid),
				   	"deposit"			=> floatval($value->deposit),
				   	"fine" 				=> floatval($value->fine),
				   	"discount" 			=> floatval($value->discount),
				   	"vat" 				=> floatval($value->vat),
				   	"rate" 				=> floatval($value->rate),
				   	"locale" 			=> $value->locale,
				   	"month_of"			=> $value->month_of,
				   	"issued_date"		=> $value->issued_date,
				   	"payment_date" 		=> $value->payment_date,
				   	"due_date" 			=> $value->due_date,
				   	"deposit_date" 		=> $value->deposit_date,
				   	"check_no" 			=> $value->check_no,
				   	"segments" 			=> explode(",", $value->segments),				   	
				   	"bill_to" 			=> $value->bill_to,
				   	"ship_to" 			=> $value->ship_to,
				   	"memo" 				=> $value->memo,
				   	"memo2" 			=> $value->memo2,
				   	"status" 			=> $value->status,				   	
				   	"print_count" 		=> $value->print_count,
				   	"printed_by" 		=> $value->printed_by,
				   	"deleted" 			=> $value->deleted,

				   	"company" 			=> $value->company->get_raw()->result(),
				   	"contact" 			=> $value->contact->get_raw()->result()
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
				
		$number = "";
		foreach ($models as $value) {
			if($number==""){				
				$number = $this->_generate_number($value->type);
			}else{
				$last_no = $number;
				$header = substr($last_no, 0, -5);
				$no = intval(substr($last_no, strlen($last_no) - 5));
				$no++;
				$number = $header . str_pad($no, 5, "0", STR_PAD_LEFT);
			}

			$obj = new Invoice(null, $this->entity);
			isset($value->company_id) 			? $obj->company_id 			= $value->company_id : "";
			isset($value->location_id) 			? $obj->location_id 		= $value->location_id : "";
			isset($value->contact_id) 			? $obj->contact_id 			= $value->contact_id : "";				
			isset($value->payment_term_id) 		? $obj->payment_term_id 	= $value->payment_term_id : "";
			isset($value->payment_method_id) 	? $obj->payment_method_id 	= $value->payment_method_id : "";
			isset($value->reference_id) 		? $obj->reference_id 		= $value->reference_id : "";			
			isset($value->account_id) 			? $obj->account_id 			= $value->account_id : "";			
			isset($value->vat_id) 				? $obj->vat_id 				= $value->vat_id : "";
			isset($value->biller_id) 			? $obj->vat_id 				= $value->biller_id : "";
												  $obj->number 				= $number;		   	
		   	isset($value->type) 				? $obj->type 				= $value->type : "";
		   	isset($value->sub_total) 			? $obj->sub_total 			= $value->sub_total : "";
		   	isset($value->amount) 				? $obj->amount 				= $value->amount : "";
		   	isset($value->amount_paid) 			? $obj->amount_paid 		= $value->amount_paid : "";
		   	isset($value->fine) 				? $obj->fine 				= $value->fine : "";
		   	isset($value->discount) 			? $obj->discount 			= $value->discount : "";
		   	isset($value->vat) 					? $obj->vat 				= $value->vat : 0;
		   	isset($value->rate) 				? $obj->rate 				= $value->rate : "";
		   	isset($value->locale) 				? $obj->locale 				= $value->locale : "";
		   	isset($value->month_of) 			? $obj->month_of 			= $value->month_of : "";
		   	isset($value->issued_date) 			? $obj->issued_date 		= $value->issued_date : "";
		   	isset($value->payment_date) 		? $obj->payment_date 		= $value->payment_date : "";
		   	isset($value->due_date) 			? $obj->due_date 			= $value->due_date : "";		   	
		   	isset($value->check_no) 			? $obj->check_no 			= $value->check_no : "";
		   	isset($value->segments) 			? $obj->segments 			= implode(",", $value->segments) : "";
		   	isset($value->bill_to) 				? $obj->bill_to 			= $value->bill_to : "";
		   	isset($value->ship_to) 				? $obj->ship_to 			= $value->ship_to : "";
		   	isset($value->memo) 				? $obj->memo 				= $value->memo : "";
		   	isset($value->memo2) 				? $obj->memo2 				= $value->memo2 : "";
		   	isset($value->status) 				? $obj->status 				= $value->status : "";		   	
		   	isset($value->print_count) 			? $obj->print_count 		= $value->print_count : "";
		   	isset($value->printed_by) 			? $obj->printed_by 			= $value->printed_by : "";
		   	isset($value->deleted) 				? $obj->deleted 			= $value->deleted : "";		   		   	

	   		if($obj->save()){
			   	$data["results"][] = array(
			   		"id" 				=> $obj->id,
					"company_id" 		=> $obj->company_id,
					"location_id" 		=> $obj->location_id,
					"contact_id" 		=> $obj->contact_id,					
					"payment_term_id" 	=> $obj->payment_term_id,
					"payment_method_id" => $obj->payment_method_id,
					"reference_id" 		=> $obj->reference_id,					
					"account_id" 		=> $obj->account_id,					
					"vat_id"			=> $obj->vat_id,
					"biller_id" 		=> $obj->biller_id,					   			   						   
				   	"number" 			=> $obj->number,
				   	"type" 				=> $obj->type,
				   	"sub_total"			=> floatval($obj->sub_total),			   	
				   	"amount" 			=> floatval($obj->amount),
				   	"amount_paid"		=> floatval($obj->amount_paid),
				   	"deposit"			=> floatval($obj->deposit),
				   	"fine" 				=> floatval($obj->fine),
				   	"discount" 			=> floatval($obj->discount),
				   	"vat" 				=> floatval($obj->vat),
				   	"rate" 				=> floatval($obj->rate),
				   	"locale" 			=> $obj->locale,
				   	"month_of"			=> $obj->month_of,
				   	"issued_date"		=> $obj->issued_date,
				   	"payment_date" 		=> $obj->payment_date,
				   	"due_date" 			=> $obj->due_date,
				   	"deposit_date" 		=> $obj->deposit_date,
				   	"check_no" 			=> $obj->check_no,
				   	"segments" 			=> explode(",", $obj->segments),				   	
				   	"bill_to" 			=> $obj->bill_to,
				   	"ship_to" 			=> $obj->ship_to,
				   	"memo" 				=> $obj->memo,
				   	"memo2" 			=> $obj->memo2,
				   	"status" 			=> $obj->status,				   	
				   	"print_count" 		=> $obj->print_count,
				   	"printed_by" 		=> $obj->printed_by,
				   	"deleted" 			=> $obj->deleted,

				   	"company" 			=> $obj->company->get_raw()->result(),
				   	"contact" 			=> $obj->contact->get_raw()->result()
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
			$obj = new Invoice(null, $this->entity);
			$obj->get_by_id($value->id);
			
			isset($value->company_id) 			? $obj->company_id 			= $value->company_id : "";
			isset($value->location_id) 			? $obj->location_id 		= $value->location_id : "";
			isset($value->contact_id) 			? $obj->contact_id 			= $value->contact_id : "";				
			isset($value->payment_term_id) 		? $obj->payment_term_id 	= $value->payment_term_id : "";
			isset($value->payment_method_id) 	? $obj->payment_method_id 	= $value->payment_method_id : "";
			isset($value->reference_id) 		? $obj->reference_id 		= $value->reference_id : "";			
			isset($value->account_id) 			? $obj->account_id 			= $value->account_id : "";			
			isset($value->vat_id) 				? $obj->vat_id 				= $value->vat_id : "";
			isset($value->biller_id) 			? $obj->vat_id 				= $value->biller_id : "";
			isset($value->number) 				? $obj->number 				= $value->number : "";		   	
		   	isset($value->type) 				? $obj->type 				= $value->type : "";
		   	isset($value->sub_total) 			? $obj->sub_total 			= $value->sub_total : "";
		   	isset($value->amount) 				? $obj->amount 				= $value->amount : "";
		   	isset($value->amount_paid) 			? $obj->amount_paid 		= $value->amount_paid : "";
		   	isset($value->fine) 				? $obj->fine 				= $value->fine : "";
		   	isset($value->discount) 			? $obj->discount 			= $value->discount : "";
		   	isset($value->vat) 					? $obj->vat 				= $value->vat : 0;
		   	isset($value->rate) 				? $obj->rate 				= $value->rate : "";
		   	isset($value->locale) 				? $obj->locale 				= $value->locale : "";
		   	isset($value->month_of) 			? $obj->month_of 			= $value->month_of : "";
		   	isset($value->issued_date) 			? $obj->issued_date 		= $value->issued_date : "";
		   	isset($value->payment_date) 		? $obj->payment_date 		= $value->payment_date : "";
		   	isset($value->due_date) 			? $obj->due_date 			= $value->due_date : "";		   	
		   	isset($value->check_no) 			? $obj->check_no 			= $value->check_no : "";
		   	isset($value->segments) 			? $obj->segments 			= implode(",", $value->segments) : "";
		   	isset($value->bill_to) 				? $obj->bill_to 			= $value->bill_to : "";
		   	isset($value->ship_to) 				? $obj->ship_to 			= $value->ship_to : "";
		   	isset($value->memo) 				? $obj->memo 				= $value->memo : "";
		   	isset($value->memo2) 				? $obj->memo2 				= $value->memo2 : "";
		   	isset($value->status) 				? $obj->status 				= $value->status : "";		   	
		   	isset($value->print_count) 			? $obj->print_count 		= $value->print_count : "";
		   	isset($value->printed_by) 			? $obj->printed_by 			= $value->printed_by : "";
		   	isset($value->deleted) 				? $obj->deleted 			= $value->deleted : "";

			if($obj->save()){				
				//Results
				$data["results"][] = array(
					"id" 				=> $obj->id,
					"company_id" 		=> $obj->company_id,
					"location_id" 		=> $obj->location_id,
					"contact_id" 		=> $obj->contact_id,					
					"payment_term_id" 	=> $obj->payment_term_id,
					"payment_method_id" => $obj->payment_method_id,
					"reference_id" 		=> $obj->reference_id,					
					"account_id" 		=> $obj->account_id,					
					"vat_id"			=> $obj->vat_id,
					"biller_id" 		=> $obj->biller_id,					   			   						   
				   	"number" 			=> $obj->number,
				   	"type" 				=> $obj->type,
				   	"sub_total"			=> floatval($obj->sub_total),			   	
				   	"amount" 			=> floatval($obj->amount),
				   	"amount_paid"		=> floatval($obj->amount_paid),
				   	"deposit"			=> floatval($obj->deposit),
				   	"fine" 				=> floatval($obj->fine),
				   	"discount" 			=> floatval($obj->discount),
				   	"vat" 				=> floatval($obj->vat),
				   	"rate" 				=> floatval($obj->rate),
				   	"locale" 			=> $obj->locale,
				   	"month_of"			=> $obj->month_of,
				   	"issued_date"		=> $obj->issued_date,
				   	"payment_date" 		=> $obj->payment_date,
				   	"due_date" 			=> $obj->due_date,
				   	"deposit_date" 		=> $obj->deposit_date,
				   	"check_no" 			=> $obj->check_no,
				   	"segments" 			=> explode(",", $obj->segments),				   	
				   	"bill_to" 			=> $obj->bill_to,
				   	"ship_to" 			=> $obj->ship_to,
				   	"memo" 				=> $obj->memo,
				   	"memo2" 			=> $obj->memo2,
				   	"status" 			=> $obj->status,				   	
				   	"print_count" 		=> $obj->print_count,
				   	"printed_by" 		=> $obj->printed_by,
				   	"deleted" 			=> $obj->deleted,

				   	"company" 			=> $obj->company->get_raw()->result(),
				   	"contact" 			=> $obj->contact->get_raw()->result()
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
			$obj = new Invoice(null, $this->entity);
			$obj->where("id", $value->id)->get();
			
			$data["results"][] = array(
				"data"   => $value,
				"status" => $obj->delete()
			);							
		}

		//Response data
		$this->response($data, 200);
	}	

	
	//LINE GET 
	function line_get() {		
		$filters 	= $this->get("filter")["filters"];		
		$page 		= $this->get('page') !== false ? $this->get('page') : 1;		
		$limit 		= $this->get('limit') !== false ? $this->get('limit') : 100;								
		$sort 	 	= $this->get("sort");		
		$data["results"] = array();
		$data["count"] = 0;

		$obj = new Invoice_line(null, $this->entity);		

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
				$priceList = [];
				if($value->item_id>0){
					$pl = new Price_list(null, $this->entity);
					$pl->where("item_id", $value->item_id);					
					$pl->get();
					foreach ($pl as $p) {
						$priceList[] = array(
							"id" 			=> $p->id,
							"currency_id" 	=> $p->currency_id,
							"product_id" 	=> $p->product_id,
							"measurement_id"=> $p->measurement_id,
							"price" 		=> floatval($p->price),
							"unit_value" 	=> floatval($p->unit_value),

							"locale" 		=> $p->currency->get()->locale,
							"measurement" 	=> $p->measurement->get()->name,
							"currency" 		=> $p->currency->get_raw()->result()
						);
					}
				}

				$data["results"][] = array(
					"id" 				=> $value->id,
			   		"invoice_id"		=> $value->invoice_id,			   		
					"item_id" 			=> $value->item_id,
					"currency_id" 		=> $value->currency_id,
					"measurement_id" 	=> $value->measurement_id,
					"meter_record_id" 	=> $value->meter_record_id,				   	
				   	"description" 		=> $value->description,
				   	"on_hand" 			=> floatval($value->on_hand),
					"on_po" 			=> floatval($value->on_po),
					"on_so" 			=> floatval($value->on_so),
					"new_qty" 			=> floatval($value->new_qty),					   	
				   	"unit" 				=> floatval($value->unit),
				   	"cost"				=> floatval($value->cost),
				   	"price"				=> floatval($value->price),
				   	"price_avg" 		=> floatval($value->price_avg),					   	
				   	"amount" 			=> floatval($value->amount),
				   	"rate"				=> floatval($value->rate),
				   	"locale" 			=> $value->locale,
				   	"has_vat" 			=> $value->has_vat,
				   	"type" 				=> $value->type,
				   	"movement" 			=> $value->movement,				   	

				   	"priceList" 		=> $priceList
				);
			}						 			
		}		
		$this->response($data, 200);		
	}
	
	//LINE POST
	function line_post() {
		$models = json_decode($this->post('models'));				
		$data["results"] = array();
		$data["count"] = 0;
		
		foreach ($models as $value) {
			$obj = new Invoice_line(null, $this->entity);			

			//Record Item			
			if(!empty($value->item_id) && isset($value->item_id)){
				if($value->item_id>0){
					$item = new Item(null, $this->entity);
					$item->get_by_id($value->item_id);

					if($item->item_type_id=="1"){
						$inv = new Invoice(null, $this->entity);
						$inv->get_by_id($value->invoice_id);

						if($inv->type=="Invoice" || $inv->type=="Receipt"){
							//Avg Price
							$lastPrice = floatval($item->on_hand) * floatval($item->price);
							$currentPrice = floatval($value->unit) * floatval($value->price);

							$item->price = ($lastPrice + $currentPrice) / (floatval($item->on_hand) + floatval($value->unit));

							$item->on_hand -= floatval($value->unit);
						}else if($inv->type=="Purchase"){
							//Avg Cost
							$lastCost = floatval($item->on_hand) * floatval($item->cost);
							$currentCost = floatval($value->unit) * floatval($value->cost);

							$item->cost = ($lastCost + $currentCost) / (floatval($item->on_hand) + floatval($value->unit));

							$item->on_hand += floatval($value->unit);
						}else if($inv->type=="Adjustment"){
							$item->on_hand += floatval($value->unit) * floatval($value->movement);
						}else{

						}

						if($item->save()){
							$po = new Invoice_line(null, $this->entity);
							$so = new Invoice_line(null, $this->entity);

							$po->select_sum("unit");
							$po->where_related("invoice", "type", "PO");
							$po->where_related("invoice", "status", 0);

							$so->select_sum("unit");
							$so->where_related("invoice", "type", "SO");
							$so->where_related("invoice", "status", 0);

							$obj->on_po = $po->count();
							$obj->on_so = $so->count();
						}
					}
				}
			}

			isset($value->invoice_id) 		? $obj->invoice_id 			= $value->invoice_id : "";			
			isset($value->item_id)			? $obj->item_id				= $value->item_id : "";
			isset($value->currency_id)		? $obj->currency_id			= $value->currency_id : "";
			isset($value->measurement_id)	? $obj->measurement_id		= $value->measurement_id : "";						
		   	isset($value->meter_record_id) 	? $obj->meter_record_id 	= $value->meter_record_id : "";
		   	isset($value->description)		? $obj->description 		= $value->description : "";
		   	// isset($value->on_hand)			? $obj->on_hand 			= $value->on_hand : "";
		   	// isset($value->on_po)			? $obj->on_po 				= $value->on_po : "";
		   	// isset($value->on_so)			? $obj->on_so 				= $value->on_so : "";
		   	isset($value->new_qty)			? $obj->new_qty 			= $value->new_qty : "";				   	
		   	isset($value->unit)				? $obj->unit 				= $value->unit : "";
		   	isset($value->cost)				? $obj->cost 				= $value->cost : "";
		   	isset($value->price)			? $obj->price 				= $value->price : "";
		   	//isset($value->price_avg)		? $obj->price_avg 			= $value->price_avg : "";				   	
		   	isset($value->amount)			? $obj->amount 				= $value->amount : "";
		   	isset($value->rate)				? $obj->rate 				= $value->rate : "";
		   	isset($value->locale)			? $obj->locale 				= $value->locale : "";
		   	isset($value->has_vat)			? $obj->has_vat  			= $value->has_vat : "";
		   	isset($value->type)				? $obj->type 				= $value->type : "";
		   	isset($value->movement)			? $obj->movement 			= $value->movement : "";

		   	if($obj->save()){
			   	$data["results"][] = array(
			   		"id" 				=> $obj->id,
			   		"invoice_id"		=> $obj->invoice_id,		   		
					"item_id" 			=> $obj->item_id,
					"currency_id" 		=> $obj->currency_id,
					"measurement_id" 	=> $obj->measurement_id,
					"meter_record_id" 	=> $obj->meter_record_id,				   	
				   	"description" 		=> $obj->description,
				   	"on_hand" 			=> floatval($obj->on_hand),
					"on_po" 			=> floatval($obj->on_po),
					"on_so" 			=> floatval($obj->on_so),
					"new_qty" 			=> floatval($obj->new_qty),					   	
				   	"unit" 				=> floatval($obj->unit),
				   	"cost"				=> floatval($obj->cost),
				   	"price"				=> floatval($obj->price),
				   	"price_avg"			=> floatval($obj->price_avg),					   	
				   	"amount" 			=> floatval($obj->amount),
				   	"rate"				=> floatval($obj->rate),
				   	"locale" 			=> $obj->locale,
				   	"has_vat" 			=> $obj->has_vat=="true"?true:false,
				   	"type" 				=> $obj->type,
				   	"movement" 			=> $obj->movement			   	
			   	);
		    }
		}		

		$data["count"] = count($data["results"]);
		$this->response($data, 201);		
	}

	//LINE PUT
	function line_put() {
		$models = json_decode($this->put('models'));
		$data["results"] = array();
		$data["count"] = 0;

		foreach ($models as $value) {			
			$obj = new Invoice_line(null, $this->entity);
			$obj->get_by_id($value->id);

			//Formula: old - new			
			if(isset($value->item_id)){
				if($value->item_id>0){
					$item = new Item(null, $this->entity);
					$item->get_by_id($value->item_id);

					//Formula 
					if($item->item_type_id=="1"){
						if($value->type=="Invoice" || $value->type=="Receipt"){
							$item->on_hand += floatval($obj->unit) - floatval($value->unit);
						}else if($value->type=="Purchase"){
							$item->on_hand += floatval($obj->unit) - floatval($value->unit);
						}else if($value->type=="Adjustment"){
							$item->on_hand += floatval($obj->unit) - (floatval($value->unit) * floatval($value->movement));
						}else{

						}

						$item->save();
					}
				}
			}

			isset($value->invoice_id) 		? $obj->invoice_id 			= $value->invoice_id : "";			
			isset($value->item_id)			? $obj->item_id				= $value->item_id : "";
			isset($value->currency_id)		? $obj->currency_id			= $value->currency_id : "";
			isset($value->measurement_id)	? $obj->measurement_id		= $value->measurement_id : "";						
		   	isset($value->meter_record_id) 	? $obj->meter_record_id 	= $value->meter_record_id : "";
		   	isset($value->description)		? $obj->description 		= $value->description : "";
		   	// isset($value->on_hand)			? $obj->on_hand 			= $value->on_hand : "";
		   	isset($value->on_po)			? $obj->on_po 				= $value->on_po : "";
		   	isset($value->on_so)			? $obj->on_so 				= $value->on_so : "";
		   	isset($value->new_qty)			? $obj->new_qty 			= $value->new_qty : "";				   	
		   	isset($value->unit)				? $obj->unit 				= $value->unit : "";
		   	isset($value->cost)				? $obj->cost 				= $value->cost : "";
		   	isset($value->price)			? $obj->price 				= $value->price : "";
		   	isset($value->price_avg)		? $obj->price_avg 			= $value->price_avg : "";				   	
		   	isset($value->amount)			? $obj->amount 				= $value->amount : "";
		   	isset($value->rate)				? $obj->rate 				= $value->rate : "";
		   	isset($value->locale)			? $obj->locale 				= $value->locale : "";
		   	isset($value->has_vat)			? $obj->has_vat  			= $value->has_vat : "";
		   	isset($value->type)				? $obj->type 				= $value->type : "";
		   	isset($value->movement)			? $obj->movement 			= $value->movement : "";
		   
			if($obj->save()){				
				//Results
				$data["results"][] = array(
					"id" 				=> $obj->id,
			   		"invoice_id"		=> $obj->invoice_id,		   		
					"item_id" 			=> $obj->item_id,
					"currency_id" 		=> $obj->currency_id,
					"measurement_id" 	=> $obj->measurement_id,
					"meter_record_id" 	=> $obj->meter_record_id,				   	
				   	"description" 		=> $obj->description,
				   	"on_hand" 			=> floatval($obj->on_hand),
					"on_po" 			=> floatval($obj->on_po),
					"on_so" 			=> floatval($obj->on_so),
					"new_qty" 			=> floatval($obj->new_qty),					   	
				   	"unit" 				=> floatval($obj->unit),
				   	"cost"				=> floatval($obj->cost),
				   	"price"				=> floatval($obj->price),
				   	"price_avg"			=> floatval($obj->price_avg),					   	
				   	"amount" 			=> floatval($obj->amount),
				   	"rate"				=> floatval($obj->rate),
				   	"locale" 			=> $obj->locale,
				   	"has_vat" 			=> $obj->has_vat=="true"?true:false,
				   	"type" 				=> $obj->type,
				   	"movement" 			=> $obj->movement
				);						
			}
		}
		$data["count"] = count($data["results"]);

		$this->response($data, 200);
	}
	
	//LINE DELETE
	function line_delete() {
		$models = json_decode($this->delete('models'));

		foreach ($models as $key => $value) {
			$obj = new Invoice_line(null, $this->entity);
			$obj->where("id", $value->id)->get();
			
			$data["results"][] = array(
				"data"   => $value,
				"status" => $obj->delete()
			);							
		}

		//Response data
		$this->response($data, 200);
	}


    //Generate invoice number
	private function _generate_number($type){		
		$header = "";
    	switch($type){
		case "Receipt":
		  	$header = "SR";
		  	break;
		case "SO":
		  	$header = "SO";
		  	break;
		case "Estimate":
		  	$header = "QO";
		  	break;
		case "GDN":
		  	$header = "GDN";
		  	break;
		case "eInvoice":
		  	$header = "EINV";
		  	break;
		case "wInvoice":
		  	$header = "WINV";
		  	break;
		case "PO":
		  	$header = "PO";
		  	break;
		case "GRN":
		  	$header = "GRN";
		  	break;
		case "Expense":
		  	$header = "EXP";
		  	break;
		case "Purchase":
		  	$header = "PUR";
		  	break;
		case "deposit":
		  	$header = "DEP";
		  	break;
		case "edeposit":
		  	$header = "EDEP";
		  	break;
		case "wdeposit":
		  	$header = "WDEP";
		  	break;						
		default:
		  	$header = "INV";
		}
		
		$YY = date("y");
		$MM = date("m");
		$headerWithDate = $header . $YY . $MM;

		$inv = new Invoice(null, $this->entity);
		$inv->where('type', $type);
		$inv->order_by('id', 'desc');
		$inv->get();

		$last_no = "";		
		if(count($inv)>0){
			$last_no = $inv->number;
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

	//GET STATEMENT
	function statement_get() {		
		$filters 	= $this->get("filter")["filters"];		
		$page 		= $this->get('page') !== false ? $this->get('page') : 1;		
		$limit 		= $this->get('limit') !== false ? $this->get('limit') : 100;								
		$sort 	 	= $this->get("sort");		
		$data["results"] = array();
		$data["count"] = 0;
		$balance_forward_date = "";

		$obj = new Invoice(null, $this->entity);
		$pay = new Payment(null, $this->entity);
		$bf = new Invoice(null, $this->entity);		

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
		    			$pay->where_in($value["field"], $value["value"]);	    				    			    		
		    		}
	    		}else{	    		    			
	    			$obj->where($value["field"], $value["value"]);

	    			if($value["field"]=="issued_date" || $value["field"]=="issued_date <=" || $value["field"]=="issued_date >="){
	    				$pay->where("payment_date", $value["value"]);
	    			}else{
	    				$pay->where($value["field"], $value["value"]);
	    			}

	    			if($value["field"]=="issued_date" || $value["field"]=="issued_date >="){
	    				$balance_forward_date = $value["value"];
	    				$bf->where("issued_date <=", $value["value"]);
	    			}
	    		}	    		
			}									 			
		}

		$obj->where_in("type", array("Invoice", "Receipt", "wInvoice"));
		$pay->where("type", "invoice");		
		
		//Results
		$obj->get();
		$pay->get();

		//Balance Forward
		if($balance_forward_date!==""){			
			$newdate = strtotime ( '-1 day' , strtotime ( $balance_forward_date ) ) ;
			$newdate = date ( 'Y-m-d' , $newdate );

			$bf->select_sum("amount");
			$bf->where_in("type", ["Invoice", "Receipt", "wInvoice"]);
			$bf->where_in("status", [0,2]);
			$bf->get();

			$data["results"][] = array(
				"id" 				=> 0,				   	
			   	"description" 		=> "Balance Forward",				   	   	
			   	"amount" 			=> floatval($bf->amount),
			   	"balance" 			=> floatval($bf->amount),			   	
			   	"rate" 				=> $bf->rate,
			   	"locale" 			=> $bf->locale,				   	
			   	"issued_date"		=> $newdate	   	
			);
		}							

		if($obj->exists()){
			foreach ($obj as $value) {
				$data["results"][] = array(
					"id" 				=> $value->id,				   	
				   	"description" 		=> $value->number,				   	   	
				   	"amount" 			=> floatval($value->amount),
				   	"balance" 			=> 0,				   	
				   	"rate" 				=> floatval($value->rate),
				   	"locale" 			=> $value->locale,				   	
				   	"issued_date"		=> $value->issued_date   	
				);
			}
		}

		if($pay->exists()){
			foreach ($pay as $value) {
				$data["results"][] = array(
					"id" 				=> $value->id,				   	
				   	"description" 		=> "PMT",				   	   	
				   	"amount" 			=> floatval($value->amount)*-1,
				   	"balance" 			=> 0,				   	
				   	"rate" 				=> floatval($value->rate),
				   	"locale" 			=> $value->locale,				   	
				   	"issued_date"		=> $value->payment_date  	
				);
			}
		}		

		//Response Data		
		$this->response($data, 200);	
	}

	//GET STATEMENT AGING
	function statement_aging_get() {		
		$filters 	= $this->get("filter")["filters"];		
		$page 		= $this->get('page') !== false ? $this->get('page') : 1;		
		$limit 		= $this->get('limit') !== false ? $this->get('limit') : 100;								
		$sort 	 	= $this->get("sort");		
		$data["results"] = [];
		$data["count"] = 0;

		$obj = new Invoice(null, $this->entity);
		
		//Filter		
		if(!empty($filters) && isset($filters)){			
	    	foreach ($filters as $value) {
	    		if(!empty($value["operator"]) && isset($value["operator"])){
		    		if($value["operator"]=="between"){
		    			$obj->where_between($value["field"], $value["value1"], $value["value2"]);	    				    			    		
		    		}else{
		    			$obj->where($value["field"].' '.$value["operator"], $value["value"]);
		    		}
	    		}else{	    			
	    			$obj->where($value["field"], $value["value"]);	    			    				    			
	    		}
			}									 			
		}

		$obj->where_in("type", array("Invoice", "wInvoice"));		
		$obj->where_in("status", array(0,2));		
		$obj->get();				

		$amount = 0;
		$current = 0;
		$oneMonth = 0;
		$twoMonth = 0;
		$threeMonth = 0;
		$overMonth = 0;
		$locale = "km-KH";

		if($obj->exists()){
			foreach ($obj as $value) {
				$today = new DateTime();
				$dueDate = new DateTime($value->due_date);
				$diff = $today->diff($dueDate)->format("%a");

				$amount += floatval($value->amount);
				$locale = $value->locale;

				if($dueDate<$today){
					if(intval($diff)>90){
						$overMonth += floatval($value->amount);
					}else if(intval($diff)>60){
						$threeMonth += floatval($value->amount);
					}else if(intval($diff)>30){
						$twoMonth += floatval($value->amount);
					}else{
						$oneMonth += floatval($value->amount);
					}
				}else{
					$current += floatval($value->amount);
				}

			}
		}

		$data["results"][] = array(
			"id" 			=> 0,				
			"current" 		=> $current,
			"oneMonth" 		=> $oneMonth,
			"twoMonth" 		=> $twoMonth,
			"threeMonth" 	=> $threeMonth,
			"overMonth" 	=> $overMonth,
			"amount" 		=> $amount,
			"locale" 		=> $locale
		);				

		//Response Data		
		$this->response($data, 200);	
	}


	//POST PAYMENT	
	function payment_post() {
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
	   			$inv = new Invoice(null, $this->entity);
	   			$inv->get_by_id($obj->reference_id);

	   			$inv->status 		= $value->status;
	   			$inv->amount_paid 	+= $value->amount;
	   			$inv->save();

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
			   	);
		    }	
		}
		
		$data["count"] = count($data["results"]);
		$this->response($data, 201);		
	}		
    
	//PRINT
	function print_get() {		
		$filters 	= $this->get("filter")["filters"];		
		$page 		= $this->get('page') !== false ? $this->get('page') : 1;		
		$limit 		= $this->get('limit') !== false ? $this->get('limit') : 100;								
		$sort 	 	= $this->get("sort");		
		$data["results"] = array();
		$data["count"] = 0;

		$obj = new Invoice(null, $this->entity);		

		//Sort
		if(!empty($sort) && isset($sort)){					
			foreach ($sort as $value) {
				$obj->order_by($value["field"], $value["dir"]);
			}
		}			

		//Filter
		foreach ($filters as $value) {
    		if($value["field"]=="id"){    					    		
    			$obj->where($value["field"], $value["value"]);    			
    		}

    		if($value["field"]=="month_of"){		    		
    			$obj->where($value["field"], $value["value"]);
    		}

    		if($value["field"]=="location_id"){		    		
    			$obj->where_related("location", "id", $value["value"]);
    		}		
		}

		$obj->include_related('contact', array('id', 'number', 'surname', 'name', 'address'));		
		$obj->include_related('company', array('name', 'mobile', 'phone', 'address', 'term_of_condition', 'image_url'));
		$obj->include_related('location', 'name');
		//$obj->include_related('invoice_line/meter_record', array('from_date', 'to_date'), FALSE);		
		// $obj->include_related('invoice_line/meter_record/meter/electricity_box', 'number');

		if(!empty($limit) && !empty($page)){
			$obj->get_paged_iterated($page, $limit);
			$data["count"] = $obj->paged->total_rows;							
		}		

		if($obj->exists()) {
			foreach ($obj as $value) {
				//Invoice Line					 
				$value->invoice_line->get();				
				$invoiceLineList = [];

				foreach ($value->invoice_line as $line) {
					$meters = array();					
					if(intval($line->meter_record_id)>0){												
			    		$mr = $line->meter_record;
			    		$mr->include_related('meter', array('number', 'multiplier', 'max_number', 'electricity_box_id'), FALSE);			    		
			    		$mr->get();
						
						$bno = "";
						if($mr->electricity_box_id){			    		
			    			$eb = new Electricity_box();
			    			$eb->get_by_id($mr->electricity_box_id);
			    			$bno = $eb->number;
			    		}

			    		$meters = array(
			    			"previous"	=> intval($mr->previous),
			    			"current" 	=> intval($mr->current),
			    			"from_date" => $mr->from_date,
			    			"to_date" 	=> $mr->to_date,

			    			"number"	=> $mr->number,
			    			"multiplier"=> $mr->multiplier,
			    			"max_number"=> $mr->max_number,			    			
			    			"electricity_box_number" => $bno
			    		);
		    		}			    		

					$invoiceLineList[] = array(
	   					"id" 				=> $line->id,
	   					"invoice_id"		=> $line->invoice_id, 	
			   			"item_id"			=> $line->item_id,				   			 	
			   			"meter_record_id" 	=> $line->meter_record_id, 
			   			"description" 		=> $line->description, 	
			   			"unit"				=> $line->unit, 		
			   			"price" 			=> floatval($line->price), 		
			   			"amount" 			=> floatval($line->amount),
			   			"rate"				=> floatval($line->rate),
			   			"locale" 			=> $line->locale, 		
			   			"has_vat" 			=> $line->has_vat,

			   			"meters" 			=> $meters				   					
	   				);
				}

				//Company
				$companies = array(
					"name" => $value->company_name,
					"mobile" => $value->company_mobile,
					"phone" => $value->company_phone,
					"address" => $value->company_address,
					"term_of_condition" => $value->company_term_of_condition,
					"image_url" => $value->company_image_url
				);

				//Customer
				$customers = array(
					"number" 	=> $value->contact_number,
					"fullname" 	=> $value->contact_surname.' '.$value->contact_name,
					"address" 	=> $value->contact_address
				);

				//Balance forward
				$bf = new Invoice(null, $this->entity);
				$bf->select_sum('amount');
				$bf->where_related('contact', 'id', $value->contact_id);
				$bf->where('status', 0);
				$bf->where('type', 'eInvoice');
				$bf->where_in('type', array('invoice', 'eInvoice'));
				$bf->where('month_of <', $value->month_of);
				$bf->get();

				$total = floatval($value->amount) + floatval($bf->amount);					

				//Results				
				$data["results"][] = array(
					"id" 				=> $value->id,
			   		"type" 				=> $value->type,				   
				   	"number" 			=> $value->number,					   
				   	"amount" 			=> floatval($value->amount),
				   	"vat" 				=> $value->vat,
				   	"rate" 				=> floatval($value->rate),
				   	"locale" 			=> $value->locale,
				   	"month_of" 			=> $value->month_of,
				   	"issued_date"		=> $value->issued_date,
				   	"payment_date" 		=> $value->payment_date,
				   	"due_date" 			=> $value->due_date,
				   	"check_no" 			=> $value->check_no,
				   	"memo" 				=> $value->memo,
				   	"memo2" 			=> $value->memo2,
				   	"status" 			=> $value->status,
				   	
				   	"total"				=> $total,
				   	"companies" 		=> $companies,
				   	"customers" 		=> $customers,
				   	"location_name" 	=> $value->location_name,				   	
				   	"balance_forward" 	=> floatval($bf->amount),
				   	"invoiceLineList" 	=> $invoiceLineList				
				);
			}
		}			

		//Response Data		
		$this->response($data, 200);		
	}

	//INVOICE TRANSACTION
	function transaction_get() {		
		$filters 	= $this->get("filter")["filters"];		
		$page 		= $this->get('page') !== false ? $this->get('page') : 1;		
		$limit 		= $this->get('limit') !== false ? $this->get('limit') : 100;								
		$sort 	 	= $this->get("sort");		
		$data["results"] = array();
		$data["count"] = 0;

		$obj = new Invoice(null, $this->entity);		

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
			if($filters[0]["field"]=="id"){
				$obj->where($filters[0]["field"], $filters[0]["value"]);
			}else{
				$obj->where($filters[0]["field"], $filters[0]["value"]);
				$obj->where_related("invoice_line/meter_record/meter", $filters[1]["field"], $filters[1]["value"]);
			}
			
			$obj->include_related('contact', array('number', 'surname', 'name'));
			
								
			$obj->get_iterated();
			if($obj->exists()) {
				foreach ($obj as $value) {
					//Results				
					$data["results"][] = array(
						
					);
				}
			}

			$data["total"] = count($data["results"]);			 			
		}

		//Response Data		
		$this->response($data, 200);		
	}

	//OUTSTANDING
	function outstanding_get(){
		$filters 	= $this->get("filter")["filters"];		
		$page 		= $this->get('page') !== false ? $this->get('page') : 1;		
		$limit 		= $this->get('limit') !== false ? $this->get('limit') : 100;								
		$sort 	 	= $this->get("sort");		
		$data["results"] = array();
		$data["count"] = 6;

		//Locale
		$locale = "km-KH";
		if(!empty($filters) && isset($filters)){
			$customer = new Contact(null, $this->entity);
			$customer->where("id", $filters[0]["value"]);
			$customer->get();			
			$locale = $customer->currency->get()->locale;						
		}else{
			$company = new Company(null, $this->entity);
			$company->get();
			foreach ($company as $value) {
				$locale = $value->currency->get()->locale;
				break;
			}			
		}
		$data["results"][] = array("locale"=>$locale);

		//Estimate
		$est = new Invoice(null, $this->entity);
		if(!empty($filters) && isset($filters)){
			$est->where($filters[0]["field"], $filters[0]["value"]);
		}
		$est->where("type", "Estimate");
		$est->where("status", 0);
		$data["results"][] = array("totalEstimate"=>$est->count());
		
		//SO
		$so = new Invoice(null, $this->entity);
		if(!empty($filters) && isset($filters)){
			$so->where($filters[0]["field"], $filters[0]["value"]);
		}
		$so->where("type", "SO");
		$so->where("status", 0);		
		$data["results"][] = array("totalSO"=>$so->count());		

		//Invoice
		$inv = new Invoice(null, $this->entity);
		if(!empty($filters) && isset($filters)){
			$inv->where($filters[0]["field"], $filters[0]["value"]);
		}
		$inv->where_in("type", array("Invoice", "eInvoice", "Notice"));
		$inv->where_in("status", array(0,2));
		$inv->get();		
		$data["results"][] = array("totalOpenInvoice"=>$inv->result_count());

		$overDue = 0;
		$bal = 0;
		foreach ($inv as $value) {
			$bal += floatval($value->amount);
			$today = new DateTime();
			$dueDate = new DateTime($value->due_date);
			if($dueDate<$today){
				$overDue++;
			}
		}
		$data["results"][] = array("totalOverDue"=>$overDue);
		$data["results"][] = array("balance"=>$bal);

		$this->response($data, 200);		
	}

	//GET MONTHLY SALE
	function monthly_sale_get() {		
		$filters 	= $this->get("filter")["filters"];		
		$page 		= $this->get('page') !== false ? $this->get('page') : 1;		
		$limit 		= $this->get('limit') !== false ? $this->get('limit') : 100;								
		$sort 	 	= $this->get("sort");		
		$data["results"] = array();
		$data["count"] = 0;

		$obj = new Invoice(null, $this->entity);
		
		//Filter		
		if(!empty($filters) && isset($filters)){			
	    	foreach ($filters as $value) {	    				
	    		$obj->where($value["field"], $value["value"]);	    		  			    		
			}									 			
		}
		
		$obj->where_in("type", ["Invoice","Receipt"]);
		$obj->where("issued_date >=", date("Y")."-01-01");
		$obj->where("issued_date <=", date("Y")."-12-31");						
		$obj->order_by("issued_date");								
		$obj->get();
		
		if($obj->result_count()>0){
			foreach ($obj as $value) {
				$data["results"][] = array(					
				   	"amount" 		=> floatval($value->amount),
				   	"month"			=> date('F', strtotime($value->issued_date))				   	
				);
			}
		}

		//Response Data		
		$this->response($data, 200);	
	}

	//GET MONTHLY EXPENSE
	function monthly_expense_get() {		
		$filters 	= $this->get("filter")["filters"];		
		$page 		= $this->get('page') !== false ? $this->get('page') : 1;		
		$limit 		= $this->get('limit') !== false ? $this->get('limit') : 100;								
		$sort 	 	= $this->get("sort");		
		$data["results"] = array();
		$data["count"] = 0;

		$obj = new Invoice(null, $this->entity);
		
		//Filter		
		if(!empty($filters) && isset($filters)){			
	    	foreach ($filters as $value) {	    				
	    		$obj->where($value["field"], $value["value"]);	    		  			    		
			}									 			
		}
		
		$obj->where_in("type", array("Purchase","Expense"));
		$obj->where("issued_date >=", date("Y")."-01-01");
		$obj->where("issued_date <=", date("Y")."-12-31");						
		$obj->order_by("issued_date");								
		$obj->get();
		
		if($obj->result_count()>0){
			foreach ($obj as $value) {
				$data["results"][] = array(					
				   	"amount" 		=> floatval($value->amount),
				   	"month"			=> date('F', strtotime($value->issued_date))				   	
				);
			}
		}

		//Response Data		
		$this->response($data, 200);	
	}	

	//GET HOME DASHBOARD
	function home_dashboard_get() {		
		$filters 	= $this->get("filter")["filters"];		
		$page 		= $this->get('page') !== false ? $this->get('page') : 1;		
		$limit 		= $this->get('limit') !== false ? $this->get('limit') : 100;								
		$sort 	 	= $this->get("sort");		
		$data["results"] = array();
		$data["count"] = 1;

		$sale = new Invoice(null, $this->entity);
		$inv = new Invoice(null, $this->entity);
		$bill = new Bill(null, $this->entity);
		$cus = new Contact(null, $this->entity);
		$order = new Invoice(null, $this->entity);	

		//Sort
		if(!empty($sort) && isset($sort)){					
			foreach ($sort as $value) {
				$sale->order_by($value["field"], $value["dir"]);
			}
		}
		
		//Filter		
		if(!empty($filters) && isset($filters)){			
	    	foreach ($filters as $value) {
	    		$sale->where($value["field"]." ".$value["operatoin"], $value["value"]);
	    		$inv->where($value["field"]." ".$value["operatoin"], $value["value"]);
	    		$bill->where("expected_date"." ".$value["operatoin"], $value["value"]);
	    		$order->where($value["field"]." ".$value["operatoin"], $value["value"]);

	    		if($value["operatoin"]=="<="){
	    			$cus->where("registered_date"." ".$value["operatoin"], $value["value"]);
	    		}
			}									 			
		}		
		
		//Results
		$sale->select_sum("amount");
		$sale->where_in("type", array("Invoice", "Receipt", "eInvoice", "wInvoice"));
		$sale->get();

		$inv->where_in("type", array("Invoice", "eInvoice", "wInvoice"));
		$inv->where_in("status", array(0,2));

		$bill->where("type", "bill");
		$bill->where_in("status", array(0,2));
		
		$cus->where_related("contact_type", "parent_id", 1);

		$order->where("type", "SO");
		$order->where("status", 0);
							
		$data["results"][] = array(
			"id" 				=> 1,
			"totalSale" 		=> floatval($sale->amount),
			"totalOpenInvoice" 	=> $inv->count(),
			"totalUnbill" 		=> $bill->count(),					
			"totalCustomer" 	=> $cus->count(),
			"totalOrder" 		=> $order->count()
		);

		//Response Data		
		$this->response($data, 200);	
	}



	//ELECTRICITY
	//GET ELECTRICTY MONTHLY
	function emonthly_get() {		
		$filters 	= $this->get("filter")["filters"];		
		$page 		= $this->get('page') !== false ? $this->get('page') : 1;		
		$limit 		= $this->get('limit') !== false ? $this->get('limit') : 100;								
		$sort 	 	= $this->get("sort");		
		$data["results"] = array();
		$data["count"] = 0;

		$obj = new Invoice(null, $this->entity);
		$obj->where_in("type", array("invoice", "receipt", "eInvoice"));
		$obj->where("issued_date >=", date("Y")."-01-01");
		$obj->where("issued_date <=", date("Y")."-12-31");		
		$obj->where_in("type", array('invoice','eInvoice','wInvoice'));				
		$obj->order_by("issued_date");								
		$obj->get();

		if($obj->result_count()>0){
			foreach ($obj as $value) {										
				$data["results"][] = array(					
				   	"amount" 		=> floatval($value->amount),				   	
				   	"issued_date"	=> date('F', strtotime($value->issued_date))				   	
				);
			}
		}		

		//Response Data		
		$this->response($data, 200);	
	}	

	//GET ELECTRICYT DASHBOARD
	function edashboard_get() {		
		$filters 	= $this->get("filter")["filters"];		
		$page 		= $this->get('page') !== false ? $this->get('page') : 1;		
		$limit 		= $this->get('limit') !== false ? $this->get('limit') : 50;								
		$sort 	 	= $this->get("sort");		
		$data["results"] = array();
		$data["count"] = 0;

		// 0 Balance
		$balance = new Invoice(null, $this->entity);
		$balance->select_sum("amount");
		$balance->where_in("type", array("eInvoice",));
		$balance->get();											
		$data["results"][] = floatval($balance->amount);

		// 1 Deposit
		$deposit = new Payment(null, $this->entity);
		$deposit->select_sum("amount");
		$deposit->where("type", "deposit");		
		$deposit->where_related("meter", "utility_id", 1);
		$deposit->get();											
		$data["results"][] = floatval($deposit->amount);

		// 2 Active Customer 
		$activeCustomer = new Contact(null, $this->entity);
		$activeCustomer->where("status", 1);
		$activeCustomer->where("deleted", 0);		
		$activeCustomer->where_in("contact_type_id", array(3,4,5,6,7));
		$activeCustomer->where_related("meter", "utility_id", 1);											
		$data["results"][] = intval($activeCustomer->count());

		// 3 Inactive Customer
		$inactiveCustomer = new Contact(null, $this->entity);
		$inactiveCustomer->where("status", 0);
		$inactiveCustomer->where("deleted", 0);		
		$inactiveCustomer->where_in("contact_type_id", array(3,4,5,6,7));
		$inactiveCustomer->where_related("meter", "utility_id", 1);											
		$data["results"][] = intval($inactiveCustomer->count());

		// 4 Void Customer
		$voidCustomer = new Contact(null, $this->entity);
		$voidCustomer->where("status", 2);
		$voidCustomer->where("deleted", 0);		
		$voidCustomer->where_in("contact_type_id", array(3,4,5,6,7));
		$voidCustomer->where_related("meter", "utility_id", 1);											
		$data["results"][] = intval($voidCustomer->count());

		// 5 Total Customer
		$totalCustomer = new Contact(null, $this->entity);		
		$totalCustomer->where("deleted", 0);		
		$totalCustomer->where_in("contact_type_id", array(3,4,5,6,7));
		$totalCustomer->where_related("meter", "utility_id", 1);												
		$data["results"][] = intval($totalCustomer->count());

		// 6 Unpaid
		$unpaid = new Invoice(null, $this->entity);
		$unpaid->where("type", "eInvoice");		
		$unpaid->where("status", 0);		
		$unpaid->group_by("contact_id");
		$unpaid->get();										
		$data["results"][] = intval($unpaid->result_count());

		// 7 Disconnect
		$dc = new Invoice(null, $this->entity);
		$dc->where("type", "eInvoice");
		$dc->where("status", 0);
		$dc->where("due_date <", date("Y-m-d"));				
		$dc->group_by("contact_id");
		$dc->get();										
		$data["results"][] = intval($dc->result_count());				

		//Response Data		
		$this->response($data, 200);	
	}	

	//GET ELECTRICYT SALE BY LOCATION
	function esale_by_location_get() {		
		$filters 	= $this->get("filter")["filters"];		
		$page 		= $this->get('page') !== false ? $this->get('page') : 1;		
		$limit 		= $this->get('limit') !== false ? $this->get('limit') : 50;								
		$sort 	 	= $this->get("sort");		
		$data["results"] = array();
		$data["count"] = 1;		
		
		$sale = new Invoice(null, $this->entity);
		$usage = new Meter_record(null, $this->entity);
		$unpaid = new Invoice(null, $this->entity);
		$deposit = new Payment(null, $this->entity);

		//Filter		
		if(!empty($filters) && isset($filters)){			
	    	foreach ($filters as $value) {	    				
	    		$sale->where($value["field"], $value["value"]);
	    		$unpaid->where($value["field"], $value["value"]);
	    		$deposit->where("payment_date", $value["value"]);	    			    		
			}									 			
		}		

		//Location
		$location = new Location(null, $this->entity);
		$location->where("utility_id", 1);
		$location->get();

		foreach ($location as $value){
			//Active Customer
			$activeCustomer = new Contact(null, $this->entity);			
			$activeCustomer->where("status", 1);
			$activeCustomer->where("deleted", 0);		
			$activeCustomer->where_related("meter", "location_id", $value->id);										
			
			//Inactive Customer
			$inactiveCustomer = new Contact(null, $this->entity);			
			$inactiveCustomer->where("status", 0);
			$inactiveCustomer->where("deleted", 0);		
			$inactiveCustomer->where_related("meter", "location_id", $value->id);	

			//Deposit
			$deposit->select_sum('amount');		
			$deposit->where("type", "deposit");
			$deposit->where_related("meter", "location_id", $value->id);
			$deposit->where("deleted", 0);		
			$deposit->get();

			//Usage
			$usage->select_sum('usage', 'totalUsage');			
			$usage->where_related("meter", "location_id", $value->id);					
			$usage->get();

			//Sale
			$sale->select_sum('amount');		
			$sale->where("type", "eInvoice");
			$sale->where("location_id", $value->id);
			$sale->where("deleted", 0);		
			$sale->get();

			//Unpaid
			$unpaid->select_sum('amount');		
			$unpaid->where("type", "eInvoice");			
			$unpaid->where("location_id", $value->id);
			$unpaid->where("status", 0);
			$unpaid->where("deleted", 0);		
			$unpaid->get();

			$data["results"][] = array(
				"location_name"		=> $value->name,
				"active_customer" 	=> intval($activeCustomer->count()),
				"inactive_customer" => intval($inactiveCustomer->count()),
				"deposit" 			=> floatval($deposit->amount),
				"usage" 			=> intval($usage->totalUsage),
				"sale"				=> floatval($sale->amount),
				"unpaid"			=> floatval($unpaid->amount)			
			);
		}					

		//Response Data		
		$this->response($data, 200);	
	}


	//WATER
	//POST UINVOICE
	function uInvoice_post() {
		$models = json_decode($this->post('models'));				
		$data["results"] = array();
		$data["count"] = 0;
				
		$number = "";
		foreach ($models as $value) {
			if($number==""){				
				$number = $this->_generate_number($value->type);
			}else{
				$last_no = $number;
				$header = substr($last_no, 0, -5);
				$no = intval(substr($last_no, strlen($last_no) - 5));
				$no++;
				$number = $header . str_pad($no, 5, "0", STR_PAD_LEFT);
			}

			$obj = new Invoice(null, $this->entity);
			$obj->company_id 		= $value->company_id;
			$obj->location_id 		= $value->location_id;
			$obj->contact_id 		= $value->contact_id;			
			$obj->payment_term_id	= $value->payment_term_id;
			$obj->payment_method_id = $value->payment_method_id;
			$obj->reference_id 		= $value->reference_id;
			$obj->account_id 		= $value->account_id;
			$obj->vat_id 			= $value->vat_id;
			$obj->biller_id 		= $value->biller_id;			
		   	$obj->number 			= $number;
		   	$obj->type 				= $value->type;		   			   	
		   	$obj->amount 			= $value->amount;
		   	$obj->vat 				= $value->vat;
		   	$obj->rate 				= $value->rate;
		   	$obj->locale 			= $value->locale;
		   	$obj->month_of 			= $value->month_of;
		   	$obj->issued_date 		= $value->issued_date;
		   	$obj->payment_date 		= $value->payment_date;
		   	$obj->due_date 			= $value->due_date;		   	
		   	$obj->check_no 			= $value->check_no;
		   	$obj->memo 				= $value->memo;
		   	$obj->memo2 			= $value->memo2;
		   	$obj->status 			= $value->status;

	   		if($obj->save()){
	   			$invoice_lines = [];		   		
		   		foreach ($value->invoice_lines as $row) {		   				
		   			$line = new Invoice_line(null, $this->entity);
		   			$line->invoice_id 		= $obj->id;
		   			$line->item_id 			= $row->item_id;		   			
		   			$line->meter_record_id 	= $row->meter_record_id;
		   			$line->description 		= $row->description;
		   			$line->unit 			= $row->unit;
		   			$line->price 			= $row->price;
		   			$line->amount 			= $row->amount;
		   			$line->rate 			= $row->rate;
		   			$line->locale 			= $row->locale;
		   			$line->has_vat 			= $row->has_vat;
		   			$line->type 			= isset($row->type)?$row->type:"";
		   			
		   			if($line->save()){		   				
		   				$invoice_lines[] = array(
		   					"id" 				=> $line->id,
		   					"invoice_id"		=> $line->invoice_id, 	
				   			"item_id"			=> $line->item_id,
				   			"measurement_id" 	=> isset($line->measurement_id)?$line->measurement_id:0,				   			 	
				   			"meter_record_id" 	=> $line->meter_record_id, 
				   			"description" 		=> $line->description, 	
				   			"unit"				=> $line->unit, 		
				   			"price" 			=> floatval($line->price), 		
				   			"amount" 			=> floatval($line->amount),
				   			"rate"				=> floatval($line->rate),
				   			"locale" 			=> $line->locale, 		
				   			"has_vat" 			=> $line->has_vat=="true"?true:false,
				   			"type" 				=> $line->type 		
		   				);
		   			}
		   		}
		   		
			   	$data["results"][] = array(
			   		"id" 				=> $obj->id,
					"company_id" 		=> $obj->company_id,
					"location_id" 		=> $obj->location_id,
					"contact_id" 		=> $obj->contact_id,
					"payment_term_id" 	=> $obj->payment_term_id,
					"payment_method_id" => $obj->payment_method_id,
					"reference_id" 		=> $obj->reference_id,
					"account_id" 		=> $obj->account_id,
					"vat_id"			=> $obj->vat_id,
					"biller_id" 		=> $obj->biller_id,								   			   						   
				   	"number" 			=> $obj->number,
				   	"type" 				=> $obj->type,				   	
				   	"amount" 			=> floatval($obj->amount),
				   	"vat" 				=> floatval($obj->vat),
				   	"rate" 				=> floatval($obj->rate),
				   	"locale" 			=> $obj->locale,
				   	"month_of"			=> $obj->month_of,
				   	"issued_date"		=> $obj->issued_date,
				   	"payment_date" 		=> $obj->payment_date,
				   	"due_date" 			=> $obj->due_date,
				   	"check_no" 			=> $obj->check_no,
				   	"memo" 				=> $obj->memo,
				   	"memo2" 			=> $obj->memo2,
				   	"status" 			=> $obj->status,

				   	"invoice_lines" 	=> $invoice_lines
			   	);
		    }	
		}
		
		$data["count"] = count($data["results"]);
		$this->response($data, 201);		
	}

	//GET WATER INVOICE PRINT
	function wInvoice_print_get() {		
		$filters 	= $this->get("filter")["filters"];		
		$page 		= $this->get('page') !== false ? $this->get('page') : 1;		
		$limit 		= $this->get('limit') !== false ? $this->get('limit') : 100;								
		$sort 	 	= $this->get("sort");		
		$data["results"] = array();
		$data["count"] = 0;

		$obj = new Invoice(null, $this->entity);		

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
		
		//Order
		$obj->order_by_related("contact", "worder", "asc");	

		//Results
		$obj->get();
		
		if($obj->exists()){
			foreach ($obj as $value) {
				//Balance forward
				$bf = new Invoice(null, $this->entity);
				$bf->select_sum('amount');
				$bf->where('contact_id', $value->contact_id);
				$bf->where('status', 0);
				$bf->where_in('type', array('Invoice','wInvoice'));				
				$bf->where('month_of <', $value->month_of);
				$bf->get();				

				$total = floatval($value->amount) + floatval($bf->amount);

				//Invoice lines
				$lines = $value->invoice_line->get();
				$invoiceLines = [];
				foreach ($lines as $l) {
					$record = [];
					$meter = [];
					if($l->type=="tariff"){
						$record = $l->meter_record->get_raw()->result();
					   	$meter = $l->meter_record->get()->meter->get_raw()->result();	
					}

					$invoiceLines[] = array(
						"id" 				=> $l->id,
				   		"invoice_id"		=> $l->invoice_id,
						"item_id" 			=> $l->item_id,
						"meter_record_id" 	=> $l->meter_record_id,				   	
					   	"description" 		=> $l->description,					   	
					   	"unit" 				=> intval($l->unit),
					   	"price"				=> floatval($l->price),					   	
					   	"amount" 			=> floatval($l->amount),
					   	"rate"				=> floatval($l->rate),
					   	"locale" 			=> $l->locale,
					   	"has_vat" 			=> $l->has_vat,
					   	"type" 				=> $l->type,

					   	"record" 			=> $record,
					   	"meter" 			=> $meter	
					);
				}

				$data["results"][] = array(
					"id" 				=> $value->id,
					"company_id" 		=> $value->company_id,
					"location_id" 		=> $value->location_id,
					"contact_id" 		=> $value->contact_id,
					"payment_term_id" 	=> $value->payment_term_id,
					"payment_method_id" => $value->payment_method_id,
					"reference_id" 		=> $value->reference_id,					
					"account_id" 		=> $value->account_id,
					"vat_id"			=> $value->vat_id,
					"biller_id" 		=> $value->biller_id,					   			   						   
				   	"number" 			=> $value->number,
				   	"type" 				=> $value->type,				   	
				   	"amount" 			=> floatval($value->amount),
				   	"vat" 				=> floatval($value->vat),
				   	"rate" 				=> floatval($value->rate),
				   	"locale" 			=> $value->locale,
				   	"month_of"			=> $value->month_of,
				   	"issued_date"		=> $value->issued_date,
				   	"payment_date" 		=> $value->payment_date,
				   	"due_date" 			=> $value->due_date,
				   	"check_no" 			=> $value->check_no,
				   	"memo" 				=> $value->memo,
				   	"memo2" 			=> $value->memo2,
				   	"status" 			=> $value->status,
				   	"print_count" 		=> $value->print_count,
				   	"printed_by" 		=> $value->printed_by,

				   	"total" 			=> $total,
				   	"balance_forward" 	=> floatval($bf->amount),

				   	"company" 			=> $value->company->get_raw()->result(),				   	
				   	"location" 			=> $value->location->get_raw()->result(),
				   	"contact" 			=> $value->contact->get_raw()->result(),
				   	"invoiceLines" 		=> $invoiceLines
				);
			}
		}

		$data["count"] = count($data["results"]);		

		//Response Data		
		$this->response($data, 200);	
	}

	//PUT WATER INVOICE PRINT
	function wInvoice_print_put() {
		$models = json_decode($this->put('models'));
		$data["results"] = array();
		$data["count"] = 0;

		foreach ($models as $value) {			
			$obj = new Invoice(null, $this->entity);
			$obj->get_by_id($value->id);			
			
		   	$obj->print_count 		= isset($value->print_count) ? $value->print_count : 0;
		   	$obj->printed_by 		= isset($value->printed_by) ? $value->printed_by : 0;

			if($obj->save()){				
				//Results
				$data["results"][] = array(
					"id" 				=> $obj->id,					
				   	"print_count" 		=> $obj->print_count,
				   	"printed_by" 		=> $obj->printed_by
				);						
			}
		}
		$data["count"] = count($data["results"]);

		$this->response($data, 200);
	}

	//GET WATER PRINT
	function wprint_get() {		
		$filters 	= $this->get("filter")["filters"];		
		$page 		= $this->get('page') !== false ? $this->get('page') : 1;		
		$limit 		= $this->get('limit') !== false ? $this->get('limit') : 100;								
		$sort 	 	= $this->get("sort");		
		$data["results"] = array();
		$data["count"] = 0;

		$obj = new Invoice(null, $this->entity);
		
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

		//Only water invoice
		$obj->where("type", "wInvoice");
		$obj->order_by_related("contact", "worder", "asc");			
		
		//Results
		$obj->get_paged_iterated($page, $limit);
		$data["count"] = $obj->paged->total_rows;							

		if($obj->result_count()>0){
			foreach ($obj as $value) {				
				$data["results"][] = array(
					"id" 				=> $value->id,									   			   						   
				   	"number" 			=> $value->number,				   			   	
				   	"amount" 			=> floatval($value->amount),
				   	"amount_paid"		=> floatval($value->amount_paid),
				   	"status" 			=> $value->status,				   	
				   	"print_count" 		=> $value->print_count,
				  
				   	"contact" 			=> $value->contact->get_raw()->result()				   
				);
			}
		}		

		//Response Data		
		$this->response($data, 200);	
	}

	//GET WATER PRINT SNAPSHOT 
	function wprint_snapshot_get() {		
		$filters 	= $this->get("filter")["filters"];		
		$page 		= $this->get('page') !== false ? $this->get('page') : 1;		
		$limit 		= $this->get('limit') !== false ? $this->get('limit') : 100;								
		$sort 	 	= $this->get("sort");		
		$data["results"] = array();
		$data["count"] = 0;

		$obj = new Invoice(null, $this->entity);		

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

		//Only water invoice
		$obj->where("type", "wInvoice");		
		
		//Results
		$obj->get();

		$totalInvoice = 0;
		$totalUnprint = 0;
		$totalUsage = 0;
		$totalAmount = 0;
		$ids = [];		
		if($obj->result_count()>0){
			foreach ($obj as $value) {
				array_push($ids, $value->id);
				$totalInvoice++;
				if($value->print_count==0){
					$totalUnprint++;
				}
				$totalAmount += $value->amount;
			}

			$line = new Invoice_line(null, $this->entity);
			$line->select_sum("unit");
			$line->where_in("invoice_id", $ids);
			$line->where("type", "tariff");
			$line->get();
		}

		$data["results"][] = array(
			"id" 			=> 0,
			"totalInvoice" 	=> $totalInvoice,
			"totalUnprint" 	=> $totalUnprint,
			"totalUsage" 	=> intval($line->unit),
			"totalAmount" 	=> $totalAmount					
		);
		$data["count"] = count($data["results"]);			

		//Response Data		
		$this->response($data, 200);	
	}

	//GET WATER DASHBOARD
	function wdashboard_get() {		
		$filters 	= $this->get("filter")["filters"];		
		$page 		= $this->get('page') !== false ? $this->get('page') : 1;		
		$limit 		= $this->get('limit') !== false ? $this->get('limit') : 50;								
		$sort 	 	= $this->get("sort");		
		$data["results"] = array();
		$data["count"] = 0;

		// 0 Balance
		$balance = new Invoice(null, $this->entity);
		$balance->select_sum("amount");
		$balance->where("type", "wInvoice");
		$balance->get();											
		$data["results"][] = floatval($balance->amount);

		// 1 Deposit
		$deposit = new Payment(null, $this->entity);
		$deposit->select_sum("amount");
		$deposit->where("type", "wdeposit");		
		$deposit->get();											
		$data["results"][] = floatval($deposit->amount);

		// 2 Active Customer 
		$activeCustomer = new Contact(null, $this->entity);
		$activeCustomer->where("status", 1);
		$activeCustomer->where("deleted", 0);				
		$activeCustomer->where("use_water", 1);											
		$data["results"][] = intval($activeCustomer->count());

		// 3 Inactive Customer
		$inactiveCustomer = new Contact(null, $this->entity);
		$inactiveCustomer->where("status", 0);
		$inactiveCustomer->where("deleted", 0);			
		$inactiveCustomer->where("use_water", 1);														
		$data["results"][] = intval($inactiveCustomer->count());

		// 4 Disconnect Customer
		$voidCustomer = new Contact(null, $this->entity);
		$voidCustomer->where("status", 2);
		$voidCustomer->where("deleted", 0);				
		$voidCustomer->where("use_water", 1);												
		$data["results"][] = intval($voidCustomer->count());

		// 5 Total Customer
		$totalCustomer = new Contact(null, $this->entity);		
		$totalCustomer->where("deleted", 0);					
		$totalCustomer->where("use_water", 1);											
		$data["results"][] = intval($totalCustomer->count());

		// 6 Unpaid
		$unpaid = new Invoice(null, $this->entity);
		$unpaid->where("type", "wInvoice");		
		$unpaid->where_in("status", array(0,2));		
		$unpaid->group_by("contact_id");
		$unpaid->get();										
		$data["results"][] = intval($unpaid->result_count());

		// 7 No meter
		$contact = new Contact(null, $this->entity);
		$sub_contact = new Contact(null, $this->entity);
		$contact->where("use_water", 1);
		$sub_contact->select("id")->where_related_meter("utility_id", 2);
		$contact->where_not_in_subquery('id', $sub_contact);
		$contact->get();

		$data["results"][] = intval($contact->result_count());				

		//Response Data		
		$this->response($data, 200);	
	}

	//GET WATER MONTHLY
	function wmonthly_get() {		
		$filters 	= $this->get("filter")["filters"];		
		$page 		= $this->get('page') !== false ? $this->get('page') : 1;		
		$limit 		= $this->get('limit') !== false ? $this->get('limit') : 100;								
		$sort 	 	= $this->get("sort");		
		$data["results"] = array();
		$data["count"] = 0;

		$obj = new Invoice(null, $this->entity);
		$reading = new Meter_record(null, $this->entity);

		//Filter		
		if(!empty($filters) && isset($filters)){			
	    	foreach ($filters as $value) {	    				
	    		$obj->where($value["field"], $value["value"]);
	    		$reading->where_related("meter", $value["field"], $value["value"]);	    		  			    		
			}									 			
		}
		
		$obj->where("type", "wInvoice");
		$obj->where("issued_date >=", date("Y")."-01-01");
		$obj->where("issued_date <=", date("Y")."-12-31");						
		$obj->order_by("issued_date");								
		$obj->get();
		
		$reading->where("month_of >=", date("Y")."-01-01");
		$reading->where("month_of <=", date("Y")."-12-31");
		$reading->order_by("month_of");								
		$reading->get();
		
		if($obj->result_count() > $reading->result_count()){
			foreach ($obj as $value) {
				$usage = 0;
				$invoiceMonth = date('F', strtotime($value->issued_date));

				foreach ($reading as $v) {
					$readingMonth = date('F', strtotime($v->month_of));

					if($readingMonth===$invoiceMonth){
						$usage += floatval($v->usage);
					}
				}

				$data["results"][] = array(					
				   	"amount" 		=> floatval($value->amount),
				   	"usage" 		=> $usage,				   	
				   	"month"			=> $invoiceMonth				   	
				);
			}
		}else{
			foreach ($reading as $value) {
				$amount = 0;
				$readingMonth = date('F', strtotime($value->month_of));

				foreach ($obj as $v) {
					$invoiceMonth = date('F', strtotime($v->issued_date));

					if($readingMonth===$invoiceMonth){
						$amount += floatval($v->amount);
					}
				}

				$data["results"][] = array(					
				   	"amount" 		=> $amount,
				   	"usage" 		=> floatval($value->usage),				   	
				   	"month"			=> $readingMonth				   	
				);
			}
		}			

		//Response Data		
		$this->response($data, 200);	
	}

	//GET WATER SALE BY BRANCH
	function wsale_by_branch_get() {		
		$filters 	= $this->get("filter")["filters"];		
		$page 		= $this->get('page') !== false ? $this->get('page') : 1;		
		$limit 		= $this->get('limit') !== false ? $this->get('limit') : 50;								
		$sort 	 	= $this->get("sort");		
		$data["results"] = array();
		$data["count"] = 1;		
		
		//Branch
		$branch = new Company(null, $this->entity);
		$branch->where("utility_id", 2);
		$branch->get();

		foreach ($branch as $value){
			$location = new Location(null, $this->entity);
			$sale = new Invoice(null, $this->entity);
			$usage = new Meter_record(null, $this->entity);
			$unpaid = new Invoice(null, $this->entity);
			$deposit = new Payment(null, $this->entity);

			$activeCustomer = new Contact(null, $this->entity);
			$inactiveCustomer = new Contact(null, $this->entity);			

			//Filter		
			if(!empty($filters) && isset($filters)){
		    	foreach ($filters as $val) {
		    		if($val["field"]=="start_date"){
		    			$sale->where("issued_date >=", $val["value"]);
			    		$usage->where("month_of >=", $val["value"]);		    		
		    		}

		    		if($val["field"]=="end_date"){
		    			$sale->where("issued_date <=", $val["value"]);
			    		$usage->where("month_of <=", $val["value"]);

			    		$location->where("created_at <=", $val["value"]);
			    		$activeCustomer->where("registered_date <=", $val["value"]);
			    		$inactiveCustomer->where("registered_date <=", $val["value"]);
			    		$deposit->where("payment_date <=", $val["value"]);
			    		$unpaid->where("issued_date <=", $val["value"]);		    		
		    		}	    			    			    		
				}												 			
			}
		
			//Count location						
			$location->where("company_id", $value->id);

			//Active Customer
			$activeCustomer->where("status", 1);
			$activeCustomer->where("deleted", 0);					
			$activeCustomer->where_related("meter", "company_id", $value->id);										
			
			//Inactive Customer
			$inactiveCustomer->where("status", 0);
			$inactiveCustomer->where("deleted", 0);					
			$inactiveCustomer->where_related("meter", "company_id", $value->id);	

			//Deposit
			$deposit->select_sum('amount');		
			$deposit->where("type", "deposit");
			$deposit->where("company_id", $value->id);
			$deposit->where("deleted", 0);		
			$deposit->get();

			//Usage
			$usage->select_sum('usage', 'totalUsage');			
			$usage->where_related("meter", "company_id", $value->id);					
			$usage->get();

			//Sale
			$sale->select_sum('amount');		
			$sale->where("type", "wInvoice");
			$sale->where("company_id", $value->id);
			$sale->where("deleted", 0);		
			$sale->get();

			//Unpaid
			$unpaid->select_sum('amount');		
			$unpaid->where("type", "wInvoice");			
			$unpaid->where("company_id", $value->id);
			$unpaid->where("status", 0);
			$unpaid->where("deleted", 0);		
			$unpaid->get();

			$data["results"][] = array(
				"name" 				=> $value->name,
				"location"			=> intval($location->count()),
				"active_customer" 	=> intval($activeCustomer->count()),
				"inactive_customer" => intval($inactiveCustomer->count()),
				"deposit" 			=> floatval($deposit->amount),
				"usage" 			=> intval($usage->totalUsage),
				"sale"				=> floatval($sale->amount),
				"unpaid"			=> floatval($unpaid->amount)			
			);
		}					

		//Response Data		
		$this->response($data, 200);	
	}

	//GET WATER SALE BY LOCATION
	function wsale_by_location_get() {		
		$filters 	= $this->get("filter")["filters"];		
		$page 		= $this->get('page') !== false ? $this->get('page') : 1;		
		$limit 		= $this->get('limit') !== false ? $this->get('limit') : 50;								
		$sort 	 	= $this->get("sort");		
		$data["results"] = array();
		$data["count"] = 1;

		//Location
		$location = new Location(null, $this->entity);
		$location->where("utility_id", 2);
		$location->order_by("company_id");
		$location->get();

		foreach ($location as $value){		
			$sale = new Invoice(null, $this->entity);
			$usage = new Meter_record(null, $this->entity);
			$unpaid = new Invoice(null, $this->entity);
			$deposit = new Payment(null, $this->entity);

			$activeCustomer = new Contact(null, $this->entity);
			$inactiveCustomer = new Contact(null, $this->entity);	

			//Filter		
			if(!empty($filters) && isset($filters)){
		    	foreach ($filters as $val) {
		    		if($val["field"]=="start_date"){
		    			$sale->where("issued_date >=", $val["value"]);
			    		$usage->where("month_of >=", $val["value"]);		    		
		    		}

		    		if($val["field"]=="end_date"){
		    			$sale->where("issued_date <=", $val["value"]);
			    		$usage->where("month_of <=", $val["value"]);
			    		
			    		$activeCustomer->where("registered_date <=", $val["value"]);
			    		$inactiveCustomer->where("registered_date <=", $val["value"]);
			    		$deposit->where("payment_date <=", $val["value"]);
			    		$unpaid->where("issued_date <=", $val["value"]);		    		
		    		}	    			    			    		
				}												 			
			}			

			//Active Customer						
			$activeCustomer->where("status", 1);
			$activeCustomer->where("deleted", 0);		
			$activeCustomer->where_related("meter", "location_id", $value->id);										
			
			//Inactive Customer					
			$inactiveCustomer->where("status", 0);
			$inactiveCustomer->where("deleted", 0);		
			$inactiveCustomer->where_related("meter", "location_id", $value->id);	

			//Deposit
			$deposit->select_sum('amount');		
			$deposit->where("type", "wdeposit");
			$deposit->where_related("meter", "location_id", $value->id);
			$deposit->where("deleted", 0);		
			$deposit->get();

			//Usage
			$usage->select_sum('usage', 'totalUsage');			
			$usage->where_related("meter", "location_id", $value->id);					
			$usage->get();

			//Sale
			$sale->select_sum('amount');		
			$sale->where("type", "wInvoice");
			$sale->where("location_id", $value->id);
			$sale->where("deleted", 0);		
			$sale->get();

			//Unpaid
			$unpaid->select_sum('amount');		
			$unpaid->where("type", "wInvoice");			
			$unpaid->where("location_id", $value->id);
			$unpaid->where("status", 0);
			$unpaid->where("deleted", 0);		
			$unpaid->get();

			$data["results"][] = array(
				"branch_name"		=> $value->company->get()->name,
				"location_name"		=> $value->name,
				"active_customer" 	=> intval($activeCustomer->count()),
				"inactive_customer" => intval($inactiveCustomer->count()),
				"deposit" 			=> floatval($deposit->amount),
				"usage" 			=> intval($usage->totalUsage),
				"sale"				=> floatval($sale->amount),
				"unpaid"			=> floatval($unpaid->amount)			
			);
		}					

		//Response Data		
		$this->response($data, 200);	
	}

	//GET WATER OUTSTANDING
	function woutstanding_get(){
		$filters 	= $this->get("filter")["filters"];		
		$page 		= $this->get('page') !== false ? $this->get('page') : 1;		
		$limit 		= $this->get('limit') !== false ? $this->get('limit') : 100;								
		$sort 	 	= $this->get("sort");		
		$data["results"] = array();
		$data["count"] = 4;
		
		$inv = new Invoice(null, $this->entity);
		$deposit = new Payment(null, $this->entity);	

		//Filter		
		if(!empty($filters) && isset($filters)){
	    	foreach ($filters as $value) {	    		
		    	$inv->where($value["field"], $value["value"]);
		    	$deposit->where($value["field"], $value["value"]);
			}												 			
		}	
		
		//Deposit
		$deposit->select_sum('amount');
		$deposit->where("type", "wdeposit");		
		$deposit->get();
		$data["results"][] = array("deposit"=>floatval($deposit->amount));		
		
		//Out standing invoice and wInvoice
		$inv->where_in("type", array("invoice", "wInvoice"));
		$inv->where_in("status", array(0,2));
		$inv->get();				
		$data["results"][] = array("outInvoice"=>intval($inv->result_count()));

		$overDue = 0;
		$overBal = 0;
		foreach ($inv as $value) {
			$overBal += (floatval($value->amount)-floatval($value->amount_paid));
			$today = new DateTime();
			$dueDate = new DateTime($value->due_date);
			if($dueDate<$today){
				$overDue++;
			}
		}
		$data["results"][] = array("overInvoice"=>$overDue);
		$data["results"][] = array("balance"=>$overBal);

		$this->response($data, 200);		
	}

	//GET WATER TRANSACTION
	function wtransaction_get(){
		$filters 	= $this->get("filter")["filters"];		
		$page 		= $this->get('page') !== false ? $this->get('page') : 1;		
		$limit 		= $this->get('limit') !== false ? $this->get('limit') : 100;								
		$sort 	 	= $this->get("sort");		
		$data["results"] = array();
		$data["count"] = 0;
		
		$inv = new Invoice(null, $this->entity);
		$pay = new Payment(null, $this->entity);

		//Sort
		if(!empty($sort) && isset($sort)){					
			foreach ($sort as $value) {
				$inv->order_by("issued_date", $value["dir"]);
				$pay->order_by("payment_date", $value["dir"]);
			}
		}	

		//Filter		
		if(!empty($filters) && isset($filters)){
	    	foreach ($filters as $value) {
	    		if(!empty($value["operator"]) && isset($value["operator"])){
		    		if($value["operator"]=="where_in"){
		    			$inv->where_in($value["field"], $value["value"]);		    		
		    		}else if($value["operator"]=="payment"){
		    			$pay->where($value["field"], $value["value"]);
		    		}else{
		    			$inv->where($value["field"], $value["value"]);
		    		}
	    		}else{	    			
		    		if($value["field"]=="start_date"){
		    			$inv->where("issued_date >=", $value["value"]);
			    		$pay->where("payment_date >=", $value["value"]);
			    	}else if($value["field"]=="end_date"){
			    		$inv->where("issued_date <=", $value["value"]);
			    		$pay->where("payment_date <=", $value["value"]);
		    		}else{
		    			$inv->where($value["field"], $value["value"]);
			    		$pay->where($value["field"], $value["value"]);
		    		}
		    	}		    	
			}												 			
		}

		$pay->where_in("type", array("invoice", "deposit", "edeposit", "wdeposit"));
		
		//Results
		$inv->get_paged_iterated($page, $limit);		
		$pay->get();		

		if($inv->result_count()>0){
			foreach ($inv as $value) {
				$data["results"][] = array(
					"id" 			=> $value->id,
			   		"type"			=> $value->type,
					"number" 		=> $value->number,
					"amount" 		=> floatval($value->amount),				   	
				   	"issued_date" 	=> $value->issued_date,
				   	"due_date" 		=> $value->due_date,					   	
				   	"status" 		=> $value->status,				   
				   	"rate"			=> floatval($value->rate),
				   	"locale" 		=> $value->locale
				);
			}
		}

		if($pay->result_count()>0){
			foreach ($pay as $value) {
				$data["results"][] = array(
					"id" 			=> $value->id,
			   		"type"			=> $value->type=="invoice"?"Payment":"Deposit",
					"number" 		=> "",
					"amount" 		=> floatval($value->amount),				   	
				   	"issued_date" 	=> $value->payment_date,
				   	"due_date" 		=> $value->payment_date,					   	
				   	"status" 		=> 0,				   
				   	"rate"			=> floatval($value->rate),
				   	"locale" 		=> $value->locale
				);
			}
		}

		$data["count"] = count($data["results"]);		

		$this->response($data, 200);		
	}

	//GET WATER KPI
	function wkpi_get() {		
		$filters 	= $this->get("filter")["filters"];		
		$page 		= $this->get('page') !== false ? $this->get('page') : 1;		
		$limit 		= $this->get('limit') !== false ? $this->get('limit') : 100;								
		$sort 	 	= $this->get("sort");		
		$data["results"] = [];
		$data["count"] = 0;

		$contact = new Contact(null, $this->entity);
		$activeContact = new Contact(null, $this->entity);
		$branch = new Company(null, $this->entity);
		$income = new Invoice(null, $this->entity);
		$avgIncome = new Invoice(null, $this->entity);
		$usage = new Invoice_line(null, $this->entity);
		$avgUsage = new Meter_record(null, $this->entity);
		$deposit = new Payment(null, $this->entity);		
		
		//Filter		
		if(!empty($filters) && isset($filters)){			
	    	foreach ($filters as $value) {	    		    			
	    		$contact->where("wbranch_id", $value["value"]);
	    		$activeContact->where("wbranch_id", $value["value"]);
	    		$branch->where("id", $value["value"]);
	    		$income->where($value["field"], $value["value"]);
	    		$avgIncome->where($value["field"], $value["value"]);
	    		$usage->where_related("invoice", $value["field"], $value["value"]);
	    		$avgUsage->where_related("meter", $value["field"], $value["value"]);
	    		$deposit->where($value["field"], $value["value"]);	    		
			}									 			
		}		
		
		$contact->where_in("status", array(0,1));		
		$branch->get();

		$totalCustomer = $contact->count();
		$totalAllowCustomer = $totalCustomer / intval($branch->max_customer);
		$totalActiveCustomer = $activeContact->count() / $totalCustomer;

		$income->select_sum("amount");
		$income->where("type", "wInvoice");
		$income->get();
		
		$avgIncome->select_avg("amount");
		$avgIncome->where("type", "wInvoice");
		$avgIncome->get();

		$usage->select_sum("unit");
		$usage->where("type", "tariff");
		$usage->get();

		$avgUsage->select_avg("usage", "reading");
		$avgUsage->get();

		$deposit->select_sum("amount");
		$deposit->where("type", "wdeposit");
		$deposit->get();
				
		$data["results"][] = array(
			"id" 						=> 0,
			"totalCustomer" 			=> $totalCustomer,
			"totalAllowCustomer" 		=> $totalAllowCustomer,
			"totalActiveCustomer" 		=> $totalActiveCustomer,
			"totalIncome" 				=> floatval($income->amount),
			"avgIncome" 				=> floatval($avgIncome->amount),
			"totalUsage" 				=> intval($usage->unit),
			"avgUsage" 					=> floatval($avgUsage->reading),				
			"totalDeposit" 				=> floatval($deposit->amount)							
		);
			

		//Response Data		
		$this->response($data, 200);	
	}

	//GET WATER DISCONNECT LIST
	function wdisconnect_get() {		
		$filters 	= $this->get("filter")["filters"];		
		$page 		= $this->get('page') !== false ? $this->get('page') : 1;		
		$limit 		= $this->get('limit') !== false ? $this->get('limit') : 100;								
		$sort 	 	= $this->get("sort");		
		$data["results"] = array();
		$data["count"] = 0;

		$obj = new Invoice(null, $this->entity);
		$today = new DateTime();		
		$days = 0;

		//Sort
		if(!empty($sort) && isset($sort)){					
			foreach ($sort as $value) {
				if($value["field"]=="days"){
					$obj->order_by("due_date", $value["dir"]);
				}else if($value["field"]=="location_name"){
					$obj->order_by("location_id", $value["dir"]);
				}else if($value["field"]=="contact_number" || $value["field"]=="fullname"){
					$obj->order_by("contact_id", $value["dir"]);
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
		    		}else if($value["operator"]=="days"){
		    			$days = $value["value"];		    			    		
		    		}else{
		    			$obj->where($value["field"].' '.$value["operator"], $value["value"]);
		    		}
	    		}else{	    			
	    			$obj->where($value["field"], $value["value"]);	    				    			
	    		}
			}									 			
		}

		$obj->where_in("status", array(0,2));

		//Join other tables
		$obj->include_related("location", "name");
		$obj->include_related("company", "name");
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

				$dueDate = new DateTime($value->due_date);
				$diff = $today->diff($dueDate)->format("%a");

				if($dueDate<$today && $diff<=$days){
					$data["results"][] = array(
						"id" 				=> $value->id,
						"number" 			=> $value->number,
						"amount" 			=> floatval($value->amount),
						"due_date" 			=> $value->due_date,
						"days"				=> $diff,
						"contact_number" 	=> $value->contact_wnumber,
						"fullname" 			=> $fullname,
						"location_name"		=> $value->location_name,
						"branch_name" 		=> $value->company_name				
					);
				}
			}
		}		

		//Response Data		
		$this->response($data, 200);	
	}

	//GET WATER AGING SUMMARY
	function waging_summary_get() {		
		$filters 	= $this->get("filter")["filters"];		
		$page 		= $this->get('page') !== false ? $this->get('page') : 1;		
		$limit 		= $this->get('limit') !== false ? $this->get('limit') : 100;								
		$sort 	 	= $this->get("sort");		
		$data["results"] = array();
		$data["count"] = 0;

		$contact = new Contact(null, $this->entity);
				
		//Filter
		$search_date = new DateTime();		
		if(!empty($filters) && isset($filters)){			
	    	foreach ($filters as $value){
	    		if($value["field"]==="search_date"){	    		
	    			$search_date = date("Y-m-d", strtotime($value["value"]));
	    		}else{
	    			$contact->where($value["field"], $value["value"]);
	    		}	    			    		
			}									 			
		}

		$contact->where("use_water", 1);
						
		//Results
		$contact->get_paged_iterated($page, $limit);
		$data["count"] = $contact->paged->total_rows;

		if($contact->exists()){
			foreach ($contact as $value) {
				//Fullname				
				$fullname = $value->surname.' '.$value->name;
				if($value->contact_type_id=="5" || $value->contact_type_id=="6" || $value->contact_type_id=="7"){
					$fullname = $value->company;
				}

				//Invoice
				$invoice = new Invoice(null, $this->entity);
				$invoice->where("contact_id", $value->id);
				$invoice->where("type", "wInvoice");
				$invoice->where_in("status", array(0,2));
				$invoice->where("issued_date <=", $search_date);
				$invoice->get();				

				$amount = 0;
				$current = 0;
				$oneMonth = 0;
				$twoMonth = 0;
				$threeMonth = 0;
				$overMonth = 0;

				if($invoice->exists()){
					foreach ($invoice as $valInv) {
						$today = new DateTime();
						$dueDate = new DateTime($valInv->due_date);
						$diff = $today->diff($dueDate)->format("%a");

						$amount += floatval($valInv->amount);

						if($dueDate<$today){
							if(intval($diff)>90){
								$overMonth += floatval($valInv->amount);
							}else if(intval($diff)>60){
								$threeMonth += floatval($valInv->amount);
							}else if(intval($diff)>30){
								$twoMonth += floatval($valInv->amount);
							}else{
								$oneMonth += floatval($valInv->amount);
							}
						}else{
							$current += floatval($valInv->amount);
						}

					}

					$data["results"][] = array(
						"id" 			=> $value->id,
						"fullIdName"	=> $value->wnumber. " " .$fullname,
						"current" 		=> $current,
						"oneMonth" 		=> $oneMonth,
						"twoMonth" 		=> $twoMonth,
						"threeMonth" 	=> $threeMonth,
						"overMonth" 	=> $overMonth,
						"amount" 		=> $amount
					);
				}				
			}
		}		

		//Response Data		
		$this->response($data, 200);	
	}

	//GET WATER AGING DETAIL
	function waging_detail_get() {		
		$filters 	= $this->get("filter")["filters"];		
		$page 		= $this->get('page') !== false ? $this->get('page') : 1;		
		$limit 		= $this->get('limit') !== false ? $this->get('limit') : 100;								
		$sort 	 	= $this->get("sort");		
		$data["results"] = array();
		$data["count"] = 0;

		$obj = new Invoice(null, $this->entity);		

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
				//Fullname		
				$contact = $value->contact->get();
				$fullname = $contact->surname.' '.$contact->name;
				if($contact->contact_type_id=="5" || $contact->contact_type_id=="6" || $contact->contact_type_id=="7"){
					$fullname = $contact->company;
				}

				//Age
				$ageGroup = "0-បច្ចុប្បន្ន";								
				$today = new DateTime();
				$dueDate = new DateTime($value->due_date);
				$diff = $today->diff($dueDate)->format("%a");

				if($dueDate<$today){
					if(intval($diff)>90){						
						$ageGroup = "91->∞";						
					}else if(intval($diff)>60){
						$ageGroup = "61-90";
					}else if(intval($diff)>30){
						$ageGroup = "31-60";
					}else{
						$ageGroup = "1-30";
					}					
				}

				$data["results"][] = array(
					"id" 			=> $value->id,
					"number" 		=> $value->number,
					"amount"		=> floatval($value->amount),
					"issued_date" 	=> $value->issued_date,
					"due_date" 		=> $value->due_date,

					"fullIdName"	=> $contact->wnumber ." ". $fullname,
					"age"			=> $diff,
					"អាយុកាល" 		=> $ageGroup	
				);
			}			
		}		

		//Response Data		
		$this->response($data, 200);	
	}

	//GET WATER SALE SUMMARY
	function wsale_summary_get() {		
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
			$usage = new Invoice_line(null, $this->entity);			
			
			//Filter		
			if(!empty($filters) && isset($filters)){
		    	foreach ($filters as $value) {
		    		if(!empty($value["operator"]) && isset($value["operator"])){
			    		if($value["operator"]=="between"){
			    			$sale->where_between($value["field"], $value["value1"], $value["value2"]);
			    			$usage->where_between_related("invoice", $value["field"], $value["value1"], $value["value2"]);
			    		}else{
			    			$sale->where($value["field"].' '.$value["operator"], $value["value"]);
			    			$usage->where($value["field"].' '.$value["operator"], $value["value"]);
			    		}		    			
		    		}else{	    			
		    			$sale->where($value["field"], $value["value"]);
		    			$usage->where($value["field"], $value["value"]);	    				    			
		    		}		    		
				}												 			
			}			

			//Sale
			$sale->select_sum('amount');		
			$sale->where("type", "wInvoice");
			$sale->where("location_id", $loc->id);
			$sale->where("deleted", 0);		
			$sale->get();

			//Usage
			$usage->select_sum('unit');		
			$usage->where_related("invoice", "type", "wInvoice");
			$usage->where_related("invoice", "location_id", $loc->id);
			$usage->where_related("invoice", "deleted", 0);		
			$usage->get();

			$data["results"][] = array(
				"branch_name"		=> $loc->company->get()->name,
				"location_name"		=> $loc->name,				
				"usage"				=> intval($usage->unit1),
				"amount"			=> floatval($sale->amount)			
			);
		}

		$data["count"] = count($data["results"]);		

		//Response Data		
		$this->response($data, 200);	
	}

	//GET WATER SALE DETAIL 
	function wsale_detail_get() {		
		$filters 	= $this->get("filter")["filters"];		
		$page 		= $this->get('page') !== false ? $this->get('page') : 1;		
		$limit 		= $this->get('limit') !== false ? $this->get('limit') : 100;								
		$sort 	 	= $this->get("sort");		
		$data["results"] = array();
		$data["count"] = 0;

		$obj = new Invoice(null, $this->entity);		

		//Sort
		if(!empty($sort) && isset($sort)){					
			foreach ($sort as $value) {
				if($value["field"]=="contact_type_name"){
					$obj->order_by_related("contact", "contact_type_id", $value["dir"]);				
				}else if($value["field"]=="location_name"){
					$obj->order_by("location_id", $value["dir"]);
				}else if($value["field"]=="contact_number" || $value["field"]=="fullname"){
					$obj->order_by("contact_id", $value["dir"]);
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
		$obj->include_related("location", "name");
		$obj->include_related("contact/contact_type", "name");
		$obj->include_related("contact", array("contact_type_id", "wnumber", "surname", "name", "company"));
		
		//Results
		$obj->get_paged_iterated($page, $limit);
		$data["count"] = $obj->paged->total_rows;							

		if($obj->result_count()>0){
			foreach ($obj as $value) {
				$fullname = $value->contact_surname.' '.$value->contact_name;
				if($value->contact_contact_type_id=="6" || $value->contact_contact_type_id=="7" || $value->contact_contact_type_id=="8"){
					$fullname = $value->contact_company;
				}

				$usage = 0;
				$lines = $value->invoice_line->get();				
				foreach ($lines as $l) {
					if($l->type=="tariff"){
						$usage += intval($l->unit);
					}
				}

				$data["results"][] = array(
					"id" 					=> $value->id,
					"contact_number" 		=> $value->contact_wnumber,
					"fullname" 				=> $fullname,
					"contact_type_name" 	=> $value->contact_contact_type_name,
					"location_name" 		=> $value->location_name,
					"usage" 				=> $usage,
					"amount" 				=> floatval($value->amount)		
				);
			}
		}		

		//Response Data		
		$this->response($data, 200);	
	}		
}
/* End of file invoices.php */
/* Location: ./application/controllers/api/invoices.php */