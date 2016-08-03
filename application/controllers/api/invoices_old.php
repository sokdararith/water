<?php defined('BASEPATH') OR exit('No direct script access allowed');


require APPPATH.'/libraries/REST_Controller.php';

class Invoices extends REST_Controller {
	
	//CONSTRUCTOR
	function __construct() {
		parent::__construct();		
		$this->load->model('accounting/invoice_model', 'invoice');
		$this->load->model('accounting/invoice_item_model', 'invoice_item');
		$this->load->model('accounting/payment_model', 'payment');

		$this->load->model("people/people_model", "people");
		$this->load->model('people/people_type_model', 'people_type');

		$this->load->model('inventory/meter_model', 'meter');
		$this->load->model('inventory/meter_record_model', 'meter_record');
		$this->load->model('inventory/average_record_model', 'average_record');

		$this->load->model('transformer_m', 'transformer');
		$this->load->model('company_m', 'company');
		$this->load->model('inventory/electricity_box_model', 'electricity_box');

		$this->load->model('inventory/item_model', 'item');
		$this->load->model('inventory/item_record_model', 'item_record');			
	}

				
	//GET 
	function invoice_get() {
		$filters = $this->get("filter")["filters"];
		$logic = $this->get("filter")["logic"];
		$limit = $this->get("pageSize");
		$offset = $this->get('skip');
		$sorter = $this->get("sort");
		$data["results"] = array();
		$data["total"] = 0;

		//Limit
		if(!empty($limit) && isset($limit)){
			$this->invoice->limit($limit, $offset);
		}			
		
		//Sort
		if(!empty($sorter) && isset($sorter)){			
			$sort = array();
			foreach ($sorter as $row) {
				$sort += array($row["field"] => $row["dir"]);
			}			
			$this->invoice->order_by($sort);
		}

		if(!empty($filters) && isset($filters)){
			$filter = array();			
			foreach ($filters as $row) {				
				if(!empty($row["operator"]) && isset($row["operator"])){
					if($row["operator"]==="wherein"){
						$this->invoice->where_in($row["field"], $row["value"]);
					}					
				}else{				
					$filter += array($row["field"] => $row["value"]);
				}
			}

			$data["results"] = $this->invoice->get_many_by($filter);
			$data["total"] = $this->invoice->count_by($filter);					
		}		
		$this->response($data, 200);			
	}
	
	//POST
	function invoice_post() {
		$models = json_decode($this->post("models"));		
		
		if(!empty($models) && isset($models)){			
			foreach ($models as $key => $value) {				
				$id = $this->invoice->insert($value);
				$data["results"][] = $this->invoice->get($id);
			}			
		}else{
			$post = array(
				"number" 			=> $this->_get_number($this->post("type")),
				"type" 				=> $this->post("type"),
				"amount" 			=> $this->post("amount"),
				"rate" 				=> $this->post("rate"),
				"sub_code" 			=> $this->post("sub_code"),
				"vat" 				=> $this->post("vat"),			
				"vat_id"			=> $this->post("vat_id"),
				"status" 			=> $this->post("status"),
				"issued_date" 		=> date("Y-m-d", strtotime($this->post("issued_date"))),			
				"due_date" 			=> date("Y-m-d", strtotime($this->post("due_date"))),
				"payment_date" 		=> date("Y-m-d", strtotime($this->post("payment_date"))),
				"expected_date" 	=> date("Y-m-d", strtotime($this->post("expected_date"))),
				"month_of" 			=> date("Y-m-d", strtotime($this->post("month_of"))),
				"date_read_from" 	=> date("Y-m-d", strtotime($this->post("date_read_from"))),
				"date_read_to" 		=> date("Y-m-d", strtotime($this->post("date_read_to"))),
				"box_no" 			=> $this->post("box_no"),
				"address" 			=> $this->post("address"),
				"ship_to" 			=> $this->post("ship_to"),
				"customer_id" 		=> $this->post("customer_id"),
				"vendor_id" 		=> $this->post("vendor_id"),
				"biller" 			=> $this->post("biller"),
				"cashier" 			=> $this->post("cashier"),
				"reference_id" 		=> $this->post("reference_id"),
				"reference_type" 	=> $this->post("reference_type"),			
				"payment_method_id"	=> $this->post("payment_method_id"),
				"payment_term_id" 	=> $this->post("payment_term_id"),
				"cash_account_id" 	=> $this->post("cash_account_id"),
				"check_no" 			=> $this->post("check_no"),			
				"paid" 				=> $this->post("paid"),
				"fine" 				=> $this->post("fine"),
				"discount" 			=> $this->post("discount"),				
				"memo" 				=> $this->post("memo"),
				"memo2" 			=> $this->post("memo2"),
				"class_id" 			=> $this->post("class_id"),
				"transformer_id" 	=> $this->post("transformer_id"),
				"company_id" 		=> $this->post("company_id")					
			);
			$id = $this->invoice->insert($post);		
			$data["results"] = $this->invoice->get($id);
		}

		$this->response($data, 201);			
	}
	
	//PUT
	function invoice_put(){		
		$models = json_decode($this->put("models"));		

		if(!empty($models) && isset($models)){
			$ids = array();
			foreach ($models as $value) {
				$ids[] = $value->id;
				$data["status"] = $this->invoice->update($value->id, $value);
			}
			$data["results"] = $this->invoice->get_many($ids);
		}else{
			$put = array(
				"number" 			=> $this->put("number"),
				"type" 				=> $this->put("type"),
				"amount" 			=> $this->put("amount"),
				"rate" 				=> $this->put("rate"),
				"sub_code" 			=> $this->put("sub_code"),
				"vat" 				=> $this->put("vat"),			
				"vat_id"			=> $this->put("vat_id"),
				"status" 			=> $this->put("status"),
				"issued_date" 		=> date("Y-m-d", strtotime($this->put("issued_date"))),			
				"due_date" 			=> date("Y-m-d", strtotime($this->put("due_date"))),
				"payment_date" 		=> date("Y-m-d", strtotime($this->put("payment_date"))),
				"expected_date" 	=> date("Y-m-d", strtotime($this->put("expected_date"))),
				"month_of" 			=> date("Y-m-d", strtotime($this->put("month_of"))),
				"date_read_from" 	=> date("Y-m-d", strtotime($this->put("date_read_from"))),
				"date_read_to" 		=> date("Y-m-d", strtotime($this->put("date_read_to"))),
				"box_no" 			=> $this->put("box_no"),
				"address" 			=> $this->put("address"),
				"ship_to" 			=> $this->put("ship_to"),
				"customer_id" 		=> $this->put("customer_id"),
				"vendor_id" 		=> $this->put("vendor_id"),
				"biller" 			=> $this->put("biller"),
				"cashier" 			=> $this->put("cashier"),
				"reference_id" 		=> $this->put("reference_id"),
				"reference_type" 	=> $this->put("reference_type"),			
				"payment_method_id"	=> $this->put("payment_method_id"),
				"payment_term_id" 	=> $this->put("payment_term_id"),
				"cash_account_id" 	=> $this->put("cash_account_id"),
				"check_no" 			=> $this->put("check_no"),			
				"paid" 				=> $this->put("paid"),
				"fine" 				=> $this->put("fine"),
				"discount" 			=> $this->put("discount"),				
				"memo" 				=> $this->put("memo"),
				"memo2" 			=> $this->put("memo2"),
				"class_id" 			=> $this->put("class_id"),
				"transformer_id" 	=> $this->put("transformer_id"),
				"company_id" 		=> $this->put("company_id")					
			);
		
			$data["status"] = $this->invoice->update($this->put('id'), $put);		
			$data["results"] = $this->invoice->get($this->put('id'));
		}
		
		$this->response($data, 200);
	}
	
