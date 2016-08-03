<?php defined('BASEPATH') OR exit('No direct script access allowed');


require APPPATH.'/libraries/REST_Controller.php';

class Accounting_api extends REST_Controller {
	
	//CONSTRUCTOR
	function __construct() {
		parent::__construct();		
		$this->load->model('accounting/account_model', 'account');
		$this->load->model('accounting/account_type_model', 'account_type');
		$this->load->model('accounting/class_model', 'classes');
		$this->load->model('accounting/journal_model', 'journal');
		$this->load->model('accounting/invoice_model', 'invoice');
		$this->load->model('accounting/invoice_item_model', 'invoice_item');
		$this->load->model('accounting/receipt_model', 'receipt');
		$this->load->model('accounting/receipt_item_model', 'receipt_item');
		$this->load->model('accounting/estimate_model', 'estimate');
		$this->load->model('accounting/estimate_item_model', 'estimate_item');
		$this->load->model('accounting/purchase_order_model', 'purchase_order');
		$this->load->model('accounting/purchase_order_item_model', 'purchase_order_item');
		$this->load->model('accounting/payment_model', 'payment');
		$this->load->model('accounting/payment_term_model', 'payment_term');
		$this->load->model('accounting/payment_method_model', 'payment_method');
		$this->load->model('accounting/currency_model', 'currency');
		$this->load->model('inventories/item_model', 'items');		
	}
	
	
		
	/* --- ACCOUNT --- */
	
	//GET 
	function account_get() {
		//$data = $this->account->get_all();
		$data = $this->account->get_account_with_type();		
		$this->response($data, 200);		
	}	
		
	//POST
	function account_post() {		
		$arr = array('code' 			=> $this->post('code'),
					 'name' 			=> $this->post('name'),
					 'account_type_id' 	=> $this->post('account_type_id'),
					 'description' 		=> $this->post('description'),
					 'parent_id'		=> $this->post('parent_id')
		);	
		$this->account->insert($arr);								
	}
	
	//PUT
	function account_put() {
		$arr = array('code' 			=> $this->put('code'),
					 'name' 			=> $this->put('name'),
					 'account_type_id' 	=> $this->put('account_type_id'),
					 'description' 		=> $this->put('description'),
					 'parent_id' 		=> $this->put('parent_id')
		);
 		$this->account->update($this->put('id'), $arr);		
	}
	
	//DELETE
	function account_delete() {
		//$this->response(array("status"=>$this->delete('id')), 200);
		$this->account->delete($this->delete('id'));
	}
		
		
		
	/* --- ACCOUNT TYPE --- */
	
	//GET 
	function account_type_get() {		
		$data = $this->account_type->get_many_by('parent_id >', 0);		
		$this->response($data, 200);		
	}
	
	//POST
	function account_type_post() {			
		$this->account_type->insert($this->post());
		//$this->response($this->post(), 200);		
	}
	
	//PUT
	function account_type_put() {
 		 $this->account_type->update($this->put('id'), $this->put());
		 //$this->response($this->post(), 200);
	}
	
	//DELETE
	function account_type_delete() {
		//$this->response(array("status"=>$this->delete('id')), 200);
		$this->account_type->delete($this->delete('id'));
	}
	
	
	
	/* --- CLASSES --- */
	
	//GET 
	function classes_get() {		
		$data = $this->classes->get_many_by('type', 'Class');		
		$this->response($data, 200);		
	}
	
	//POST
	function classes_post() {			
		$this->classes->insert($this->post());
		//$this->response($this->post(), 200);		
	}
	
	//PUT
	function classes_put() {
 		 $this->classes->update($this->put('id'), $this->put());
	}
	
	//DELETE
	function classes_delete() {
		//$this->response(array("status"=>$this->delete('id')), 200);
		$this->classes->delete($this->delete('id'));
	}
	
	
	
	/* --- JOURNAL --- */
	
	//GET 
	function journal_get() {
		$data = $this->journal->get_all();		
		$this->response($data, 200);
	}
	
