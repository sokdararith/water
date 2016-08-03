<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); //disallow direct access to this file

require APPPATH.'/libraries/REST_Controller.php';

class Contacts extends REST_Controller {
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
		$is_pattern = 0;
		$deleted = 0;

		$obj = new Contact(null, $this->_database);		

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
		    		}else if($value["operator"]=="search"){		    			
		    			$obj->like("number", $value["value"], "after");
		    			$obj->or_like("enumber", $value["value"], "after");
		    			$obj->or_like("wnumber", $value["value"], "after");
				    	$obj->or_like("surname", $value["value"], "after");
				    	$obj->or_like("name", $value["value"], "after");
				    	$obj->or_like("company", $value["value"], "after");				    
		    		}else{
		    			$obj->where($value["field"].' '.$value["operator"], $value["value"]);
		    		}
	    		}else{
	    			if($value["field"]=="is_pattern"){
	    				$is_pattern = $value["value"];
	    			}else if($value["field"]=="deleted"){
	    				$deleted = $value["value"];
	    			}else{
	    				$obj->where($value["field"], $value["value"]);
	    			}
	    		}
			}									 			
		}
		
		$obj->where("is_pattern", $is_pattern);
		$obj->where("deleted", $deleted);
		$obj->include_related("contact_type", "name");		

		//Results
		$obj->get_paged_iterated($page, $limit);
		$data["count"] = $obj->paged->total_rows;		
		
		if($obj->result_count()>0){
			foreach ($obj as $value) {
				$fullname = $value->surname.' '.$value->name;
				if($value->contact_type_id=="6" || $value->contact_type_id=="7" || $value->contact_type_id=="8"){
					$fullname = $value->company;
				}			

		 		$data["results"][] = array(
		 			"id" 					=> $value->id,		 			
					"company_id" 			=> $value->company_id,
					"ebranch_id" 			=> $value->ebranch_id,
					"elocation_id" 			=> $value->elocation_id,
					"wbranch_id" 			=> $value->wbranch_id,
					"wlocation_id" 			=> $value->wlocation_id,						
					"currency_id" 			=> $value->currency_id,
					"user_id"				=> $value->user_id, 	
					"contact_type_id" 		=> $value->contact_type_id,
					"eorder" 				=> $value->eorder,
					"worder" 				=> $value->worder,
					"number_head" 			=> $value->number_head, 						
					"number" 				=> $value->number,
					"wnumber_head" 			=> $value->wnumber_head,
					"enumber" 				=> $value->enumber,
					"enumber_head" 			=> $value->enumber_head,
					"wnumber" 				=> $value->wnumber,			
					"surname" 				=> $value->surname,			
					"name" 					=> $value->name,			
					"gender"				=> $value->gender,			
					"dob" 					=> $value->dob,				
					"pob" 					=> $value->pob,
					"latitute" 				=> $value->latitute,
					"longtitute" 			=> $value->longtitute,
					"credit_limit" 			=> $value->credit_limit,					
					"id_number" 			=> $value->id_number,
					"phone" 				=> $value->phone,
					"email" 				=> $value->email,
					"website" 				=> $value->website,					
					"job" 					=> $value->job,
					"vat_no" 				=> $value->vat_no,
					"family_member"			=> $value->family_member,
					"address" 				=> $value->address,
					"bill_to" 				=> $value->bill_to,
					"ship_to" 				=> $value->ship_to,
					"memo" 					=> $value->memo,
					"image_url" 			=> $value->image_url,				
					"company" 				=> $value->company,
					"company_en" 			=> $value->company_en,
					"bank_name" 			=> $value->bank_name,
					"bank_address" 			=> $value->bank_address,
					"bank_account_name" 	=> $value->bank_account_name,
					"bank_account_number" 	=> $value->bank_account_number,
					"name_on_cheque" 		=> $value->name_on_cheque,
					"business_type_id" 		=> $value->business_type_id,					
					"payment_term_id" 		=> $value->payment_term_id,
					"payment_method_id" 	=> $value->payment_method_id,
					"deposit_account_id"	=> $value->deposit_account_id,
					"discount_account_id" 	=> $value->discount_account_id,																		
					"contact_account_id" 	=> $value->contact_account_id,					
					"ra_id" 				=> $value->ra_id,
					"tax_item_id" 			=> $value->tax_item_id,					
					"phase_id" 				=> $value->phase_id,
					"voltage_id" 			=> $value->voltage_id,
					"ampere_id" 			=> $value->ampere_id,
					"registered_date" 		=> $value->registered_date,
					"use_electricity" 		=> $value->use_electricity,
					"use_water" 			=> $value->use_water,
					"is_local" 				=> $value->is_local,
					"is_pattern" 			=> $value->is_pattern,
					"status" 				=> $value->status,

					"fullname" 				=> $fullname,					
					"contact_type"			=> $value->contact_type_name,					
					"currency"				=> $value->currency->get_raw()->result()						
		 		);
			}
		}

		//Response Data		
		$this->response($data, 200);			
	}
	
	//POST
	function index_post() {
		$models = json_decode($this->post('models'));

		//Generate order number
		$lastContact = new Contact(null, $this->_database);
		$lastContact->order_by('id', 'desc')->limit(1)->get();
		$last_id = intval($lastContact->id);

		foreach ($models as $value) {
			$last_id++;

			$obj = new Contact(null, $this->_database);
			isset($value->company_id) 			? $obj->company_id 			= $value->company_id : "";
			isset($value->ebranch_id) 			? $obj->ebranch_id 			= $value->ebranch_id : "";
			isset($value->elocation_id) 		? $obj->elocation_id 		= $value->elocation_id : "";
			isset($value->wbranch_id) 			? $obj->wbranch_id 			= $value->wbranch_id : "";
			isset($value->wlocation_id) 		? $obj->wlocation_id		= $value->wlocation_id : "";		
			isset($value->currency_id) 			? $obj->currency_id			= $value->currency_id : "";
			isset($value->user_id)				? $obj->user_id 			= $value->user_id : "";
			isset($value->contact_type_id)		? $obj->contact_type_id 	= $value->contact_type_id : "";					
												  $obj->eorder				= $last_id;
												  $obj->worder				= $last_id;
			isset($value->number_head)			? $obj->number_head			= $value->number_head : "";
			isset($value->number)				? $obj->number				= $value->number : "";
			isset($value->enumber_head)			? $obj->enumber_head		= $value->enumber_head : "";
			isset($value->enumber)				? $obj->enumber				= $value->enumber : "";
			isset($value->wnumber_head)			? $obj->wnumber_head		= $value->wnumber_head : "";
			isset($value->wnumber)				? $obj->wnumber				= $value->wnumber : "";
			isset($value->surname)				? $obj->surname				= $value->surname : "";
			isset($value->name)					? $obj->name				= $value->name : "";
			isset($value->gender)				? $obj->gender				= $value->gender : "";
			isset($value->dob)					? $obj->dob					= date("Y-m-d", strtotime($value->dob)) : "";
			isset($value->pob)					? $obj->pob					= $value->pob : "";
			isset($value->latitute)				? $obj->latitute 			= $value->latitute : "";
			isset($value->longtitute)			? $obj->longtitute 			= $value->longtitute : "";
			isset($value->credit_limit)			? $obj->credit_limit		= $value->credit_limit : "";			
			isset($value->id_number)			? $obj->id_number			= $value->id_number : "";
			isset($value->phone)				? $obj->phone 				= $value->phone : "";
			isset($value->email)				? $obj->email 				= $value->email : "";			
			isset($value->website)				? $obj->website				= $value->website : "";
			isset($value->job)					? $obj->job					= $value->job : "";
			isset($value->vat_no)				? $obj->vat_no				= $value->vat_no : "";
			isset($value->family_member)		? $obj->family_member		= $value->family_member : "";
			isset($value->address)				? $obj->address 			= $value->address : "";
			isset($value->bill_to)				? $obj->bill_to 			= $value->bill_to : "";
			isset($value->ship_to)				? $obj->ship_to 			= $value->ship_to : "";
			isset($value->memo)					? $obj->memo				= $value->memo : "";							
			isset($value->image_url)			? $obj->image_url			= $value->image_url : "";
			isset($value->company)				? $obj->company				= $value->company : "";
			isset($value->company_en)			? $obj->company_en			= $value->company_en : "";
			isset($value->bank_name)			? $obj->bank_name			= $value->bank_name : "";
			isset($value->bank_address)			? $obj->bank_address		= $value->bank_address : "";
			isset($value->bank_account_name)	? $obj->bank_account_name	= $value->bank_account_name : "";
			isset($value->bank_account_number)	? $obj->bank_account_number	= $value->bank_account_number : "";
			isset($value->name_on_cheque)		? $obj->name_on_cheque		= $value->name_on_cheque : "";
			isset($value->business_type_id)		? $obj->business_type_id	= $value->business_type_id : "";
			isset($value->payment_term_id)		? $obj->payment_term_id		= $value->payment_term_id : "";
			isset($value->payment_method_id)	? $obj->payment_method_id	= $value->payment_method_id : "";
			isset($value->deposit_account_id)	? $obj->deposit_account_id	= $value->deposit_account_id : "";
			isset($value->discount_account_id)	? $obj->discount_account_id	= $value->discount_account_id : "";			
			isset($value->contact_account_id)	? $obj->contact_account_id	= $value->contact_account_id : "";
			isset($value->ra_id)				? $obj->ra_id				= $value->ra_id : "";
			isset($value->tax_item_id)			? $obj->tax_item_id			= $value->tax_item_id : "";
			isset($value->phase_id)				? $obj->phase_id			= $value->phase_id : "";
			isset($value->voltage_id)			? $obj->voltage_id			= $value->voltage_id : "";
			isset($value->ampere_id)			? $obj->ampere_id			= $value->ampere_id : "";
			isset($value->registered_date)		? $obj->registered_date 	= date("Y-m-d", strtotime($value->registered_date)) : "";		
			isset($value->use_electricity)		? $obj->use_electricity		= $value->use_electricity : "";
			isset($value->use_water)			? $obj->use_water			= $value->use_water : "";
			isset($value->is_local)				? $obj->is_local			= $value->is_local : "";
			isset($value->is_pattern)			? $obj->is_pattern			= $value->is_pattern : "";
			isset($value->status)				? $obj->status				= $value->status : "";			
			isset($value->deleted)				? $obj->deleted				= $value->deleted : "";							

			if($obj->save()){
				$fullname = $obj->surname.' '.$obj->name;
				if($obj->contact_type_id=="6" || $obj->contact_type_id=="7" || $obj->contact_type_id=="8"){
					$fullname = $obj->company;
				}

				//Respsone
				$data["results"][] = array(
					"id" 					=> $obj->id,		 			
					"company_id" 			=> $obj->company_id,
					"ebranch_id" 			=> $obj->ebranch_id,
					"elocation_id" 			=> $obj->elocation_id,
					"wbranch_id" 			=> $obj->wbranch_id,
					"wlocation_id" 			=> $obj->wlocation_id,						
					"currency_id" 			=> $obj->currency_id,
					"user_id"				=> $obj->user_id, 	
					"contact_type_id" 		=> $obj->contact_type_id,
					"eorder" 				=> $obj->eorder,
					"worder" 				=> $obj->worder,
					"number_head" 			=> $obj->number_head, 						
					"number" 				=> $obj->number,
					"wnumber_head" 			=> $obj->wnumber_head,
					"enumber" 				=> $obj->enumber,
					"enumber_head" 			=> $obj->enumber_head,
					"wnumber" 				=> $obj->wnumber,			
					"surname" 				=> $obj->surname,			
					"name" 					=> $obj->name,			
					"gender"				=> $obj->gender,			
					"dob" 					=> $obj->dob,				
					"pob" 					=> $obj->pob,
					"latitute" 				=> $obj->latitute,
					"longtitute" 			=> $obj->longtitute,
					"credit_limit" 			=> $obj->credit_limit,					
					"id_number" 			=> $obj->id_number,
					"phone" 				=> $obj->phone,
					"email" 				=> $obj->email,
					"website" 				=> $obj->website,					
					"job" 					=> $obj->job,
					"vat_no" 				=> $obj->vat_no,
					"family_member"			=> $obj->family_member,
					"address" 				=> $obj->address,
					"bill_to" 				=> $obj->bill_to,
					"ship_to" 				=> $obj->ship_to,
					"memo" 					=> $obj->memo,
					"image_url" 			=> $obj->image_url,				
					"company" 				=> $obj->company,
					"company_en" 			=> $obj->company_en,
					"bank_name" 			=> $obj->bank_name,
					"bank_address" 			=> $obj->bank_address,
					"bank_account_name" 	=> $obj->bank_account_name,
					"bank_account_number" 	=> $obj->bank_account_number,
					"name_on_cheque" 		=> $obj->name_on_cheque,
					"business_type_id" 		=> $obj->business_type_id,					
					"payment_term_id" 		=> $obj->payment_term_id,
					"payment_method_id" 	=> $obj->payment_method_id,
					"deposit_account_id"	=> $obj->deposit_account_id,
					"discount_account_id" 	=> $obj->discount_account_id,																		
					"contact_account_id" 	=> $obj->contact_account_id,					
					"ra_id" 				=> $obj->ra_id,
					"tax_item_id" 			=> $obj->tax_item_id,					
					"phase_id" 				=> $obj->phase_id,
					"voltage_id" 			=> $obj->voltage_id,
					"ampere_id" 			=> $obj->ampere_id,
					"registered_date" 		=> $obj->registered_date,
					"use_electricity" 		=> $obj->use_electricity,
					"use_water" 			=> $obj->use_water,
					"is_local" 				=> $obj->is_local,
					"is_pattern" 			=> $obj->is_pattern,
					"status" 				=> $obj->status,

					"fullname" 				=> $fullname,					
					"contact_type"			=> $obj->contact_type->get_raw()->result(),					
					"currency"				=> $obj->currency->get_raw()->result()
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
			$obj = new Contact(null, $this->_database);
			$obj->get_by_id($value->id);

			isset($value->company_id) 			? $obj->company_id 			= $value->company_id : "";
			isset($value->ebranch_id) 			? $obj->ebranch_id 			= $value->ebranch_id : "";
			isset($value->elocation_id) 		? $obj->elocation_id 		= $value->elocation_id : "";
			isset($value->wbranch_id) 			? $obj->wbranch_id 			= $value->wbranch_id : "";
			isset($value->wlocation_id) 		? $obj->wlocation_id		= $value->wlocation_id : "";		
			isset($value->currency_id) 			? $obj->currency_id			= $value->currency_id : "";
			isset($value->user_id)				? $obj->user_id 			= $value->user_id : "";
			isset($value->contact_type_id)		? $obj->contact_type_id 	= $value->contact_type_id : "";					
			isset($value->eorder)				? $obj->eorder				= $value->eorder : "";
			isset($value->worder)				? $obj->worder				= $value->worder : "";
			isset($value->number_head)			? $obj->number_head			= $value->number_head : "";
			isset($value->number)				? $obj->number				= $value->number : "";
			isset($value->enumber_head)			? $obj->enumber_head		= $value->enumber_head : "";
			isset($value->enumber)				? $obj->enumber				= $value->enumber : "";
			isset($value->wnumber_head)			? $obj->wnumber_head		= $value->wnumber_head : "";
			isset($value->wnumber)				? $obj->wnumber				= $value->wnumber : "";
			isset($value->surname)				? $obj->surname				= $value->surname : "";
			isset($value->name)					? $obj->name				= $value->name : "";
			isset($value->gender)				? $obj->gender				= $value->gender : "";
			isset($value->dob)					? $obj->dob					= date("Y-m-d", strtotime($value->dob)) : "";
			isset($value->pob)					? $obj->pob					= $value->pob : "";				
			isset($value->family_member)		? $obj->family_member		= $value->family_member : "";
			isset($value->id_number)			? $obj->id_number			= $value->id_number : "";
			isset($value->phone)				? $obj->phone 				= $value->phone : "";
			isset($value->email)				? $obj->email 				= $value->email : "";				
			isset($value->job)					? $obj->job					= $value->job : "";
			isset($value->company)				? $obj->company				= $value->company : "";
			isset($value->company_en)			? $obj->company_en			= $value->company_en : "";			
			isset($value->business_type_id)		? $obj->business_type_id	= $value->business_type_id : "";
			isset($value->vat_no)				? $obj->vat_no				= $value->vat_no : "";				
			isset($value->image_url)			? $obj->image_url			= $value->image_url : "";
			isset($value->memo)					? $obj->memo				= $value->memo : "";
			isset($value->address)				? $obj->address 			= $value->address : "";
			isset($value->bill_to)				? $obj->bill_to 			= $value->bill_to : "";
			isset($value->ship_to)				? $obj->ship_to 			= $value->ship_to : "";
			isset($value->latitute)				? $obj->latitute 			= $value->latitute : "";
			isset($value->longtitute)			? $obj->longtitute 			= $value->longtitute : "";
			isset($value->payment_term_id)		? $obj->payment_term_id		= $value->payment_term_id : "";
			isset($value->payment_method_id)	? $obj->payment_method_id	= $value->payment_method_id : "";
			isset($value->credit_limit)			? $obj->credit_limit		= $value->credit_limit : "";					
			isset($value->registered_date)		? $obj->registered_date 	= date("Y-m-d", strtotime($value->registered_date)) : "";
			isset($value->contact_account_id)	? $obj->contact_account_id	= $value->contact_account_id : "";
			isset($value->ra_id)				? $obj->ra_id				= $value->ra_id : "";
			isset($value->tax_item_id)			? $obj->tax_item_id			= $value->tax_item_id : "";
			isset($value->deposit_account_id)	? $obj->deposit_account_id	= $value->deposit_account_id : "";
			isset($value->discount_account_id)	? $obj->discount_account_id	= $value->discount_account_id : "";
			isset($value->phase_id)				? $obj->phase_id			= $value->phase_id : "";
			isset($value->voltage_id)			? $obj->voltage_id			= $value->voltage_id : "";
			isset($value->ampere_id)			? $obj->ampere_id			= $value->ampere_id : "";		
			isset($value->use_electricity)		? $obj->use_electricity		= $value->use_electricity : "";
			isset($value->use_water)			? $obj->use_water			= $value->use_water : "";
			isset($value->is_local)				? $obj->is_local			= $value->is_local : "";
			isset($value->is_pattern)			? $obj->is_pattern			= $value->is_pattern : "";
			isset($value->status)				? $obj->status				= $value->status : "";			
			isset($value->deleted)				? $obj->deleted				= $value->deleted : "";

			if($obj->save()){
				$fullname = $obj->surname.' '.$obj->name;
				if($obj->contact_type_id=="6" || $obj->contact_type_id=="7" || $obj->contact_type_id=="8"){
					$fullname = $obj->company;
				}
								
				//Results
				$data["results"][] = array(
					"id" 					=> $obj->id,		 			
					"company_id" 			=> $obj->company_id,
					"ebranch_id" 			=> $obj->ebranch_id,
					"elocation_id" 			=> $obj->elocation_id,
					"wbranch_id" 			=> $obj->wbranch_id,
					"wlocation_id" 			=> $obj->wlocation_id,						
					"currency_id" 			=> $obj->currency_id,
					"user_id"				=> $obj->user_id, 	
					"contact_type_id" 		=> $obj->contact_type_id,
					"eorder" 				=> $obj->eorder,
					"worder" 				=> $obj->worder,
					"number_head" 			=> $obj->number_head, 						
					"number" 				=> $obj->number,
					"wnumber_head" 			=> $obj->wnumber_head,
					"enumber" 				=> $obj->enumber,
					"enumber_head" 			=> $obj->enumber_head,
					"wnumber" 				=> $obj->wnumber,			
					"surname" 				=> $obj->surname,			
					"name" 					=> $obj->name,			
					"gender"				=> $obj->gender,			
					"dob" 					=> $obj->dob,				
					"pob" 					=> $obj->pob,
					"latitute" 				=> $obj->latitute,
					"longtitute" 			=> $obj->longtitute,
					"credit_limit" 			=> $obj->credit_limit,					
					"id_number" 			=> $obj->id_number,
					"phone" 				=> $obj->phone,
					"email" 				=> $obj->email,
					"website" 				=> $obj->website,					
					"job" 					=> $obj->job,
					"vat_no" 				=> $obj->vat_no,
					"family_member"			=> $obj->family_member,
					"address" 				=> $obj->address,
					"bill_to" 				=> $obj->bill_to,
					"ship_to" 				=> $obj->ship_to,
					"memo" 					=> $obj->memo,
					"image_url" 			=> $obj->image_url,				
					"company" 				=> $obj->company,
					"company_en" 			=> $obj->company_en,
					"bank_name" 			=> $obj->bank_name,
					"bank_address" 			=> $obj->bank_address,
					"bank_account_name" 	=> $obj->bank_account_name,
					"bank_account_number" 	=> $obj->bank_account_number,
					"name_on_cheque" 		=> $obj->name_on_cheque,
					"business_type_id" 		=> $obj->business_type_id,					
					"payment_term_id" 		=> $obj->payment_term_id,
					"payment_method_id" 	=> $obj->payment_method_id,
					"deposit_account_id"	=> $obj->deposit_account_id,
					"discount_account_id" 	=> $obj->discount_account_id,																		
					"contact_account_id" 	=> $obj->contact_account_id,					
					"ra_id" 				=> $obj->ra_id,
					"tax_item_id" 			=> $obj->tax_item_id,					
					"phase_id" 				=> $obj->phase_id,
					"voltage_id" 			=> $obj->voltage_id,
					"ampere_id" 			=> $obj->ampere_id,
					"registered_date" 		=> $obj->registered_date,
					"use_electricity" 		=> $obj->use_electricity,
					"use_water" 			=> $obj->use_water,
					"is_local" 				=> $obj->is_local,
					"is_pattern" 			=> $obj->is_pattern,
					"status" 				=> $obj->status,

					"fullname" 				=> $fullname,					
					"contact_type"			=> $obj->contact_type->get_raw()->result(),					
					"currency"				=> $obj->currency->get_raw()->result()
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
			$obj = new Contact(null, $this->_database);
			$obj->where("id", $value->id)->get();
			
			$data["results"][] = array(
				"data"   => $value,
				"status" => $obj->delete()
			);							
		}

		//Response data
		$this->response($data, 200);
	}


	//GET BRANCH
	function branch_get() {		
		$filters 	= $this->get("filter")["filters"];		
		$page 		= $this->get('page') !== false ? $this->get('page') : 1;		
		$limit 		= $this->get('limit') !== false ? $this->get('limit') : 100;								
		$sort 	 	= $this->get("sort");		
		$data["results"] = array();
		$data["count"] = 0;

		$obj = new Company(null, $this->_database);		

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
		 			"id" 				=> $value->id,					
					"utility_id" 		=> $value->utility_id,
					"currency_id" 		=> $value->currency_id,
					"province_id" 		=> $value->province_id,
					"country_id" 		=> $value->country_id,
					"name" 				=> $value->name,
					"description" 		=> $value->description,
					"abbr" 				=> $value->abbr,
					"representative" 	=> $value->representative,
					"email" 			=> $value->email,
					"mobile" 			=> $value->mobile,
					"phone" 			=> $value->phone,
					"address" 			=> $value->address,						
					"expire_date" 		=> $value->expire_date,
					"max_customer" 		=> $value->max_customer,
					"operation_license" => $value->operation_license,
					"term_of_condition" => $value->term_of_condition,
					"image_url" 		=> $value->image_url,
					"status" 			=> $value->status,

					"currency"			=> $value->currency->get_raw()->result(),			
		 		);
			}
		}

		//Response Data		
		$this->response($data, 200);			
	}
	
	//POST BRANCH
	function branch_post() {
		$models = json_decode($this->post('models'));

		foreach ($models as $value) {
			$obj = new Company(null, $this->_database);						
					 			
			$obj->utility_id 		= $value->utility_id;
			$obj->currency_id 		= $value->currency_id;
			$obj->province_id 		= $value->province_id;
			$obj->country_id 		= $value->country_id;
			$obj->name				= $value->name;
			$obj->description 		= $value->description;
			$obj->abbr 				= $value->abbr;
			$obj->representative 	= $value->representative;
			$obj->email 			= $value->email;
			$obj->mobile 			= $value->mobile;
			$obj->phone 			= $value->phone;
			$obj->address 			= $value->address;						
			$obj->expire_date 		= isset($value->expire_date)?date("Y-m-d", strtotime($value->expire_date)):"";
			$obj->max_customer 		= $value->max_customer;
			$obj->operation_license = $value->operation_license;
			$obj->term_of_condition = $value->term_of_condition;
			$obj->image_url 		= $value->image_url;
			$obj->status 			= $value->status;
			
			if($obj->save()){
				//Respsone
				$data["results"][] = array(					
					"id" 				=> $obj->id,
					"utility_id" 		=> $obj->utility_id,		 			
					"currency_id" 		=> $obj->currency_id,
					"province_id" 		=> $obj->province_id,
					"country_id" 		=> $obj->country_id,
					"name" 				=> $obj->name,
					"description" 		=> $obj->description,
					"abbr" 				=> $obj->abbr,
					"representative" 	=> $obj->representative,
					"email" 			=> $obj->email,
					"mobile" 			=> $obj->mobile,
					"phone" 			=> $obj->phone,
					"address" 			=> $obj->address,						
					"expire_date" 		=> $obj->expire_date,
					"max_customer" 		=> $obj->max_customer,
					"operation_license" => $obj->operation_license,
					"term_of_condition" => $obj->term_of_condition,
					"image_url" 		=> $obj->image_url,
					"status" 			=> $obj->status	
				);				
			}		
		}
		$data["count"] = count($data["results"]);

		$this->response($data, 201);
	}
	
	//PUT BRANCH
	function branch_put() {
		$models = json_decode($this->put('models'));
		$data["results"] = array();
		$data["count"] = 0;

		foreach ($models as $value) {			
			$obj = new Company(null, $this->_database);
			$obj->get_by_id($value->id);

			$obj->utility_id 		= $value->utility_id;
			$obj->currency_id 		= $value->currency_id;
			$obj->province_id 		= $value->province_id;
			$obj->country_id 		= $value->country_id;
			$obj->name				= $value->name;
			$obj->description 		= $value->description;
			$obj->abbr 				= $value->abbr;
			$obj->representative 	= $value->representative;
			$obj->email 			= $value->email;
			$obj->mobile 			= $value->mobile;
			$obj->phone 			= $value->phone;
			$obj->address 			= $value->address;						
			$obj->expire_date 		= $value->expire_date;
			$obj->max_customer 		= $value->max_customer;
			$obj->operation_license = $value->operation_license;
			$obj->term_of_condition = $value->term_of_condition;
			$obj->image_url 		= $value->image_url;
			$obj->status 			= $value->status;

			if($obj->save()){				
				//Results
				$data["results"][] = array(
					"id" 				=> $obj->id,
					"utility_id" 		=> $obj->utility_id,		 			
					"currency_id" 		=> $obj->currency_id,
					"province_id" 		=> $obj->province_id,
					"country_id" 		=> $obj->country_id,
					"name" 				=> $obj->name,
					"description" 		=> $obj->description,
					"abbr" 				=> $obj->abbr,
					"representative" 	=> $obj->representative,
					"email" 			=> $obj->email,
					"mobile" 			=> $obj->mobile,
					"phone" 			=> $obj->phone,
					"address" 			=> $obj->address,						
					"expire_date" 		=> $obj->expire_date,
					"max_customer" 		=> $obj->max_customer,
					"operation_license" => $obj->operation_license,
					"term_of_condition" => $obj->term_of_condition,
					"image_url" 		=> $obj->image_url,
					"status" 			=> $obj->status	
				);						
			}
		}
		$data["count"] = count($data["results"]);

		$this->response($data, 200);
	}
	
	//DELETE BRANCH
	function branch_delete() {
		$models = json_decode($this->delete('models'));

		foreach ($models as $key => $value) {
			$obj = new Company(null, $this->_database);
			$obj->where("id", $value->id)->get();
			
			$data["results"][] = array(
				"data"   => $value,
				"status" => $obj->delete()
			);							
		}

		//Response data
		$this->response($data, 200);
	}


	//GET TYPE
	function type_get() {		
		$filters 	= $this->get("filter")["filters"];		
		$page 		= $this->get('page') !== false ? $this->get('page') : 1;		
		$limit 		= $this->get('limit') !== false ? $this->get('limit') : 100;								
		$sort 	 	= $this->get("sort");		
		$data["results"] = array();
		$data["count"] = 0;

		$obj = new Contact_type(null, $this->_database);		

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
		 			"id" 			=> $value->id,		 			
					"parent_id" 	=> $value->parent_id,
					"contact_id" 	=> $value->contact_id,						
					"name" 			=> $value->name,
					"description" 	=> $value->description,
					"is_system" 	=> $value->is_system						
		 		);
			}
		}

		//Response Data		
		$this->response($data, 200);			
	}
	
	//POST TYPE
	function type_post() {
		$models = json_decode($this->post('models'));

		foreach ($models as $value) {
			$obj = new Contact_type(null, $this->_database);
			$obj->parent_id 	= $value->parent_id;
			$obj->contact_id 	= $value->contact_id;			
			$obj->name 			= $value->name;
			$obj->description 	= isset($value->description)?$value->description:"";
			$obj->is_system 	= isset($value->is_system)?$value->is_system:0;
			
			if($obj->save()){
				//Respsone
				$data["results"][] = array(					
					"id" 			=> $obj->id,		 			
					"parent_id" 	=> $obj->parent_id,
					"contact_id" 	=> $obj->contact_id,
					"name" 			=> $obj->name,
					"description" 	=> $obj->description,
					"is_system" 	=> $obj->is_system	
				);				
			}		
		}
		$data["count"] = count($data["results"]);

		$this->response($data, 201);
	}
	
	//PUT TYPE
	function type_put() {
		$models = json_decode($this->put('models'));
		$data["results"] = array();
		$data["count"] = 0;

		foreach ($models as $value) {			
			$obj = new Contact_type(null, $this->_database);
			$obj->get_by_id($value->id);

			$obj->parent_id 	= $value->parent_id;
			$obj->contact_id 	= $value->contact_id;			
			$obj->name 			= $value->name;
			$obj->description 	= isset($value->description)?$value->description:"";
			$obj->is_system 	= isset($value->is_system)?$value->is_system:0;

			if($obj->save()){				
				//Results
				$data["results"][] = array(
					"id"			=> $obj->id,
					"parent_id" 	=> $obj->parent_id,
					"contact_id" 	=> $obj->contact_id,						
					"name" 			=> $obj->name,
					"description" 	=> $obj->description,
					"is_system" 	=> $obj->is_system
				);						
			}
		}
		$data["count"] = count($data["results"]);

		$this->response($data, 200);
	}
	
	//DELETE TYPE
	function type_delete() {
		$models = json_decode($this->delete('models'));

		foreach ($models as $key => $value) {
			$obj = new Contact_type(null, $this->_database);
			$obj->where("id", $value->id)->get();
			
			$data["results"][] = array(
				"data"   => $value,
				"status" => $obj->delete()
			);							
		}

		//Response data
		$this->response($data, 200);
	}

	//GET Employee
	function employee_get() {		
		$filters 	= $this->get("filter")["filters"];		
		$page 		= $this->get('page') !== false ? $this->get('page') : 1;		
		$limit 		= $this->get('limit') !== false ? $this->get('limit') : 100;								
		$sort 	 	= $this->get("sort");		
		$data["results"] = array();
		$data["count"] = 0;

		$obj = new Contact(null, $this->_database);		

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
		    		}else if($value["operator"]=="search"){		    			
		    			$obj->like("number", $value["value"], "after");
		    			$obj->or_like("enumber", $value["value"], "after");
		    			$obj->or_like("wnumber", $value["value"], "after");
				    	$obj->or_like("surname", $value["value"], "after");
				    	$obj->or_like("name", $value["value"], "after");
				    	$obj->or_like("company", $value["value"], "after");				    
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
				$fullname = $value->surname.' '.$value->name;							

		 		$data["results"][] = array(
		 			"id" 					=> $value->id,
					"fullname" 				=> $value->surname.' '.$value->name					
		 		);
			}
		}

		//Response Data		
		$this->response($data, 200);			
	}	


	//WATER
	//GET WATER ORDER
	function worder_get() {		
		$filters 	= $this->get();		
		$page 		= $this->get('page') !== false ? $this->get('page') : 1;		
		$limit 		= $this->get('limit') !== false ? $this->get('limit') : 100;								
		$sort 	 	= $this->get("sort");		
		$data["results"] = array();
		$data["count"] = 0;

		$obj = new Contact(null, $this->_database);		

		//Filter
		if(!empty($filters["location_id"])){
	    	$obj->where("wlocation_id", $filters["location_id"]);										 			
		}

		//Only customer
		$obj->include_related("contact_type", "name");
		$obj->where_related("contact_type", "parent_id", 1);
		$obj->order_by("worder", "asc");

		//Results
		$obj->get_paged_iterated($page, $limit);
		$data["count"] = $obj->paged->total_rows;		
		
		if($obj->result_count()>0){
			foreach ($obj as $value) {
				$fullname = $value->surname.' '.$value->name;
				if($value->contact_type_id=="6" || $value->contact_type_id=="7" || $value->contact_type_id=="8"){
					$fullname = $value->company;
				}			

		 		$data["results"][] = array(
		 			"id" 					=> $value->id,					
					"worder" 				=> intval($value->worder),					
					"wnumber" 				=> $value->wnumber,
					"fullname" 				=> $fullname					
		 		);
			}
		}

		//Response Data		
		$this->response($data, 200);			
	}
	//GET WATER CUSTOMER LIST
	function wlist_get() {		
		$filters 	= $this->get("filter")["filters"];		
		$page 		= $this->get('page') !== false ? $this->get('page') : 1;		
		$limit 		= $this->get('limit') !== false ? $this->get('limit') : 100;								
		$sort 	 	= $this->get("sort");		
		$data["results"] = array();
		$data["count"] = 0;

		$obj = new Contact(null, $this->_database);		

		//Sort
		if(!empty($sort) && isset($sort)){					
			foreach ($sort as $value) {
				if($value["field"]=="fullname"){
					$obj->order_by("id", $value["dir"]);					
				}else if($value["field"]=="contact_type_name"){
					$obj->order_by("contact_type_id", $value["dir"]);
				}else if($value["field"]=="wlocation_name"){
					$obj->order_by("wlocation_id", $value["dir"]);
				}else if($value["field"]=="wbranch_name"){
					$obj->order_by("wbranch_id", $value["dir"]);				
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
		    		}else{
		    			$obj->where($value["field"].' '.$value["operator"], $value["value"]);
		    		}
	    		}else{
	    			$obj->where($value["field"], $value["value"]);
	    		}
			}									 			
		}

		//Only water customer
		$obj->where("use_water", 1);
		$obj->include_related("contact_type", "name");
		$obj->where_related("contact_type", "parent_id", 1);				

		//Results
		$obj->get_paged_iterated($page, $limit);
		$data["count"] = $obj->paged->total_rows;

		if($obj->exists()){
			foreach ($obj as $value) {
				$fullname = $value->surname.' '.$value->name;
				if($value->contact_type_id=="6" || $value->contact_type_id=="7" || $value->contact_type_id=="8"){
					$fullname = $value->company;
				}
				
		 		$data["results"][] = array(
		 			"id" 					=> $value->id,		 			
		 			"wnumber" 				=> $value->wnumber,
					"fullname" 				=> $fullname,									
					"contact_type_name"		=> $value->contact_type_name,										
					"wlocation_name" 		=> $value->wlocation->get()->name,
					"wbranch_name" 			=> $value->wbranch->get()->name,												
		 		);
			}
		}

		//Response Data		
		$this->response($data, 200);			
	}

	//GET WATER CUSTOMER BALANCE
	function wbalance_get() {		
		$filters 	= $this->get("filter")["filters"];		
		$page 		= $this->get('page') !== false ? $this->get('page') : 1;		
		$limit 		= $this->get('limit') !== false ? $this->get('limit') : 100;								
		$sort 	 	= $this->get("sort");		
		$data["results"] = array();
		$data["count"] = 0;

		$obj = new Contact(null, $this->_database);		

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

		//Only water customer
		$obj->where("use_water", 1);
		$obj->include_related("contact_type", "name");
		$obj->where_related("contact_type", "parent_id", 1);				

		//Results
		$obj->get_paged_iterated($page, $limit);
		$data["count"] = $obj->paged->total_rows;

		if($obj->exists()){
			foreach ($obj as $value) {
				$fullname = $value->surname.' '.$value->name;
				if($value->contact_type_id=="6" || $value->contact_type_id=="7" || $value->contact_type_id=="8"){
					$fullname = $value->company;
				}

				$balance = $value->invoice;
				$balance->select_sum("amount");
				$balance->where("type", "wInvoice");
				$balance->where("status", 0);
				$balance->get();
								
		 		$data["results"][] = array(
		 			"id" 					=> $value->id,		 			
		 			"wnumber" 				=> $value->wnumber,
					"fullname" 				=> $fullname,									
					"contact_type_name"		=> $value->contact_type_name,					
					"wbranch_name" 			=> $value->wbranch->get()->name,					
					"wlocation_name" 		=> $value->wlocation->get()->name,
					"balance" 				=> floatval($balance->amount)												
		 		);
			}
		}

		//Response Data		
		$this->response($data, 200);			
	}

	//GET WATER CUSTOMER DEPOSIT
	function wdeposit_get() {		
		$filters 	= $this->get("filter")["filters"];		
		$page 		= $this->get('page') !== false ? $this->get('page') : 1;		
		$limit 		= $this->get('limit') !== false ? $this->get('limit') : 100;								
		$sort 	 	= $this->get("sort");		
		$data["results"] = array();
		$data["count"] = 0;

		$obj = new Contact(null, $this->_database);		

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

		//Only water customer
		$obj->where("use_water", 1);
		$obj->include_related("contact_type", "name");
		$obj->where_related("contact_type", "parent_id", 1);				

		//Results
		$obj->get_paged_iterated($page, $limit);
		$data["count"] = $obj->paged->total_rows;

		if($obj->exists()){
			foreach ($obj as $value) {
				$fullname = $value->surname.' '.$value->name;
				if($value->contact_type_id=="6" || $value->contact_type_id=="7" || $value->contact_type_id=="8"){
					$fullname = $value->company;
				}

				$deposit = $value->payment;
				$deposit->select_sum("amount");
				$deposit->where("type", "wdeposit");
				$deposit->get();
								
		 		$data["results"][] = array(
		 			"id" 					=> $value->id,		 			
		 			"wnumber" 				=> $value->wnumber,
					"fullname" 				=> $fullname,									
					"contact_type_name"		=> $value->contact_type_name,					
					"wbranch_name" 			=> $value->wbranch->get()->name,					
					"wlocation_name" 		=> $value->wlocation->get()->name,
					"deposit" 				=> floatval($deposit->amount)												
		 		);
			}
		}

		//Response Data		
		$this->response($data, 200);			
	}

	//GET CUSTOMER NO METER
	function no_meter_get() {		
		$filters 	= $this->get("filter")["filters"];		
		$page 		= $this->get('page') !== false ? $this->get('page') : 1;		
		$limit 		= $this->get('limit') !== false ? $this->get('limit') : 100;								
		$sort 	 	= $this->get("sort");		
		$data["results"] = array();
		$data["count"] = 0;

		$obj = new Contact(null, $this->_database);
		$sub_obj = new Contact(null, $this->_database);		

		//Sort
		if(!empty($sort) && isset($sort)){					
			foreach ($sort as $value) {
				$obj->order_by($value["field"], $value["dir"]);
			}
		}				

		// //Filter
		// if(!empty($filters) && isset($filters)){			
	 //    	foreach ($filters as $value) {	    		
	 //    		$obj->where($value["field"], $value["value"]);

	 //    		if($value["field"]=="ebranch_id" || $value["field"]=="wbranch_id"){
	 //    			$sub_obj->select('id')->where_related_meter('company_id', $value["value"]);
	 //    		}	    		    		
		// 	}									 			
		// }

		//Only customer
		$obj->where("use_water", 1);
		$obj->include_related("contact_type", "name");
		$obj->where_related("contact_type", "parent_id", 1);		

		//Subquery
		$sub_obj->select("id")->where_related("meter", "utility_id", 2);
		$obj->where_not_in_subquery('id', $sub_obj);	

		//Results
		$obj->get_paged_iterated($page, $limit);
		$data["count"] = $obj->paged->total_rows;		
		
		if($obj->exists()){
			foreach ($obj as $value) {
				$fullname = $value->surname.' '.$value->name;
				if($value->contact_type_id=="6" || $value->contact_type_id=="7" || $value->contact_type_id=="8"){
					$fullname = $value->company;
				}				

				//Electricity Deposit
				$edeposit = new Payment(null, $this->_database);
				$edeposit->where("contact_id", $value->id);
				$edeposit->select_sum("amount");
				$edeposit->where("type", "edeposit");
				$edeposit->get();

				//Water Deposit
				$wdeposit = new Payment(null, $this->_database);
				$wdeposit->where("contact_id", $value->id);
				$wdeposit->select_sum("amount");
				$wdeposit->where("type", "wdeposit");
				$wdeposit->get();

		 		$data["results"][] = array(		 						
					"id" 					=> $value->id,
		 			"number" 				=> $value->number,
		 			"enumber" 				=> $value->enumber,
		 			"wnumber" 				=> $value->wnumber,
					"fullname" 				=> $fullname,					
					"contact_type_name"		=> $value->contact_type_name,					
					"ebranch_name" 			=> $value->ebranch->get()->name,
					"wbranch_name" 			=> $value->wbranch->get()->name,
					"elocation_name" 		=> $value->elocation->get()->name,
					"wlocation_name" 		=> $value->wlocation->get()->name,								
					"edeposit" 				=> floatval($edeposit->amount),
					"wdeposit" 				=> floatval($wdeposit->amount)				
		 		);
			}
		}

		//Response Data		
		$this->response($data, 200);			
	}

	//GET BRANCH NEW CUSTOMER
	function branch_new_get() {		
		$filters 	= $this->get("filter")["filters"];		
		$page 		= $this->get('page') !== false ? $this->get('page') : 1;		
		$limit 		= $this->get('limit') !== false ? $this->get('limit') : 100;								
		$sort 	 	= $this->get("sort");		
		$data["results"] = array();
		$data["count"] = 0;

		$obj = new Contact(null, $this->_database);		

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

		//Only customer
		$obj->include_related("contact_type", "name");
		$obj->where_related("contact_type", "parent_id", 1);		

		//Results
		$obj->get_paged_iterated($page, $limit);
		$data["count"] = $obj->paged->total_rows;

		if($obj->exists()){
			foreach ($obj as $value) {
				$fullname = $value->surname.' '.$value->name;
				if($value->contact_type_id=="6" || $value->contact_type_id=="7" || $value->contact_type_id=="8"){
					$fullname = $value->company;
				}
				
				//Electricity Deposit
				$edeposit = new Payment(null, $this->_database);
				$edeposit->where("contact_id", $value->id);
				$edeposit->select_sum("amount");
				$edeposit->where("type", "edeposit");
				$edeposit->get();

				//Water Deposit
				$wdeposit = new Payment(null, $this->_database);
				$wdeposit->where("contact_id", $value->id);
				$wdeposit->select_sum("amount");
				$wdeposit->where("type", "wdeposit");
				$wdeposit->get();

		 		$data["results"][] = array(
		 			"id" 					=> $value->id,
		 			"number" 				=> $value->number,
		 			"enumber" 				=> $value->enumber,
		 			"wnumber" 				=> $value->wnumber,
					"fullname" 				=> $fullname,
					"registered_date" 		=> $value->registered_date,					
					"contact_type_name"		=> $value->contact_type_name,					
					"ebranch_name" 			=> $value->ebranch->get()->name,
					"wbranch_name" 			=> $value->wbranch->get()->name,
					"elocation_name" 		=> $value->elocation->get()->name,
					"wlocation_name" 		=> $value->wlocation->get()->name,					
					"edeposit" 				=> floatval($edeposit->amount),
					"wdeposit" 				=> floatval($wdeposit->amount),
					"meters"				=> $value->meter->get_raw()->result()										
		 		);
			}
		}

		//Response Data		
		$this->response($data, 200);			
	}			
}

/* End of file contacts.php */
/* Location: ./application/controllers/api/contacts.php */