	//DELETE
	function invoice_delete(){				
		$data["results"] = $this->invoice->get($this->delete("id"));		
		$data["status"] = $this->invoice->delete($this->delete("id"));
		
		$this->response($data, 200);
	}

	//Generate Invoice's Number
	Private function _get_number($type){
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
		default:
		  	$header = "INV";
		}
		
		$YY = date("y");
		$MM = date("m");
		$headerWithDate = $header . $YY . $MM;

		$inv = $this->invoice->order_by('id', 'desc')->get_by('type', $type);
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

	//POST BATCH	
	function invoice_batch_post() {
		$post = json_decode($this->post('models'));

		$YY = date("y");
		$MM = date("m");
		$headerWithDate = "EINV" . $YY . $MM;

		$inv = $this->invoice->order_by("id", "desc")->get_by("type", "eInvoice");
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
		
		foreach ($post as $key => $value) {
			$value->number = $headerWithDate . str_pad($no, 5, "0", STR_PAD_LEFT);
			$arr[] = $value;

			$no++;
		}

		$ids = $this->invoice->insert_many($arr);
		$data["results"] = $this->invoice->get_many($ids);
		$data["total"] = count($ids);

		$this->response($data, 201);			
	}

	//POST MANY
	function invoice_many_post(){
		$post = json_decode($this->post("models"));	  	
	  	$result = $this->invoice->insert_many($post);
	  	
		$this->response($result, 200);		
	}

	//UPDATE BATCH
	function invoice_batch_put(){
		$invoiceList = json_decode($this->put("models"));
		$ids = array();
	  	foreach ($invoiceList as $row) {
	  		$ids[] = $row->id;
	  		$data["status"] = $this->invoice->update($row->id, array("status"=>$row->status, 	  														
	  														"paid"=>$row->paid,
	  														"fine"=>$row->fine,
	  														"discount"=>$row->discount, 
	  														"paid_date"=>date("Y-m-d", strtotime($row->paid_date))
	  													));	  				 				  	
	  	}
		$data["results"] = $this->invoice->get_many($ids);
		$data["total"] = count($ids);

		$this->response($data, 200);	
	}

	//INACTIVE INVOICE
	function invoice_inactive_put(){
		$id = $this->put("id");
	  	
	  	$result = $this->invoice->update($id, array('status'=>2));
		$this->response($result, 200);		
	}

	//CHANGE TO STATUS 3 (NOTICE INACTIVE)
	function status5_put(){
		$ids = json_decode($this->put("ids"));
	  	foreach ($ids as $key => $value) {
	  		$data[] = $value;	  				 				  	
	  	}
	  	$result = $this->invoice->update_many($data, array('status'=>5));
		$this->response($result, 200);		
	}

	//GET NEXT INVOICE ID 
	function invoice_next_id_get(){
		$type = $this->get('type');
		$id = $this->invoice->get_next_id();
		$last_no = $this->invoice->last_number($type);

		$this->response(array('id'=>$id, 'last_no'=>$last_no), 200);				
	}

	//GET INVOICE FOR CUSTOMER 
	function invoice_for_customer_get(){
		$invoice_id = $this->get('invoice_id');
		if(!empty($invoice_id) && isset($invoice_id)){
			$data = $this->invoice->get_invoice_for_customer($invoice_id)->get_all();
			$this->response($data, 200);
		}else{
			$empty_data = Array();
		  	$this->response($empty_data, 200);
		}		
	}

	//GET TOTAL DEBT AND TOTAL PAYMENT
	function total_debt_payment_get(){
		$customer_id = $this->get("customer_id");
		$invoice_id = $this->get("invoice_id");
		$issued_date = $this->get("issued_date");
		if(!empty($customer_id) && isset($customer_id) && !empty($invoice_id) && isset($invoice_id)){
			$tdebt		= $this->invoice_item->get_total_amount_by($customer_id, $issued_date);
			$tpayment 	= $this->payment->get_total_payment_by_customer_id($customer_id, 0, $issued_date);					
			$tamt 		= $this->invoice_item->get_total_amount($invoice_id);

			$tremain	= $tdebt - $tpayment;
			$tdue 		= $tremain + $tamt;

			$data[] = array(
					"tdebt" 	=> $tdebt,
					"tpayment" 	=> $tpayment,					
					"tamt" 		=> $tamt,
					"tremain"	=> $tremain,
					"tdue"		=> $tdue								
			);			
			$this->response($data, 200);
		}else{
			$empty_data = Array();
		  	$this->response($empty_data, 200);
		}		
	}

	//GET INVOICE FOR PAYMENT
	function invoice_payment_get() {
		$filter = $this->get("filter");		
		if(!empty($filter) && isset($filter)){
			$para = array();				
			for ($i = 0; $i < count($filter['filters']); ++$i) {				
				$para += array($filter['filters'][$i]['field'] => $filter['filters'][$i]['value']);
			}			
			$arr = $this->invoice->where_in('type', array('Invoice', 'eInvoice', 'Notice'))
								->where_in('status', array(0,2))
								->get_many_by($para);							
			if(count($arr) >0){
				foreach($arr as $row) {
					$totalAmount = $row->amount;										   
				   	$totalPaid	 = $this->payment->get_total_payment($row->id);
				   	$total  	 = $totalAmount - $totalPaid;

					$extra = array(	'total_paid' 		=> $totalPaid,   
								   	'total' 			=> $total,
								   	'people'			=> $this->people->get($row->customer_id)								   								   	
							  	);

					//Cast object to array
					$original = (array) $row;

					//Merge arrays
					$data[] = array_merge($original, $extra);	
				}
				$this->response($data, 200);		
			}else{
		  		$this->response(Array(), 200);
			}
		}else{
			$data = $this->invoice->get_all();
			$this->response($data, 200);
		}		
	}