	//POST
	function journal_post() {				
		$acc_id = $this->post('account_id');
		$dr = $this->post('dr');
		$cr = $this->post('cr');
		
		$arr = array('account_id' 			=> $acc_id,
					   'dr' 				=> $dr,
					   'cr' 				=> $cr,						 
					   'balance'			=> $this->journal->calculate_account_balance($acc_id, $dr, $cr),
					   'memo'				=> $this->post('memo'),
					   'class_id'			=> $this->post('class_id'),						 				 
					   'transaction_type'	=> $this->post('transaction_type'),		
					   'people_id'			=> $this->post('people_id'),
					   'invoice_id'			=> $this->post('invoice_id'),
					   'receipt_id'			=> $this->post('receipt_id')						 
		);				
		$this->journal->insert($arr);
		$this->response($arr, 200);		  							
					
		//$this->response($this->post(), 200);		
	}
	
	//PUT
	function journal_put() {
 		 $this->journal->update($this->put('id'), $this->put());
	}
	
	//DELETE
	function journal_delete() {
		//$this->response(array("status"=>$this->delete('id')), 200);
		$this->journal->delete($this->delete('id'));
	}
	
		
	
	/* --- INVOICE --- */
	
	//GET 
	function invoice_get() {
		$customer_id = $this->get('customer_id');
		if($customer_id > 0) {
			$data = $this->invoice->get_many_by(array('customer_id'=>$customer_id, 'status'=>0));
			if(count($data) > 0){				
			  foreach($data as $row) {
				  $total_paid = $this->payment->get_total_payment($row->id);
				  $arr[] = array(
				  		   'id'					=> $row->id,
						   'invoice_no' 		=> $row->invoice_no,						   
						   'billing_date' 		=> $row->billing_date,						   
						   
						   //Extra					  
						   'total' 				=> $this->invoice_item->get_total_amount($row->id),										   
						   'total_paid'			=> $total_paid ? $total_paid : 0,
						   'amount_paid' 		=> 0						  
				  );
			  }
			  $this->response($arr, 200);
			}
		} else {
			$data = $this->invoice->get_all();
			$this->response($data, 200);
		}					
	}
	
	//POST
	function invoice_post() {		  
		$id = $this->invoice->insert($this->post());		 
		$this->response($id, 200);			
	}
	
	//PUT
	function invoice_put() {		
 		$this->invoice->update($this->put());
		$this->response($arr, 200);
	}
	
	//DELETE
	function invoice_delete() {
		//$this->response(array("status"=>$this->delete('id')), 200);
		$this->invoice->delete($this->delete('id'));
	}
	
	
	
	/* --- INVOICE ITEM --- */
	
	//GET 
	function invoice_item_get() {		
		$data = $this->invoice_item->get_all();
		
		foreach($data as $row) {
			$arr[] = array(
					"invoice_id" 	=> $row->invoice_id,
					"item_id" 		=> $row->item_id,
					"description" 	=> $row->description,
					"quantity" 		=> $row->quantity,
					"unit_price" 	=> $row->unit_price,
					"vat" 			=> $row->vat,
					"amount" 		=> $row->amount,
					"item_name" 	=> $this->items->get_by("id",$item->item_id)
			);
		}
						
		$this->response($arr, 200);
	}
	
	//POST
	function invoice_item_post() {
		$arr = array('invoice_id' 	=> $this->post('invoice_id'),
					 'item_id' 		=> $this->post('item_id'),
					 'description' 	=> $this->post('description'),
					 'quantity' 	=> $this->post('quantity'),
					 'unit_price' 	=> $this->post('unit_price'),
					 'vat' 			=> $this->post('vat'),
					 'amount' 		=> $this->post('amount')
		);
		$this->invoice_item->insert($arr);
		
		//Update item qty
		$item = $this->post('item_name');
		$qty = $this->post('quantity');
		$qty_onhand = $item['quantity'];
		$total_qty = $qty_onhand - $qty;
		$this->items->update($this->post('item_id'), array('quantity'=>$total_qty) ); 								
		
		//$this->response($this->item(), 200);		
	}
	
	//PUT
	function invoice_item_put() {
		$arr = array('invoice_id' 	=> $this->put('invoice_id'),
					 'item_id' 		=> $this->put('item_id'),
					 'description' 	=> $this->put('description'),
					 'quantity' 	=> $this->put('quantity'),
					 'unit_price' 	=> $this->put('unit_price'),
					 'vat' 			=> $this->put('vat'),
					 'amount' 		=> $this->put('amount')
		);	
 		$this->invoice_item->update($this->put('id'), $arr);
	}
	