	/* --- STATEMENT --- */	
	function statement_get(){
		$filter = $this->get("filter");
		$para = array();				
		for ($i = 0; $i < count($filter['filters']); ++$i) {				
			$para += array($filter['filters'][$i]['field'] => $filter['filters'][$i]['value']);
		}				
		$customer_id = $para["customer_id"];
		$start_date = $para["start_date"];
		$end_date = $para["end_date"];				
		
		$statement = array();
		$typeList = array("Invoice", "eInvoice", "Notice");
		
		//Balance forward
		$bfList = $this->invoice->where_in("type", $typeList)
								->where_in("status", array(0,2))
								->get_many_by(array("customer_id"=>$customer_id,
													"issued_date <="=>$start_date));
		if(count($bfList)>0){
			$bfInv = 0;
			$bfInvIds = array();									
			foreach ($bfList as $row) {
				$bfInv += $row->amount;
				
				if(intval($row->status)===2){
					array_push($bfInvIds, $row->id);
				}				
			}
			
			$bfPaid = 0;
			if(count($bfInvIds)>0){
				$bfPaidList = $this->payment->where_in("invoice_id", $bfInvIds)->get_all();							
				foreach ($bfPaidList as $row) {
					$bfPaid += $row->amount_paid;
				}				
			}						

			$balanceForward = $bfInv - $bfPaid;
			
			$statement[] = array(
				'id' 			=> 0,
			   	'issued_date'	=> $start_date,
			   	'description' 	=> 'សមតុល្យពីមុន',						   
			   	'amount' 		=> $balanceForward,			   	
			   	'balance'     	=> $balanceForward,
			   	'rate' 			=> $row->rate,
				'sub_code'		=> $row->sub_code	 				  
		  	);			
		}				
						
	  	//Add invoice list to statement[]		
	  	$invList = $this->invoice->where_in("type", $typeList)	  							
			  					->get_many_by(array("customer_id"=>$customer_id,
			  										"status <"=>3,			  												  										
			  										"issued_date >="=>$start_date, 
			  										"issued_date <="=>$end_date));		  		  
												   
	  	if(count($invList)>0){
	  		$invIds = array();	  			
			foreach($invList as $row) {
				array_push($invIds, $row->id);

				$statement[] = array(
					'id' 			=> $row->id,
				   	'issued_date'	=> $row->issued_date,
				   	'description' 	=> $row->number,						   
				   	'amount' 		=> $row->amount,
				   	'balance'		=> 0,
				   	'rate' 			=> $row->rate,
					'sub_code'		=> $row->sub_code	 				  
				);			  
			}

			$paidList = $this->payment->where_in("invoice_id", $invIds)->get_all();
			if(count($paidList)>0){
				foreach($paidList as $row) {
					$statement[] = array(
						'id' 			=> 0,
					   	'issued_date'	=> $row->payment_date,
					   	'description' 	=> "បង់ប្រាក់",						   
					   	'amount' 		=> $row->amount_paid*-1,
					   	'balance'		=> 0,
					   	'rate' 			=> $row->rate,
						'sub_code'		=> $row->sub_code	 				  
					);
				}
			}
	  	}	
	  	
	  	if(count($statement)>0){
	  		//Sort array by date
			function sortFunction($a, $b) {			
				return strtotime($a["issued_date"]) - strtotime($b["issued_date"]);
			}
			usort($statement, "sortFunction");

			//Calculate balance
			$balance = 0;					
			foreach ($statement as $key => $value) {
				$balance += $statement[$key]["amount"];				
				$statement[$key]["balance"] = $balance; 
			}				
	  	}	  				  
	  		  
		$this->response($statement, 200);
	}	
	
	/* --- STATEMENT COLLECTION --- */	
	function statement_collection_get(){
		$filter = $this->get("filter");
		$limit 	= $this->get('pageSize');
		$offset = $this->get('skip');
		
		$company_id = 0;
		$customer_id = 0;
		$start_date = "";
		$end_date = "";				
		for ($i = 0; $i < count($filter['filters']); ++$i) {
			if($filter['filters'][$i]['field']==="company_id"){
				$company_id = $filter['filters'][$i]['value'];
			}
			if($filter['filters'][$i]['field']==="customer_id"){
				$customer_id = $filter['filters'][$i]['value'];
			}
			if($filter['filters'][$i]['field']==="start_date"){
				$start_date = $filter['filters'][$i]['value'];
			}
			if($filter['filters'][$i]['field']==="end_date"){
				$end_date = $filter['filters'][$i]['value'];
			}
		}
						
		$statement = array();
		$balance = 0;

		if(!empty($limit) && isset($limit)){
	 		$this->invoice->limit($limit, $offset);
	 	}

	  	//Add invoice list to statement[]
	 	if($customer_id>0){
	 		if($start_date!=="" && $end_date!==""){
		  		$invList = $this->invoice->get_many_by(array("customer_id"=>$customer_id, 
		  												"status <"=>4,
		  												"issued_date >="=>$start_date, 
				  										"issued_date <="=>$end_date));
			}else{
				$invList = $this->invoice->get_many_by(array("customer_id"=>$customer_id, 
		  													"status <"=>4));
			}
	 	}else{
	 		if($start_date!=="" && $end_date!==""){
		  		$invList = $this->invoice->get_many_by(array("company_id"=>$company_id, 
		  												"status <"=>4,
		  												"issued_date >="=>$start_date, 
				  										"issued_date <="=>$end_date));
			}else{
				$invList = $this->invoice->get_many_by(array("company_id"=>$company_id, 
		  													"status <"=>4));
			}	 		
	 	}	  			  			  		
	  														   
	  	if(count($invList)>0){		
			foreach($invList as $row) {
				$typeName = '';
				
				switch ($row->type){
				case 'eInvoice':
				  	$typeName = 'វិក្កយបត្រអគ្គីសនី';				  	
				  	break;									
				case 'Receipt':
				  	$typeName = 'បង្កាន់ដៃលក់ជាសាច់ប្រាក់';					  	
				  	break;
				case 'Estimate':
				  	$typeName = 'សម្រង់តម្លៃ';				  	
				  	break;
				case 'GDN':
				  	$typeName = 'លិខិតដឹកជញ្ជូន';				  	
				  	break;
				case 'SO':
				  	$typeName = 'បញ្ជាលក់';				  	
				  	break;		
				case 'Notice':
				  	$typeName = 'លិខិតរំលឹក';				  	
				  	break;
				default:
				  	$typeName = 'វិក្កយបត្រ';				  	
				}

				$statement[] = array(
					'id'			=> $row->id,
					'type'			=> $row->type,
				    'typeName'		=> $typeName,
					'number' 		=> $row->number,						   
					'issued_date' 	=> $row->issued_date,
					'due_date' 		=> $row->due_date,
					'amount'     	=> $row->amount,
					'rate' 			=> $row->rate,
					'sub_code'		=> $row->sub_code,
					'status'		=> $row->status
				);			  
			} 
	  	}
	  
	  	//Add payment list to statement[]		  	
	  	$paymentList = $this->payment->get_many_by(array("customer_id"=>$customer_id,	  												
	  												"payment_date >="=>$start_date, 
			  										"payment_date <="=>$end_date));
	  	if(count($paymentList)>0){
		  	foreach($paymentList as $row) {				  								
			  	$statement[] = array(
			  	   'id'				=> $row->id,
			  	   'type'			=> "Payment",
				   'typeName'		=> "បង់ប្រាក់",
				   'number' 		=> $row->check_no,						   
				   'issued_date' 	=> $row->payment_date,
				   'due_date' 		=> "",
				   'amount'     	=> $row->amount_paid,
				   'rate' 			=> $row->rate,
				   'sub_code'		=> $row->sub_code,
				   'status' 		=> -1	 				  
			  	);	
		  	} 			
	  	}	  			  
	  				  
	  	//Sort array
	  // 	if(count($statement)>0){				
			// function sortFunction($a, $b){			
			// 	return strtotime($a["issued_date"]) - strtotime($b["issued_date"]);
			// }
			// usort($statement, "sortFunction");			
	  // 	}
	  
	  	if(count($statement)){
	  		$this->response($statement, 200);
	  	}else{	  		
	  		$this->response(Array(), 200);
	  	}		
	}
	
	/* --- AGING --- */	
	function aging_get(){
		$filter = $this->get("filter");	
		$para = array();				
		for ($i = 0; $i < count($filter['filters']); ++$i) {				
			$para += array($filter['filters'][$i]['field'] => $filter['filters'][$i]['value']);
		}				
		$customer_id = $para["customer_id"];
		$start_date = $para["start_date"];
		$end_date = $para["end_date"];	
		
	  	$aging[] = array(
	  		'current'	=> 0,
			'within30' 	=> 0,
			'within60' 	=> 0,
			'within90' 	=> 0,
			'over90'   	=> 0
		);

		$typeList = array("Invoice", "eInvoice", "Notice");
	  				  			
		$invList = $this->invoice->where_in("type", $typeList)
								->where_in("status", array(0,2))
								->get_many_by(array("customer_id"=>$customer_id,													
													"issued_date >="=>$start_date,
													"issued_date <="=>$end_date));												 
		if(count($invList)>0){			  		
		  	//Current date		  			  	
		  	$today = new DateTime();

		  	foreach($invList as $row) {			  
				//Compare dates
				$due_date = new DateTime($row->due_date);
				$day = 0;					
				if($due_date < $today){		  
				  	$dDiff = $due_date->diff($today);				  	
				  	$day = $dDiff->days;
				}
				
				//Calculate total amount
				$pay = 0;	
				if(intval($row->status)===2){
					$pay = $this->payment->get_total_payment($row->id);
				}			  	
			  	$total = floatval($row->amount) - $pay;									
						
				//Add total to aging[]
				if($day < 1){						
					$aging[0]['current'] += $total;
				}else if(($day > 0) && ($day <= 30)){						
					$aging[0]['within30'] += $total;
				}else if(($day > 30) && ($day <= 60)){						
					$aging[0]['within60'] += $total;
				}else if(($day > 60) && ($day <= 90)){						
					$aging[0]['within90'] += $total;
				}else{						
					$aging[0]['over90'] += $total;
				}
			}		  			  			  
		}		  	  
			
		$this->response($aging, 200);				
	}

	/* --- AGING BATCH --- */	
	function aging_batch_get(){
		$filter = $this->get("filter");	
		$para = array();				
		for ($i = 0; $i < count($filter['filters']); ++$i) {				
			$para += array($filter['filters'][$i]['field'] => $filter['filters'][$i]['value']);
		}		
		
		$issued_date = $para["issued_date"];
		$typeList = array("Invoice", "eInvoice", "Notice");
		
		$limit 	= $this->get('pageSize');
		$offset = $this->get('skip');

		$cusPara = array();
		if(!empty($para["transformer_id"]) && isset($para["transformer_id"])){
			$cusPara = array("transformer_id"=>$para["transformer_id"]); 
		}else{
			if(!empty($para["company_id"]) && isset($para["company_id"])){
				$cusPara = array("company_id"=>$para["company_id"]);
			}
		}
						
		$data = array();
		$data["people"] = Array();		
		$today = new DateTime();
		
		$cusList = $this->people->type(1)->limit($limit, $offset)->get_many_by($cusPara);
		if(count($cusList)>0){
			foreach ($cusList as $cus) {			
				$invList = $this->invoice->where_in('type', $typeList)
										->where_in('status', array(0,2))
										->get_many_by(array('customer_id'=>$cus->id,															
															'issued_date <='=>$issued_date
													));
				if(count($invList)>0){
					$current = 0;
					$within30 = 0;
					$within60 = 0;
					$within90 = 0;
					$over90 = 0;
					$t=0;

			  		foreach($invList as $row) {			  
						//Compare dates
						$due_date = new DateTime($row->due_date);
						$day = 0;					
						if($due_date < $today){		  
						  	$dDiff = $due_date->diff($today);				  	
						  	$day = $dDiff->days;
						}
												
						//Calculate total amount
						$pay = 0;	
						if(intval($row->status)===2){
							$pay = $this->payment->get_total_payment($row->id);
						}			  	
					  	$total = floatval($row->amount) - $pay;
						$t += $total;
								
						//Add total to age[]
						if($day < 1){						
							$current += $total;
						}else if(($day > 0) && ($day <= 30)){						
							$within30 += $total;
						}else if(($day > 30) && ($day <= 60)){						
							$within60 += $total;
						}else if(($day > 60) && ($day <= 90)){						
							$within90 += $total;
						}else{						
							$over90 += $total;
						}						
					}

					if($t>0){
						$fullname = $cus->number.' '.$cus->surname.' '.$cus->name;
						if($cus->people_type_id==5 || $cus->people_type_id==6 || $cus->people_type_id==7){
							$fullname = $cus->number.' '.$cus->company;
						}
						$data["people"][] = array(													
					  		'fullname'  	=> $fullname,
					  		'current'		=> $current,
							'within30' 		=> $within30,
							'within60' 		=> $within60,
							'within90' 		=> $within90,
							'over90'   		=> $over90
						);
					}					  			  			  
				}
			}			
		}
		
		$data["total"] = $this->people->type(1)->count_by($cusPara);
		$this->response($data, 200);				
	}

	/* --- AGING DETAIL --- */	
	function aging_detail_get(){
		$filter = $this->get("filter");	
		$para = array();				
		for ($i = 0; $i < count($filter['filters']); ++$i) {				
			$para += array($filter['filters'][$i]['field'] => $filter['filters'][$i]['value']);
		}				
		
		$issued_date = $para["issued_date"];
		$typeList = array("Invoice", "eInvoice", "Notice");		
		
		$limit 	= $this->get('pageSize');
		$offset = $this->get('skip');

		$cusPara = array();
		if(!empty($para["transformer_id"]) && isset($para["transformer_id"])){
			$cusPara = array("transformer_id"=>$para["transformer_id"]); 
		}else{
			if(!empty($para["company_id"]) && isset($para["company_id"])){
				$cusPara = array("company_id"=>$para["company_id"]);
			}
		}
						
		$data = array();
		$data["people"] = Array();		
				
		$cusList = $this->people->type(1)->limit($limit, $offset)->get_many_by($cusPara);
		if(count($cusList)>0){
			foreach ($cusList as $row) {			
				$invList = $this->invoice->where_in('type', $typeList)
										->where_in('status', array(0,2))
										->get_many_by(array('customer_id'=>$row->id,															
															'issued_date <='=>$issued_date
													));
				if(count($invList)>0){
					$extra = array(	'invoices' => $invList
								);

					//Cast object to array
					$original = (array) $row;

					//Merge arrays
					$data["people"][] = array_merge($original, $extra);			  			  			  
				}
			}			
		}
		
		$data["total"] = $this->people->type(1)->count_by($cusPara);
		$this->response($data, 200);				
	}