	//DELETE
	function invoice_item_delete() {
		//$this->response(array("status"=>$this->delete('id')), 200);
		$this->invoice_item->delete($this->delete('id'));
	}
	
	
	
	/* --- RECEIPT --- */
	
	//GET 
	function receipt_get() {		
		$data = $this->receipt->get_all();
		$this->response($data, 200);							
	}
	
	//POST
	function receipt_post() {			  
		$id = $this->receipt->insert($this->post());		 
		$this->response($id, 200);			
	}
	
	//PUT
	function receipt_put() {		
 		$this->receipt->update($this->put());
		$this->response($arr, 200);
	}
	
	//DELETE
	function receipt_delete() {
		//$this->response(array("status"=>$this->delete('id')), 200);
		$this->receipt->delete($this->delete('id'));
	}
	
	
	
	/* --- RECEIPT ITEM --- */
	
	//GET 
	function receipt_item_get() {		
		$data = $this->invoice_item->get_all();
		
		foreach($data as $row) {
			$arr[] = array(
					"receipt_id" 	=> $row->receipt_id,
					"item_id" 		=> $row->item_id,
					"description" 	=> $row->description,
					"quantity" 		=> $row->quantity,
					"unit_price" 	=> $row->unit_price,
					"vat" 			=> $row->vat,
					"amount" 		=> $row->amount,
					"item_name" 	=> $this->items->get_by("id",$item->item_id)
			);
		}
						
		$this->response($arr, 200);
	}
	
	//POST
	function receipt_item_post() {
		$arr = array('receipt_id' 	=> $this->post('receipt_id'),
					 'item_id' 		=> $this->post('item_id'),
					 'description' 	=> $this->post('description'),
					 'quantity' 	=> $this->post('quantity'),
					 'unit_price' 	=> $this->post('unit_price'),
					 'vat' 			=> $this->post('vat'),
					 'amount' 		=> $this->post('amount')
		);
		$this->receipt_item->insert($arr);
		
		//Update item qty
		$item = $this->post('item_name');
		$qty = $this->post('quantity');
		$qty_onhand = $item['quantity'];
		$total_qty = $qty_onhand - $qty;
		$this->items->update($this->post('item_id'), array('quantity'=>$total_qty) ); 								
		
		//$this->response($this->item(), 200);		
	}
	
	//PUT
	function receipt_item_put() {
		$arr = array('receipt_id' 	=> $this->put('receipt_id'),
					 'item_id' 		=> $this->put('item_id'),
					 'description' 	=> $this->put('description'),
					 'quantity' 	=> $this->put('quantity'),
					 'unit_price' 	=> $this->put('unit_price'),
					 'vat' 			=> $this->put('vat'),
					 'amount' 		=> $this->put('amount')
		);	
 		$this->receipt_item->update($this->put('id'), $arr);
	}
	
	//DELETE
	function receipt_item_delete() {
		//$this->response(array("status"=>$this->delete('id')), 200);
		$this->receipt_item->delete($this->delete('id'));
	}
	
	
	
	/* --- PAYMENT --- */
	
	//GET 
	function payment_get() {		
		$data = $this->payment->get_all();		
		$this->response($data, 200);					
	}
	
	//POST
	function payment_post() {
		//Update invoice's status
		$status = $this->post('status');
		if(!empty($status) && isset($status)){
		  if($status == 1){
			  $invoice_id = $this->post('invoice_id');			  		
			  $this->invoice->update($invoice_id, array('status'=>1)); 
		  }
		}		
		
		//Insert new invoice payment
		$arr = array('invoice_id' 			=> $this->post('invoice_id'),
					 'receipt_id' 			=> $this->post('receipt_id'),
					 'amount_paid' 			=> $this->post('amount_paid'),
					 'payment_date' 		=> $this->post('payment_date'),
					 'payment_method_id'	=> $this->post('payment_method_id'),
					 'check_no' 			=> $this->post('check_no'),
					 'deposit_to' 			=> $this->post('deposit_to'),
					 'payment_note' 		=> $this->post('payment_note'),
					 'cashier' 				=> $this->post('cashier'),
					 'customer_id' 			=> $this->post('customer_id'),
					 'company_id' 			=> $this->post('company_id')
		);		
		$this->payment->insert($arr);		
		//$this->response($this->post(), 200);			
	}
	