	/* --- DISCONNECT LIST --- */
	function disconnect_list_get() {
		$filters = $this->get("filter")["filters"];		
		$data["results"] = array();
		$data["total"] = 0;

		$strQuery = "
				SELECT invoices.id, invoices.number AS invoiceNumber, invoices.amount, invoices.rate, invoices.sub_code, invoices.due_date,				
				meters.meter_no,
				electricity_boxes.box_no,
				people.number, people.surname, people.name, people.company, people.people_type_id,
				transformers.transformer_number,
				electricity_units.name AS ampereName
				FROM invoices
				INNER JOIN people ON people.id = invoices.customer_id				
				INNER JOIN meters ON meters.id = people.id
				INNER JOIN electricity_boxes ON electricity_boxes.id = meters.electricity_box_id				
				INNER JOIN transformers ON transformers.id = people.transformer_id
				INNER JOIN electricity_units ON electricity_units.id = people.ampere_id 
				WHERE invoices.status IN (0,2) 
				AND invoices.company_id = " . $filters[0]["value"] . "
				AND invoices.type = '" . $filters[1]["value"] . "'";				
		
		$query = $this->db->query($strQuery);

		$over_due_day = $filters[2]["value"];

		//Modify field
		foreach($query->result() as $key => $value) {			

			$today = new DateTime();
			$due_date = new DateTime($value->due_date);												  
		  	$dDiff = $due_date->diff($today);				  	
		  	$day = $dDiff->days;

		  	if($day>=$over_due_day){
		  		$fullname = $value->number .' '. $value->surname .' '. $value->name;
				if($value->people_type_id==="5" || $value->people_type_id==="6" || $value->people_type_id==="7"){
					$fullname = $value->number .' '. $value->company;
				}

				$data["results"][] = array(
					"id" 				=> $value->id,
					"number" 			=> $value->invoiceNumber,				
					"area" 				=> $value->transformer_number, 
					"fullname" 			=> $fullname,								
					"ampere" 			=> $value->ampereName,
					"box_no"			=> $value->box_no,
					"meter_no"			=> $value->meter_no,								
					"amount" 			=> floatval($value->amount),					
					"rate" 				=> floatval($value->rate),
					"sub_code" 			=> $value->sub_code,
					"due_date" 			=> $value->due_date,
					"over_due_day"		=> $day				
			   	);
		   	}				
		}			
		$data["total"] = $query->num_rows();			

		$this->response($data, 200);			
	}	

	//Electricity sale
	function electricity_sale_get(){
		$filter = $this->get("filter");			
		$para = array();				
		for ($i = 0; $i < count($filter['filters']); ++$i) {				
			$para += array($filter['filters'][$i]['field'] => $filter['filters'][$i]['value']);
		}

		$start_date = $para["start_date"];
		$end_date = $para["end_date"];
		$company_id = $para["company_id"];
				
		$transformerList = array();
		if($company_id>0){
			$transformerList = $this->transformer->get_many_by('company_id',$company_id);
		}		
		
		$data = array();
		if(count($transformerList)>0){
			foreach ($transformerList as $row){
				$transformer = "";			
				$activeCustomer = 0;
				$inactiveCustomer = 0;
				$total_consumption = 0;
				$minimum_usage = 0;
				$total_amount = 0;				
				$total_debt = 0;
				$total_discount = 0;
				$total_fine = 0;
				$total_paid = 0;

				$transformer = $row->transformer_number;
				$activeCustomer = $this->people->count_by(array('status'=>1, 'transformer_id'=>$row->id));
				$inactiveCustomer = $this->people->count_by(array('status !='=>1, 'transformer_id'=>$row->id));
				
				//Meter record
				$readingList = $this->meter_record->join_meter()											
											->get_many_by(array('meter_records.month_of >='=>$start_date,
																'meter_records.month_of <='=>$end_date,
																'meters.transformer_id'=>$row->id
															));
				if(count($readingList)>0){
					foreach ($readingList as $r){
						$usage = intval($r->new_reading) + intval($r->new_round) - intval($r->prev_reading);
						
						$total_consumption += $usage;

						if($minimum_usage==0){
							$minimum_usage = $usage;
						}else if($usage<$minimum_usage){
							$minimum_usage = $usage;
						}
					}
				}

				//Invoice item				
				$invoiceItemList = $this->invoice_item->join_people_invoice()																										
													->get_many_by(array('invoices.issued_date >='=>$start_date,
																		'invoices.issued_date <='=>$end_date,
																		'invoices.type'=>'eInvoice',																																	
																		'people.transformer_id'=>$row->id
																));				
				if(count($invoiceItemList)>0){
					foreach ($invoiceItemList as $item){
						$total_amount += $item->amount;						
					}
				}	
				
				//Debt
				$debtList = $this->invoice->join_people()													
											->get_many_by(array('invoices.issued_date <'=>$start_date,													
													'invoices.type'=>'eInvoice',
													'invoices.status'=>0,															
													'people.transformer_id'=>$row->id
												));
				if(count($debtList)>0){
					$debt = 0;
					$paid = 0;
					foreach ($debtList as $d){
						$debtAmt = $this->invoice_item->sum('amount')->get_many_by('invoice_id',$d->id);
						$paidAmt = $this->payment->sum('amount_paid')->get_many_by(array('invoice_id'=>$d->id, 
																						'payment_date <'=>$start_date
																				));
						$debt += floatval($debtAmt[0]->amount);
						$paid += floatval($paidAmt[0]->amount_paid);
					}
					$total_debt = $debt - $paid;
				}

				//Payment
				$paymentList = $this->payment->join_people_invoice()													
											->get_many_by(array('payments.payment_date >='=>$start_date,
													'payments.payment_date <='=>$end_date,
													'invoices.type'=>'eInvoice',																												
													'people.transformer_id'=>$row->id
												));
				if(count($paymentList)>0){
					foreach ($paymentList as $p){
						$total_discount += $p->discount;
						$total_fine += $p->fine;
						$total_paid += $p->amount_paid;
					}
				}
				
				$total = ($total_amount + $total_debt + $total_fine) - ($total_discount + $total_paid);

				$data[] = array(
					'transformer' 		=> $transformer,				
					'activeCustomer' 	=> $activeCustomer,
					'inactiveCustomer' 	=> $inactiveCustomer,
					'total_consumption' => $total_consumption,
					'minimum_usage' 	=> $minimum_usage,
					'total_amount' 		=> $total_amount,					
					'total_debt' 		=> $total_debt,
					'total_discount' 	=> $total_discount,
					'total_fine' 		=> $total_fine,
					'total_paid' 		=> $total_paid,
					'total' 			=> $total					
				);				
			}
		}
		$this->response($data, 200);
	}

	//MONTHLY SALE
	function monthly_sale_get(){
		$filter = $this->get("filter");			
		$para = array();				
		for ($i = 0; $i < count($filter['filters']); ++$i) {				
			$para += array($filter['filters'][$i]['field'] => $filter['filters'][$i]['value']);
		}		
		$typeList = array("Receipt", "Invoice", "eInvoice", "Notice");

		$data = $this->invoice->where_in("type", $typeList)->order_by("issued_date", "asc")->get_many_by($para);		
		
		$this->response($data, 200);		
	}

	//OUTSTANDING INVOICE
	function outstanding_invoice_get(){
		$filter = $this->get("filter");			
		$para = array();				
		for ($i = 0; $i < count($filter['filters']); ++$i) {				
			$para += array($filter['filters'][$i]['field'] => $filter['filters'][$i]['value']);
		}		
		$typeList = array("Invoice", "eInvoice", "Notice", "Estimate", "SO");

		$data = $this->invoice->where_in("type", $typeList)
							->where_in("status", array(0,2))
							->get_many_by($para);		
		
		$this->response($data, 200);		
	}

	//CUSTOMER DASHBOARD
	function customer_dashboard_get(){
		$company_id = $this->get("company_id");			
		
		$active_customer = $this->people->count_by(array('status'=>1, 'company_id'=>$company_id));
		$unpaid_customer = $this->invoice->join_people()
										->where_in('invoices.type', array('Invoice', 'eInvoice'))
										->count_distinct()										
										->get_many_by(array('invoices.status'=>0, 'people.company_id'=>$company_id));
		
		$total_debt = $this->invoice_item->join_people_invoice()
									->where_in('invoices.type', array('Invoice', 'eInvoice'))
									->sum('invoice_items.amount')													
									->get_many_by(array('invoices.status'=>0, 'people.company_id'=>$company_id));
			
		$data = array(
			'active_customer' 	=> $active_customer,
			'unpaid_customer' 	=> intval($unpaid_customer[0]->counter),
			'total_debt' => floatval($total_debt[0]->amount)																																				
		);
			
						
		$this->response($data, 200);
	}

	//INVOICE INFO
	function invoice_info_get(){
		$filter = $this->get("filter");		
		if(!empty($filter) && isset($filter)){			
			$para = array();				
			for ($i = 0; $i < count($filter['filters']); ++$i) {				
				$para += array($filter['filters'][$i]['field'] => $filter['filters'][$i]['value']);
			}			
			$arr = $this->invoice->get_by($para);

			//Add extra fields
			$extra = array('total_amount'	=> $this->invoice_item->get_total_amount($arr->id),
							'customers'		=> $this->people->get($arr->customer_id)						   	
					  );

			//Cast object to array
			$original = (array) $arr;

			//Merge arrays
			$data[] = array_merge($original, $extra);
			$this->response($data, 200);
		}
	}

	//PRINT BATCH
	function print_batch_get(){
		$filter = $this->get("filter");			
		$para = array();				
		for ($i = 0; $i < count($filter['filters']); ++$i) {				
			$para += array($filter['filters'][$i]['field'] => $filter['filters'][$i]['value']);
		}
		$typeList = array("Invoice", "eInvoice", "Notice");			
		$arr = $this->invoice->where_in('type', $typeList)
							->get_many_by($para);

		$data = Array();
		if(count($arr) >0){
			foreach($arr as $row) {
				$amt = $row->amount;										   
			   	$paid = $this->payment->get_total_payment($row->id);
			   	$total = $amt - $paid;

			   	$prevInv = $this->invoice->where_in('type', $typeList)
			   							->where_in('status', array(0,2))
		   								->get_many_by(array("customer_id"=>$row->customer_id, 
		   													"issued_date <"=>$row->issued_date,
		   													"status"=>0,
		   												));
			   	$tdebt = 0;
			   	$tpayment = 0;							
				if(count($prevInv)>0){
					foreach ($prevInv as $inv) {						
						$tdebt += $inv->amount;
						$tpayment += $this->payment->get_total_payment($inv->id);
					}
				}

				$tremain	= $tdebt - $tpayment;
				$tdue 		= $tremain + $amt;
				
			   	//Add extra fields
				$extra = array('amount'			=> $amt,
							   	'paid' 			=> $paid,   
							   	'total' 		=> $total,							   	
							   	'tdebt' 		=> $tdebt,
								'tpayment' 		=> $tpayment,								
								'tremain'		=> $tremain,
								'tdue'			=> $tdue,
								'invoice_items' => $this->invoice_item->join_select_meter($row->id),
								'companys'		=> $this->company->get($row->company_id),
								'transformers'	=> $this->transformer->get($row->transformer_id),
								'customers'		=> $this->people->get($row->customer_id)								
						  );

				//Cast object to array
				$original = (array) $row;

				//Merge arrays
				$data[] = array_merge($original, $extra);											
			}									
		}			
		$this->response($data, 200);				
	}

	//LAST ID NUMBER
	function last_idNumber_get(){
		$type = $this->get("type");	
		$id = $this->invoice->get_next_id();
		$no = $this->invoice->last_number($type);
		$this->response(array("next_id"=>$id, "last_no"=>$no), 200);
	}

	//LAST NUMBER
	function last_number_get(){		
		$type = $this->get("type");		
		$no = $this->invoice->last_number($type);
		$this->response($no, 200);
	}

	//Salse Order Fulfillment
	function so_fulfillment_get(){
		$filter = $this->get("filter");	
		$para = array();				
		for ($i = 0; $i < count($filter['filters']); ++$i) {				
			$para += array($filter['filters'][$i]['field'] => $filter['filters'][$i]['value']);
		}			
		$arr = $this->invoice->get_many_by($para);		
		$data = Array();
		if(count($arr) >0){
			foreach($arr as $row){
				//SO qty
				$soQty = $this->invoice_item->sum("quantity")->get_many_by("invoice_id",$row->id);
				$sqty = 0;
				if(count($soQty)>0){
					$sqty = $soQty[0]->quantity;
				}

				//GDN from SO
				$gdn = $this->invoice->get_by(array("type"=>"GDN","so_id"=>$row->id));
				
				//Invoice qty
				$invQty = $this->invoice_item->join_invoice()->sum("invoice_items.quantity")->get_many_by(array("type"=>"Invoice", "invoice_items.so_id"=>$row->id));
				$iqty = 0;
				if(count($invQty)>0){
					$iqty = $invQty[0]->quantity;
				}

				$remain = intval($sqty) - intval($iqty);				

			   	//Add extra fields
				$extra = array('qty'		=> intval($sqty),
							   	'remain' 	=> intval($remain),							   	
							   	'gdn'		=> $gdn,							   							   	
							   	'people'    => $this->people->get($row->customer_id)
						  );

				//Cast object to array
				$original = (array) $row;

				//Merge arrays
				$data[] = array_merge($original, $extra);	
			}
			$this->response($data, 200);						
		}else{
			$this->response(array(), 200);
		}		
	}