	//PUT
	function payment_put() {			
 		$this->payment->update($this->put('id'), $this->put());
	}
	
	//DELETE
	function payment_delete() {
		//$this->response(array("status"=>$this->delete('id')), 200);
		$this->payment->delete($this->delete('id'));
	}
	
	
	
	/* --- ESTIMATE --- */
	
	//GET 
	function estimate_get() {		
		$data = $this->estimate->get_all();
		$this->response($data, 200);						
	}
	
	//POST
	function estimate_post() {		  
		$id = $this->estimate->insert($this->post());		 
		$this->response($id, 200);			
	}
	
	//PUT
	function estimate_put() {		
 		$this->estimate->update($this->put());
		$this->response($arr, 200);
	}
	
	//DELETE
	function estimate_delete() {
		//$this->response(array("status"=>$this->delete('id')), 200);
		$this->estimate->delete($this->delete('id'));
	}
	
	
	
	/* --- ESTIMATE ITEM --- */
	
	//GET 
	function estimate_item_get() {		
		$data = $this->estimate_item->get_all();
		
		foreach($data as $row) {
			$arr[] = array(
					"estimate_id" 	=> $row->estimate_id,
					"item_id" 		=> $row->item_id,
					"description" 	=> $row->description,
					"quantity" 		=> $row->quantity,
					"unit_price" 	=> $row->unit_price,
					"vat" 			=> $row->vat,
					"amount" 		=> $row->amount,
					"item_name" 	=> $this->items->get_by("id",$item->item_id)
			);
		}
						
		$this->response($arr, 200);
	}
	
	//POST
	function estimate_item_post() {
		$arr = array('estimate_id' 	=> $this->post('estimate_id'),
					 'item_id' 		=> $this->post('item_id'),
					 'description' 	=> $this->post('description'),
					 'quantity' 	=> $this->post('quantity'),
					 'unit_price' 	=> $this->post('unit_price'),
					 'vat' 			=> $this->post('vat'),
					 'amount' 		=> $this->post('amount')
		);
		$this->estimate_item->insert($arr);							
		
		//$this->response($this->item(), 200);		
	}
	
	//PUT
	function estimate_item_put() {
		$arr = array('estimate_id' 	=> $this->put('estimate_id'),
					 'item_id' 		=> $this->put('item_id'),
					 'description' 	=> $this->put('description'),
					 'quantity' 	=> $this->put('quantity'),
					 'unit_price' 	=> $this->put('unit_price'),
					 'vat' 			=> $this->put('vat'),
					 'amount' 		=> $this->put('amount')
		);	
 		$this->estimate_item->update($this->put('id'), $arr);
	}
	
	//DELETE
	function estimate_item_delete() {
		//$this->response(array("status"=>$this->delete('id')), 200);
		$this->estimate_item->delete($this->delete('id'));
	}
	
	
	
	/* --- PURCHASE ORDER --- */
	
	//GET 
	function purchase_order_get() {		
		$data = $this->purchase_order->get_all();
		$this->response($data, 200);						
	}
	
	//POST
	function purchase_order_post() {		  
		$id = $this->purchase_order->insert($this->post());		 
		$this->response($id, 200);			
	}
	
	//PUT
	function purchase_order_put() {		
 		$this->purchase_order->update($this->put());
		$this->response($arr, 200);
	}
	
	//DELETE
	function purchase_order_delete() {
		//$this->response(array("status"=>$this->delete('id')), 200);
		$this->purchase_order->delete($this->delete('id'));
	}
	
	
	
	/* --- PURCHASAE ORDER ITEM --- */
	
	//GET 
	function purchase_order_item_get() {		
		$data = $this->purchase_order_item->get_all();
		
		foreach($data as $row) {
			$arr[] = array(
					"purchase_order_id"	=> $row->purchase_order_id,
					"item_id" 			=> $row->item_id,
					"description" 		=> $row->description,
					"quantity" 			=> $row->quantity,
					"unit_price" 		=> $row->unit_price,
					"vat" 				=> $row->vat,
					"amount" 			=> $row->amount,
					"item_name" 		=> $this->items->get_by("id",$item->item_id)
			);
		}
						
		$this->response($arr, 200);
	}
	