	//Order List
	function order_list_get(){
		$filter = $this->get("filter");	
		$para = array();				
		for ($i = 0; $i < count($filter['filters']); ++$i) {				
			$para += array($filter['filters'][$i]['field'] => $filter['filters'][$i]['value']);
		}			
		$arr = $this->invoice->get_many_by($para);		
		if(count($arr) >0){			
			foreach($arr as $row){
				$invItem = $this->invoice_item->get_many_by("invoice_id", $row->id);

				foreach ($invItem as $v) {
					$data[] = array(
							"item_id" 	=> $v->item_id,
							"item" 		=> $this->item->get($v->item_id),
							"qty"		=> $v->quantity
					);	
				}							
			}
			$this->response($data, 200);						
		}else{
			$this->response(array(), 200);
		}		
	}

	//PAYMEN SUMMARY
	function payment_summary_get() {
		$filters = $this->get("filter")["filters"];			
		$data["results"] = array();
		$groupBy = "";			

		$strQuery = "
				SELECT SUM(invoices.paid) AS paidAmount, COUNT(invoices.id) AS counter,
				companies.name,				
				people_types.name AS peopleType,				
				transformers.transformer_number
				FROM invoices
				INNER JOIN companies ON companies.id = invoices.company_id
				INNER JOIN people ON people.id = invoices.customer_id
				INNER JOIN people_types ON people_types.id = people.people_type_id				
				INNER JOIN transformers ON transformers.id = people.transformer_id
				WHERE invoices.type IN ('Payment','Receipt') ";

		if(count($filters)>0){		
			foreach ($filters as $row) {				
				if($row["field"]==="start_date"){
					$strQuery .= " AND invoices.issued_date >= '" . $row["value"] ."'";		
				}

				if($row["field"]==="end_date"){
					$strQuery .= " AND invoices.issued_date <= '" . $row["value"] ."'";		
				}

				if($row["field"]==="cashier"){
					$strQuery .= " AND invoices.cashier = " . $row["value"];		
				}

				if($row["field"]==="group_by"){
					$groupBy = $row["value"];					
					$strQuery .= " GROUP BY " . $row["value"];		
				}				
			}			
		}	
		
		$query = $this->db->query($strQuery);

		foreach ($query->result() as $key => $value) {
			$description = $value->transformer_number;
			if($groupBy==="people.people_type_id"){
				$description  = $value->peopleType;
			}
			$data["results"][] = array(								
				"company" 			=> $value->name,											
				"description"		=> $description,
				"counter" 			=> $value->counter,
				"paid" 				=> floatval($value->paidAmount)
		   	);
		}
		$data["total"] = count($data["results"]);

		$this->response($data, 200);			
	}

	//PAYMEN DETAIL
	function payment_detail_get() {
		$filters = $this->get("filter")["filters"];			
		$data["results"] = array();			

		$strQuery = "
				SELECT invoices.*,
				people.id AS people_id, people.number AS peopleNumber, people.surname, people.name, people.company, people.people_type_id,
				people_types.name AS peopleType,
				payment_methods.name AS paymentMethod,
				transformers.transformer_number
				FROM invoices
				INNER JOIN people ON people.id = invoices.customer_id
				INNER JOIN people_types ON people_types.id = people.people_type_id
				INNER JOIN payment_methods ON payment_methods.id = invoices.payment_method_id
				INNER JOIN transformers ON transformers.id = people.transformer_id
				WHERE invoices.type IN ('Payment','Receipt') ";

		if(count($filters)>0){		
			foreach ($filters as $row) {				
				if($row["field"]==="start_date"){
					$strQuery .= " AND invoices.issued_date >= '" . $row["value"] ."'";		
				}

				if($row["field"]==="end_date"){
					$strQuery .= " AND invoices.issued_date <= '" . $row["value"] ."'";		
				}

				if($row["field"]==="cashier"){
					$strQuery .= " AND invoices.cashier = " . $row["value"];		
				}
			}			
		}	
		
		$strQuery .= " ORDER BY invoices.issued_date, people.transformer_id";

		$query = $this->db->query($strQuery);

		foreach ($query->result() as $key => $value) {
			$fullname = $value->peopleNumber .' '. $value->surname .' '. $value->name;
			if($value->people_type_id==="5" || $value->people_type_id==="6" || $value->people_type_id==="7"){
				$fullname = $value->peopleNumber .' '. $value->company;
			}			

			$data["results"][] = array(
				"id" 				=> $value->id, 
				"fullname" 			=> $fullname,
				"people_type" 		=> $value->peopleType,
				"issued_date" 		=> $value->issued_date,
				"number" 			=> $value->number,				
				"payment_method" 	=> $value->paymentMethod,				
				"paid" 				=> floatval($value->paid),
				"rate" 				=> floatval($value->rate),
				"sub_code" 			=> $value->sub_code,
				"transformer_number"=> $value->transformer_number
		   	);
		}
		$data["total"] = count($data["results"]);

		$this->response($data, 200);			
	}

	//UTILITY SALE SUMMARY
	function utility_sale_summary_get() {
		$filters = $this->get("filter")["filters"];		
		$data["results"] = array();
		$data["total"] = 0;

		$strQuery = "
				SELECT transformers.id, transformers.transformer_number,
				companies.name, companies.sub_code
				FROM transformers
				INNER JOIN companies ON companies.id = transformers.company_id				
				WHERE transformers.type = " . $filters[0]["value"] . "
				AND companies.parent_id = " . $filters[1]["value"];
		
		$query = $this->db->query($strQuery);

		//Modify field
		foreach($query->result() as $key => $value) {
			$strQuery1 = "
				SELECT SUM(invoices.amount) AS amt,
				SUM(invoice_items.quantity) AS qty
				FROM invoices
				INNER JOIN invoice_items ON invoice_items.invoice_id = invoices.id				
				WHERE invoices.transformer_id = " . $value->id . "				 
				AND invoices.month_of = '" . $filters[2]["value"] . "'";

			$query1 = $this->db->query($strQuery1);

			$data["results"][] = array(
				"id" 				=> $value->id,				
				"area" 				=> $value->transformer_number, 
				"company" 			=> $value->name,				
				"quantity"			=> intval($query1->result()[0]->qty),				
				"amount" 			=> floatval($query1->result()[0]->amt),				
				"sub_code" 			=> $value->sub_code				
		   	);				
		}			
		$data["total"] = $query->num_rows();			

		$this->response($data, 200);			
	}

	//UTILITY SALE DETAIL
	function utility_sale_detail_get() {
		$filters = $this->get("filter")["filters"];		
		$data["results"] = array();
		$data["total"] = 0;

		$strQuery = "
				SELECT invoices.id, invoices.amount, invoices.rate, invoices.sub_code,
				invoice_items.prev_reading, invoice_items.new_reading, invoice_items.quantity,
				meters.meter_no,
				electricity_boxes.box_no,
				people.number, people.surname, people.name, people.company, people.people_type_id,
				transformers.transformer_number,
				electricity_units.name AS ampereName
				FROM invoices
				INNER JOIN invoice_items ON invoice_items.invoice_id = invoices.id
				INNER JOIN meters ON meters.id = invoice_items.id
				INNER JOIN electricity_boxes ON electricity_boxes.id = meters.electricity_box_id
				INNER JOIN people ON people.id = invoices.customer_id
				INNER JOIN transformers ON transformers.id = people.transformer_id
				INNER JOIN electricity_units ON electricity_units.id = people.ampere_id 
				WHERE invoice_items.meter_id > 0
				AND invoices.company_id = " . $filters[0]["value"] . "
				AND invoices.type = '" . $filters[1]["value"] . "' " . " 
				AND invoices.month_of = '" . $filters[2]["value"] . "'";
		
		$query = $this->db->query($strQuery);

		//Modify field
		foreach($query->result() as $key => $value) {
			$fullname = $value->number .' '. $value->surname .' '. $value->name;
			if($value->people_type_id==="5" || $value->people_type_id==="6" || $value->people_type_id==="7"){
				$fullname = $value->number .' '. $value->company;
			}

			$data["results"][] = array(
				"id" 				=> $value->id,				
				"area" 				=> $value->transformer_number, 
				"fullname" 			=> $fullname,								
				"ampere" 			=> $value->ampereName,
				"box_no"			=> $value->box_no,
				"meter_no"			=> $value->meter_no,
				"prev_reading" 		=> intval($value->prev_reading),
				"new_reading" 		=> intval($value->new_reading),
				"quantity"			=> intval($value->quantity),				
				"amount" 			=> floatval($value->amount),					
				"rate" 				=> floatval($value->rate),
				"sub_code" 			=> $value->sub_code				
		   	);				
		}			
		$data["total"] = $query->num_rows();					
			

		$this->response($data, 200);			
	}
	
	//GET PAYMENT FOR CASHIER 
	function payment_for_cashier_get() {
		$cashier = $this->get("cashier");
		
		$strQuery = "
				SELECT COUNT(DISTINCT customer_id) AS counter
				FROM invoices
				WHERE type = 'Payment' AND issued_date = CURDATE() AND cashier = ". $cashier;
		$query = $this->db->query($strQuery);

		$counter = 0;
		if($query->num_rows()>0){
			$counter = $query->result()[0]->counter;
		}

		$strQuery1 = "
				SELECT SUM(amount) AS amount
				FROM invoices
				WHERE type = 'Payment' AND issued_date = CURDATE() AND cashier = ". $cashier;
		$query1 = $this->db->query($strQuery1);

		$payment = 0;
		if($query1->num_rows()>0){
			$payment = $query1->result()[0]->amount;
		}

		$data = array('total_customer'	=> $counter,					
					'total_payment' 	=> $payment									 
		);

		$this->response($data, 200);
	}


	//HEANG
	//sale_detail
	function sale_detail_get() {
		$filters = $this->get("filter")["filters"];		
		$data["results"] = array();
		$typeList = array("Invoice", "eInvoice", "wInvoice", "Receipt", "Notice");				

		$strQuery = "
				SELECT invoices.*,
				people.id AS people_id, people.number AS peopleNumber, people.surname, people.name, people.company, people.people_type_id,				
				transformers.transformer_number,
				people_types.name AS peopleType
				FROM invoices
				INNER JOIN people ON people.id = invoices.customer_id
				INNER JOIN people_types ON people_types.id = people.people_type_id
				INNER JOIN transformers ON transformers.id = invoices.transformer_id				
				WHERE invoices.type IN ('eInvoice','Invoice','Notice','Receipt')";
		
		
		if(count($filters)>0){		
			foreach ($filters as $row) {				
				if($row["field"]==="start_date"){
					$strQuery .= " AND invoices.issued_date >= '" . $row["value"] ."'";		
				}

				if($row["field"]==="end_date"){
					$strQuery .= " AND invoices.issued_date <= '" . $row["value"] ."'";		
				}

				if($row["field"]==="company_id"){
					$strQuery .= " AND invoices.company_id = " . $row["value"];		
				}
			}			
		}

		$strQuery .= " ORDER BY invoices.issued_date, people.transformer_id";

		$query = $this->db->query($strQuery);

		foreach ($query->result() as $key => $value) {
			$fullname = $value->peopleNumber .' '. $value->surname .' '. $value->name;
			if($value->people_type_id==="5" || $value->people_type_id==="6" || $value->people_type_id==="7"){
				$fullname = $value->peopleNumber .' '. $value->company;
			}			

			$data["results"][] = array(
				"id"				=> $value->id,				
				"fullname" 			=> $fullname,
				"people_type" 		=> $value->peopleType,
				"issued_date" 		=> $value->issued_date,
				"number" 			=> $value->number,
				"type" 				=> $value->type,				
				"rate" 				=> $value->rate,
				"sub_code" 			=> $value->sub_code,
				"amount"			=> $value->amount,
				"transformer_number"=> $value->transformer_number
		   	);
		}
		
		$data["total"] = count($data["results"]);

		$this->response($data, 200);			
	}

	function deposit_detail_get() {
		$filters = $this->get("filter")["filters"];		
		$data["results"] = array();					

		$strQuery = "
				SELECT invoice_items.*,
				people.id AS people_id, people.number AS peopleNumber, people.surname, people.name, people.company, people.people_type_id,				
				transformers.transformer_number,
				people_types.name AS peopleType,
 				invoices.number, invoices.issued_date
				FROM invoice_items
				INNER JOIN invoices ON invoices.id = invoice_items.invoice_id
				INNER JOIN people ON people.id = invoices.customer_id
				INNER JOIN people_types ON people_types.id = people.people_type_id
				INNER JOIN transformers ON transformers.id = people.transformer_id				
				INNER JOIN items ON items.id = invoice_items.item_id
				INNER JOIN item_types ON item_types.id = items.item_type_id
				WHERE invoices.type = 'Receipt' AND item_types.id = 5 				
				";		
		
		if(count($filters)>0){		
			foreach ($filters as $row) {				
				if($row["field"]==="start_date"){
					$strQuery .= " AND invoices.issued_date >= '" . $row["value"] ."'";		
				}

				if($row["field"]==="end_date"){
					$strQuery .= " AND invoices.issued_date <= '" . $row["value"] ."'";		
				}

				if($row["field"]==="company_id"){
					$strQuery .= " AND invoices.company_id = " . $row["value"];		
				}
			}			
		}

		$strQuery .= " ORDER BY invoices.issued_date";

		$query = $this->db->query($strQuery);

		foreach ($query->result() as $key => $value) {
			$fullname = $value->peopleNumber .' '. $value->surname .' '. $value->name;
			if($value->people_type_id==="5" || $value->people_type_id==="6" || $value->people_type_id==="7"){
				$fullname = $value->peopleNumber .' '. $value->company;
			}			

			$data["results"][] = array(
				"id"				=> $value->id,				
				"fullname" 			=> $fullname,
				"people_type" 		=> $value->peopleType,
				"issued_date" 		=> $value->issued_date,
				"number" 			=> $value->number,							
				"rate" 				=> $value->rate,
				"sub_code" 			=> $value->sub_code,
				"amount"			=> $value->amount,
				"transformer_number"=> $value->transformer_number
		   	);
		}
		
		$data["total"] = count($data["results"]);

		$this->response($data, 200);			
	}
	
}//End Of Class