	//POST
	function purchase_order_item_post() {
		$arr = array('purchase_order_id'=> $this->post('purchase_order_id'),
					 'item_id' 			=> $this->post('item_id'),
					 'description' 		=> $this->post('description'),
					 'quantity' 		=> $this->post('quantity'),
					 'unit_price' 		=> $this->post('unit_price'),
					 'vat' 				=> $this->post('vat'),
					 'amount' 			=> $this->post('amount')
		);
		$this->purchase_order_item->insert($arr);
		//$this->response($this->item(), 200);		
	}
	
	//PUT
	function purchase_order_item_put() {
		$arr = array('purchase_order_id'=> $this->put('purchase_order_id'),
					 'item_id' 			=> $this->put('item_id'),
					 'description' 		=> $this->put('description'),
					 'quantity' 		=> $this->put('quantity'),
					 'unit_price' 		=> $this->put('unit_price'),
					 'vat' 				=> $this->put('vat'),
					 'amount' 			=> $this->put('amount')
		);	
 		$this->purchase_order_item->update($this->put('id'), $arr);
	}
	
	//DELETE
	function purchase_order_item_delete() {
		//$this->response(array("status"=>$this->delete('id')), 200);
		$this->purchase_order_item->delete($this->delete('id'));
	}
		
	
	/* --- STATEMENT --- */	
	
	function statement_get(){		
		$customer_id = $this->get('customer_id');
		$start_date = $this->get('start_date');
		$end_date = $this->get('end_date');
		$balance = 0;
		
		if(!empty($customer_id) && isset($customer_id) && !empty($start_date) && isset($start_date) && !empty($end_date) && isset($end_date) ){	
		
		  //Add invoice list to statement[]		
		  $invList = $this->invoice->get_many_by(array('customer_id'=>$customer_id,
		  											   'billing_date >='=>$start_date, 
		  											   'billing_date <='=>$end_date));		  		  
													   
		  if(!empty($invList) && isset($invList)){		
			foreach($invList as $i) {  				
				$statement[] = array(
				   'date_at'		=> $i->billing_date,
				   'description' 	=> 'INV#'. $i->invoice_no,						   
				   'amount' 		=> $this->invoice_item->get_total_amount($i->id),
				   'balance'		=> 0	 				  
				);			  
			} 
		  }
		  
		  //Add payment list to statement[]
		  $paymentList = $this->payment->get_many_by(array('customer_id'=>$customer_id,
		  												   'invoice_id >'=>0, 
														   'payment_date >='=>$start_date,
														   'payment_date <='=>$end_date));
		  if(!empty($paymentList) && isset($paymentList)){
			  foreach($paymentList as $j) {
				  $paid = $j->amount_paid;								
				  $statement[] = array(
					   'date_at'		=> $j->payment_date,
					   'description' 	=> 'PMT',						   
					   'amount' 		=> $paid * -1,
					   'balance'     	=> 0	 				  
				  );	
			  } 			
		  }
		  				  
		  //Loop through statement[]
		  if(!empty($statement) && isset($statement)){
															
			//Sort array by date
			function sortFunction( $a, $b ) {			
				return strtotime($a["date_at"]) - strtotime($b["date_at"]);
			}
			usort($statement, "sortFunction");
			
			//Get balance forward
			$total_amount = $this->invoice_item->get_total_amount_by($customer_id, $start_date);
			$total_payment = $this->payment->get_total_payment_by($customer_id, $start_date);
			$balance_forward = ($total_amount - $total_payment);
									
			//Calculate balance	
			$count = 0;
			foreach($statement as $k) {	
				//Add balance forward to state[]
				if(($count == 0) && ($balance_forward > 0)){
				  $state[] = array(			  		
					   'date_at'		=> $start_date,
					   'description' 	=> "Balance Forward",						   
					   'amount' 		=> "",
					   'balance'     	=> $balance_forward	 				  
				  );
				  $balance = $balance_forward;	
				}
				$count = 1;
				
				$balance += $k['amount'];  				
				$state[] = array(			  		
					 'date_at'		=> $k['date_at'],
					 'description' 	=> $k['description'],						   
					 'amount' 		=> $k['amount'],
					 'balance'     	=> $balance	 				  
				);	
			} 
		  }
		  
		  $this->response($state, 200);
		  
		} /*End if*/
	}
	
	
	
	/* --- AGING --- */
	
	function aging_get(){
		$customer_id = $this->get('customer_id');
		$start_date = $this->get('start_date');
		$end_date = $this->get('end_date');	
		
		if(!empty($customer_id) && isset($customer_id) && !empty($start_date) && isset($start_date) && !empty($end_date) && isset($end_date) ){			
		  	$age[] = array(
				'within30' => 0,
				'within60' => 0,
				'within90' => 0,
				'over90'   => 0
			);
		  		
			//$over_date = $start_date + 30;		  			
			$invList = $this->invoice->get_many_by(array('customer_id'=>$customer_id, 
														 'billing_date >='=>$start_date,
														 'billing_date <='=>$end_date));		  		  
													 
			if(!empty($invList) && isset($invList)){			  		
			  // current date
			  $today = date_create();
			  
			  foreach($invList as $j) {
				  $status = $j->status;
				  if($status == 0){
					//Compare dates
					$due_date = date_create($j->due_date);					
					if($due_date < $today){		  
					  $interval = $due_date->diff($today);
					  $days = $interval->format('%R%a');					  
					}else{
					  $days = 0;
					}
					
					//Calculate total amount	
					$amt = $this->invoice_item->get_total_amount($j->id);
				  	$pay = $this->payment->get_total_payment($j->id);
				  	$total = ($amt - $pay);									
							
					//Add total to age[]
					if(($days > 0) && ($days <= 30)){						
						$age[0]['within30'] += $total;
					}else if(($days > 30) && ($days <= 60)){						
						$age[0]['within60'] += $total;
					}else if(($days > 60) && ($days <= 90)){						
						$age[0]['within90'] += $total;
					}else if($days > 90){
						$age[0]['over90'] += $total;
					}				
								
				  } /*End if status*/				  			  			  
			  } /*End foreach invList*/		  			   				   				   
			  			  			  
			}
		  	  
			
		$this->response($age, 200);	
			
		} /*End if*/		
	}
	
	
	
	/* --- PAYMENT TERM --- */
	
	//GET 
	function payment_term_get() {
		$data = $this->payment_term->get_all();		
		$this->response($data, 200);
	}
	
	//POST
	function payment_term_post() {			
		$this->payment_term->insert($this->post());
		//$this->response($this->post(), 200);		
	}
	
	//PUT
	function payment_term_put() {
 		 $this->payment_term->update($this->put('id'), $this->put());
	}
	
	//DELETE
	function payment_term_delete() {
		//$this->response(array("status"=>$this->delete('id')), 200);
		$this->payment_term->delete($this->delete('id'));
	}	
	
	
	
	/* --- PAYMENT METHOD --- */
	
	//GET 
	function payment_method_get() {
		$data = $this->payment_method->get_all();		
		$this->response($data, 200);
	}
	
	//POST
	function payment_method_post() {			
		$this->payment_method->insert($this->post());
		//$this->response($this->post(), 200);		
	}
	
	//PUT
	function payment_method_put() {
 		 $this->payment_method->update($this->put('id'), $this->put());
	}
	
	//DELETE
	function payment_method_delete() {
		//$this->response(array("status"=>$this->delete('id')), 200);
		$this->payment_method->delete($this->delete('id'));
	}
		
	
	
	/* --- PAYMENT METHOD --- */
	
	//GET 
	function currency_get() {
		$data = $this->currency->get_all();		
		$this->response($data, 200);
	}
	
	//POST
	function currency_post() {			
		$this->currency->insert($this->post());
		//$this->response($this->post(), 200);		
	}
	
	//PUT
	function currency_put() {
 		 $this->currency->update($this->put('id'), $this->put());
	}
	
	//DELETE
	function currency_delete() {
		//$this->response(array("status"=>$this->delete('id')), 200);
		$this->currency->delete($this->delete('id'));
	}
	
	
}