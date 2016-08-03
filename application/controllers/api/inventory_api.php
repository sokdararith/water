<?php defined('BASEPATH') OR exit('No direct script access allowed');


require APPPATH.'/libraries/REST_Controller.php';

class Inventory_api extends REST_Controller {
	
	
	//CONSTRUCTOR
	function __construct() {
		parent::__construct();
		$this->load->model('inventory/item_model', 'item');
		$this->load->model('inventory/item_record_model', 'item_record');
		$this->load->model('inventory/item_type_model', 'item_type');
		$this->load->model('inventory/meter_model', 'meter');
		$this->load->model('inventory/breaker_model', 'breaker');
		$this->load->model('inventory/meter_record_model', 'meter_record');
		$this->load->model('inventory/unit_measure_model', 'unit_measure');		
		$this->load->model('accounting/account_model', 'account');
		$this->load->model('inventory/item_receipt_model', 'item_receipt');
		
		$this->load->model('accounting/payment_term_model', 'payment_term');
		$this->load->model('accounting/journal_model', 'journal');
		$this->load->model('inventory/electricity_pole_model', 'electricity_pole');
		$this->load->model('inventory/electricity_box_model', 'electricity_box');
		$this->load->model('staff/employee_m', 'staff');
		$this->load->model('accounting/account_model', 'account');
		$this->load->model('accounting/journal_entry_model', 'j_entry');
	}
	
	
	
	/* --- ITEM --- */
	
	//GET 
	function item_get() {
		$filter= $this->get('filter');
		if(!empty($filter) && isset($filter)){			
			$criteria = array();				
			for ($i = 0; $i < count($filter['filters']); ++$i) {				
				$criteria += array($filter['filters'][$i]['field'] => $filter['filters'][$i]['value']);
			}
			$query = $this->item->get_many_by($criteria);
		} else {
			$query = $this->item->get_all();
		}
		$arr;
		if(count($query) > 0) {
			foreach($query as $row){	
				$arr[] = array(
					"id" 					=> $row->id,
					'item_sku' 				=> $row->item_sku,
					'name' 			   		=> $row->name,
					'amount' 	    		=> $row->amount,
					'order_point'			=> $row->order_point,
					'cost' 	    			=> $row->cost,
					'price' 	    		=> $row->price,
					'purchase_description'  => $row->purchase_description,					 
					'sale_description'      => $row->sale_description,
					'item_type_id' 			=> $row->item_type_id,				
					// // 'phase'					=> $row->phase,
					// // 'ampere'				=> $row->ampere,
					// // 'fuse'					=> $row->fuse,
					// // 'voltage'				=> $row->voltage,
					'status'    			=> $row->status==1? TRUE:FALSE,
					'general_account' 		=> $this->account->get($row->general_account_id),
					'cogs_account' 	    	=> $this->account->get($row->cogs_account_id),
					'income_account' 		=> $this->account->get($row->income_account_id),
					'measurement'			=> $this->unit_measure->get($row->unit_measure_id),
					'type' 					=> $this->item_type->get_by('id',$row->item_type_id),
					'account_name'	   		=> $this->account->get_by('id',$row->general_account_id)
				);						
			}
			$this->response(array("status"=>"OK", "results"=>$arr), 200);	
		} else {
			$this->response(array("status"=>"Error", "count"=>0, "results"=>array()), 200);
		}						
	}
	
	function inventories_get() {
		$data = $this->item->get_many_by('item_type_id',1);
		foreach($data as $row){			
			$arr[] = array(
					"id" 					=> $row->id,
					'item_sku' 				=> $row->item_sku,
					'name' 			   		=> $row->name,
					'item_type_id' 			=> $row->item_type_id,
					'unit_measure_id' 		=> $row->unit_measure_id,
					'quantity' 	    		=> $row->quantity,
					'cost' 	    			=> $row->cost,
					'price' 	    		=> $row->price,
					'purchase_description'  => $row->purchase_description,					 
					'sale_description'      => $row->sale_description,				
					'phase'					=> $row->phase,
					'ampere'				=> $row->ampere,
					'fuse'					=> $row->fuse,
					'voltage'				=> $row->voltage,
					'status'    			=> $row->status==1? TRUE:FALSE,
					//'general_account' 		=> $this->account->get($row->general_account_id),
					//'cogs_account' 	    	=> $this->account->get($row->cogs_account_id),
					//'income_account' 		=> $this->account->get($row->income_account_id),
					//'measurement'			=> $this->unit_measure->get($row->unit_measure_id),
					//'type_name'				=> $this->item_type->get_by('id',$row->item_type_id),
					//'account_name'	   		=> $this->account->get_by('id',$row->general_account_id)
			);
		}
						
		$this->response($arr, 200);		
	}

	function reports_get() {
		$filter = $this->get('filter');
		$from = $filter['filters'][0]['value'];
		$to   = $filter['filters'][1]['value'];
		$data = $this->item->get_many_by('item_type_id',1);
		$arr  = array();
		foreach($data as $row){			
			$arr['results'][] = array(
					"id" 					=> $row->id,
					'item_sku' 				=> $row->item_sku,
					'name' 			   		=> $row->name,
					'item_type_id' 			=> $row->item_type_id,
					'unit_measure_id' 		=> $row->unit_measure_id,
					'quantity' 	    		=> $row->quantity,
					'cost' 	    			=> $row->cost,
					'price' 	    		=> $row->price,
					'purchase_description'  => $row->purchase_description,					 
					'sale_description'      => $row->sale_description,				
					'phase'					=> $row->phase,
					'ampere'				=> $row->ampere,
					'fuse'					=> $row->fuse,
					'voltage'				=> $row->voltage,
					'status'    			=> $row->status==1? TRUE:FALSE,
					'sale_qty'				=> $this->item_record->sales_qty($row->id, $from, $to),
					'avg_price'				=> $this->item_record->avg_price($row->id, $from, $to),
					//'general_account' 		=> $this->account->get($row->general_account_id),
					//'cogs_account' 	    	=> $this->account->get($row->cogs_account_id),
					//'income_account' 		=> $this->account->get($row->income_account_id),
					//'measurement'			=> $this->unit_measure->get($row->unit_measure_id),
					//'type_name'				=> $this->item_type->get_by('id',$row->item_type_id),
					//'account_name'	   		=> $this->account->get_by('id',$row->general_account_id)
			);
		}
						
		$this->response($arr, 200);
	}
	
	//POST
	function item_post() {	
		$arr = array('item_sku' 			=> $this->post('item_sku'),
					 'company_id'			=> $this->post('company_id'),
					 'name' 			    => $this->post('name'),
					 'item_type_id' 		=> $this->post('item_type_id'),
					 'unit_measure_id' 		=> $this->post('unit_measure_id'),
					 'quantity' 	    	=> $this->post('quantity'),
					 'cost' 	    		=> $this->post('cost'),
					 'price' 	       		=> $this->post('price'),
					 'general_account_id' 	=> $this->post('general_account_id'),
					 'cogs_account_id' 	    => $this->post('cogs_account_id'),
					 'income_account_id' 	=> $this->post('income_account_id'),
					 'purchase_description' => $this->post('purchase_description'),					 
				     'sale_description'     => $this->post('sale_description'),					
					 'phase'				=> $this->post('phase'),
					 'ampere'				=> $this->post('ampere'),
					 'fuse'					=> $this->post('fuse'),
					 'voltage'				=> $this->post('voltage'),
					 'status'    			=> $this->post('status') ? 1:0
		);	
		$id = $this->item->insert($arr);
		$q = $this->item->get($id);
		$data = array(
			"id" 					=> $q->id,
			'item_sku' 				=> $q->item_sku,
			'name' 			   		=> $q->name,
			'item_type_id' 			=> $q->item_type_id,
			'unit_measure_id' 		=> $q->unit_measure_id,
			'quantity' 	    		=> $q->quantity,
			'cost' 	    			=> $q->cost,
			'price' 	    		=> $q->price,
			'general_account_id' 	=> $q->general_account_id,
			'cogs_account_id' 	    => $q->cogs_account_id,
			'income_account_id' 	=> $q->income_account_id,
			'purchase_description'  => $q->purchase_description,					 
			'sale_description'      => $q->sale_description,				
			'phase'					=> $q->phase,
			'ampere'				=> $q->ampere,
			'fuse'					=> $q->fuse,
			'voltage'				=> $q->voltage,
			'status'    			=> $q->status==1? TRUE:FALSE,
			'measurement'			=> $this->unit_measure->get($q->unit_measure_id),
			'type_name'				=> $this->item_type->get_by('id',$q->item_type_id),
			'account_name'	   		=> $this->account->get_by('id',$q->general_account_id),
			'records'				=> $this->item_record->get_many_by('item_id', $q->id)
		);
		$this->response($data, 200);				
	}
	
	//PUT
	function item_put() {
		
		$new_quantity = $this->put("new_quantity");
		$arr;			
		if(!empty($new_quantity) && isset($new_quantity)){
			 	
			$arr = array('item_sku' 			=> $this->put('item_sku'),
						 'name' 			    => $this->put('name'),
						 'item_type_id' 		=> $this->put('item_type_id'),
						 'unit_measure_id' 		=> $this->put('unit_measure_id'),
						 'quantity' 	    	=> $this->put('new_quantity'),
						 'cost' 	    		=> $this->put('cost'),
						 'price' 	       		=> $this->put('price'),
						 'general_account_id'   => $this->put('general_account_id'),
						 'cogs_account_id' 	    => $this->put('cogs_account_id'),
						 'income_account_id' 	=> $this->put('income_account_id'),
						 'purchase_description' => $this->put('purchase_description'),					 
					     'sale_description'     => $this->put('sale_description'),
						 'phase'				=> $this->put('phase'),
						 'ampere'				=> $this->put('ampere'),
						 'fuse'					=> $this->put('fuse'),
						 'voltage'				=> $this->put('voltage'),
						 'status'    			=> $this->put('status') ? 1:0
				);
		 							
		 }
		 else{
	 		$arr = array('item_sku' 			=> $this->put('item_sku'),
					 'name' 			    => $this->put('name'),
					 'item_type_id' 		=> $this->put('item_type_id'),
					 'unit_measure_id' 		=> $this->put('unit_measure_id'),
					 'quantity' 	    	=> $this->put('quantity'),
					 'cost' 	    		=> $this->put('cost'),
					 'price' 	       		=> $this->put('price'),
					 'general_account_id' 	=> $this->put('general_account_id'),
					 'cogs_account_id' 	    => $this->put('cogs_account_id'),
					 'income_account_id' 	=> $this->put('income_account_id'),
					 'purchase_description' => $this->put('purchase_description'),					 
				     'sale_description'     => $this->put('sale_description'),					
					 'phase'				=> $this->put('phase'),
					 'ampere'				=> $this->put('ampere'),
					 'fuse'					=> $this->put('fuse'),
					 'voltage'				=> $this->put('voltage'),
					 'status'    			=> $this->put('status') ? 1:0
			);
		 }
		
 		$this->item->update($this->put('id'), $arr);
		$q = $this->item->get($this->put('id'));
		$data = array(
			"id" 					=> $q->id,
			'item_sku' 				=> $q->item_sku,
			'name' 			   		=> $q->name,
			'item_type_id' 			=> $q->item_type_id,
			'unit_measure_id' 		=> $q->unit_measure_id,
			'quantity' 	    		=> $q->quantity,
			'cost' 	    			=> $q->cost,
			'price' 	    		=> $q->price,
			'general_account_id' 	=> $q->general_account_id,
			'cogs_account_id' 	    => $q->cogs_account_id,
			'income_account_id' 	=> $q->income_account_id,
			'purchase_description'  => $q->purchase_description,					 
			'sale_description'      => $q->sale_description,				
			'phase'					=> $q->phase,
			'ampere'				=> $q->ampere,
			'fuse'					=> $q->fuse,
			'voltage'				=> $q->voltage,
			'status'    			=> $q->status==1? TRUE:FALSE,
			'measurement'			=> $this->unit_measure->get($q->unit_measure_id),
			'type_name'				=> $this->item_type->get_by('id',$q->item_type_id),
			'account_name'	   		=> $this->account->get_by('id',$q->general_account_id)
		);
		$this->response($data, 200);
	}
	
	//DELETE
	function item_delete() {
		//$this->response(array("status"=>$this->delete('id')), 200);
		$this->item->delete($this->delete('id'));
	}
	

	//*** Dawine ***
	//ITEMS
	function items_get() {
		$filter = $this->get("filter");
		$limit = $this->get("pageSize");
		$offset = $this->get('skip');
		$sorter = $this->get("sort");

		if(!empty($filter) && isset($filter)){			
			//Filter
			$para = array();				
			for ($i = 0; $i < count($filter['filters']); ++$i) {				
				$para += array($filter['filters'][$i]['field'] => $filter['filters'][$i]['value']);
			}
			
			//Limit
			if(!empty($limit) && isset($limit)){
				$this->item->limit($limit, $offset);
			}			
			
			//Sort
			if(!empty($sorter) && isset($sorter)){			
				$sort = array();
				for ($j = 0; $j < count($sorter); ++$j) {				
					$sort += array($sorter[$j]['field'] => $sorter[$j]['dir']);
				}
				$this->item->order_by($sort);
			}

			$data["results"] = $this->item->get_many_by($para);
			$data["total"] = $this->item->count_by($para);

			$this->response($data, 200);			
		}else{
			$data["results"] = $this->item->get_all();
			$data["total"] = $this->item->count_all();
			$this->response($data, 200);
		}			
	}

	function itemrecords_get() {
		$filter= $this->get('filter');
		$limit = $this->get("pageSize");
		$offset = $this->get("skip"); 
		if(!empty($filter) && isset($filter)){			
			$criteria = array();				
			for ($i = 0; $i < count($filter['filters']); ++$i) {				
				$criteria += array($filter['filters'][$i]['field'] => $filter['filters'][$i]['value']);
			}
			$query = $this->item_record->limit($limit, $offset)->get_many_by($criteria);
			$count = $this->item_record->count_by($criteria);

			if(count($query)>0) {
				foreach($query as $row){	
					$arr[] = array(
						"id" 			=> $row->id,
						"item_id"		=> $row->item_id,
						"bill"	 		=> $this->journal->get($row->id),				
						"description"	=> $row->description,
						"cost"			=> $row->cost,
						"price"			=> $row->price,
						"quantity"		=> $row->quantity,
						"amount"		=> $row->amount,
						"balance"		=> $row->balance,
						"taxed"			=> $row->taxed === "1" ? true:false,
						"created_at"	=> $row->created_at
					);						
				}
				$this->response(array("status"=>"OK", "count"=>$count, "results"=>$arr), 200);	
			} else {
				$this->response(array("status"=>"Error", "count"=>0, "results"=>array()), 200);
			}
		} else {
			$this->response(array("status"=>"Error", "count"=>0, "results"=>array()), 200);
		}	
	}


	function itemrecords_post() {
		$postedData = json_decode($this->post('models'));
		foreach($postedData as $k=>$v) {
			$data[] = array(
				"bill_id" => $v->bill_id,
				"item_id" => $v->item_id,
				"description" => $v->description,
				"cost"	=> $v->cost,
				"price" => $v->price,
				"quantity" => $v->quantity,
				"amount" => $v->amount,
				"taxed" => $v->taxed === true ? 1 : 0
			);
			$current_item = $this->item->get($v->item_id);
			$unit = $current_item->on_hand + $v->quantity;
			$amount = $current_item->amount + $v->amount;
			$this->item->update($v->item_id, array("on_hand" => $unit, "amount"=> $amount, "weighted_avg"=> $amount/$unit));
		}

		$ids = $this->item_record->insert_many($data);
		if($this->db->affected_rows() > 0) {
			$query = $this->item_record->get_many($ids);
			$count = $this->item_record->count_by(array("bill_id" => $postedData[0]->bill_id));
			if(count($query)>0) {
				foreach($query as $row){	
					$arr[] = array(
						"id" 			=> $row->id,
						"item_id"		=> $row->item_id,
						"bill_id"	 	=> $row->bill_id,				
						"description"	=> $row->description,
						"cost"			=> $row->cost,
						"price"			=> $row->price,
						"quantity"		=> $row->quantity,
						"amount"		=> $row->amount,
						"balance"		=> $row->balance,
						"taxed"			=> $row->taxed === "1" ? true:false,
						"created_at"	=> $row->created_at
					);						
				}
				$this->response(array("status"=>"OK", "count"=>$count, "results"=>$arr), 200);	
			} else {
				$this->response(array("status"=>"Error", "count"=>0, "results"=>array()), 200);
			}
		} else {
			$this->response(array("status"=>"Error", "count"=>0, "results"=>$array()), 200);
		}
	}

	function itemrecords_put() {
		$postedData = json_decode($this->put('models'));
		$ids = array();
		foreach($postedData as $k=>$v) {
			$ids[] = $v->id;

			// get two last records by ASC order and select the first one for based calculation
			// 
			$item = $this->item->limit(1)->order_by("created_at", "DESC")->get($v->item_id);
			$current_item = $this->item_record->limit(1)->order_by('created_at', 'DESC')->get($v->id);

			$temp = 0;
			$unit = $item->on_hand - $current_item->quantity;
			$amount = $item->amount - $current_item->amount;
			if($current_item->quantity > $v->quantity) {
				//
				$temp = $current_item->quantity - ($current_item->quantity - $v->quantity);
				$temp_amount = $current_item->amount + ($current_item->amount - $v->amount);
			} else {
				//
				$temp = $current_item->quantity + ($v->quantity - $current_item->quantity);
				$temp_amount = $current_item->amount + ($v->amount - $current_item->amount);
			}

			 $unit = $unit + $temp;
			$amount = $amount + $temp_amount;
			$this->item->update($v->item_id, array("on_hand" => $unit, "amount"=> $amount, "weighted_avg"=> $amount/$unit));

			$this->item_record->update($v->id, array(
				"item_id" => $v->item_id,
				"description" => $v->description,
				"cost"	=> $v->cost,
				"price" => $v->price,
				"quantity" => $v->quantity,
				"amount" => $v->amount,
				"taxed" => $v->taxed === true ? 1 : 0
			));	
		}

		if($this->db->affected_rows() > 0) {
			$query = $this->item_record->get_many($ids);
			if(count($query)>0) {
				foreach($query as $row){	
					$arr[] = array(
						"id" 			=> $row->id,
						"item_id"		=> $row->item_id,
						"bill_id"	 	=> $row->bill_id,				
						"description"	=> $row->description,
						"cost"			=> $row->cost,
						"price"			=> $row->price,
						"quantity"		=> $row->quantity,
						"amount"		=> $row->amount,
						"balance"		=> $row->balance,
						"taxed"			=> $row->taxed === "1" ? true:false,
						"created_at"	=> $row->created_at
					);						
				}
				$this->response(array("status"=>"OK", "count"=>count($query), "results"=>$arr), 200);	
			} else {
				$this->response(array("status"=>"Error", "count"=>0, "results"=>array()), 200);
			}
		} else {
			$this->response(array("status"=>"Error", "count"=>0, "results"=>$array()), 200);
		}
	}

	function itemrecords_delete() {}

	//ITEM FOR DROPDOWN 
	function item_dropdown_get(){
		$filter = $this->get("filter");

		$para = array();				
		for ($i = 0; $i < count($filter['filters']); ++$i) {				
			$para += array($filter['filters'][$i]['field'] => $filter['filters'][$i]['value']);
		}

		$data = $this->item->where_not_in("item_type_id", array(6))
							->get_many_by($para);
													
		$this->response($data, 200);
	}

	//ITEM BY
	function item_by_get(){
		$filter = $this->get("filter");
		$myKey = array();
		$myVal = array();
		for ($i = 0; $i < count($filter['filters']); ++$i) {
			array_push($myKey, $filter['filters'][$i]['field']);
			array_push($myVal, $filter['filters'][$i]['value']);				
		}
		$para = array_combine($myKey, $myVal);	
		$data = $this->item->get_many_by($para);						
		$this->response($data, 200);
	}	
	//End of Dawine
		
	/* --- ITEM RECORD--- */
	public function item_Records_get() {
		$filter = $this->get('filter');
		$query = $this->item_record->limit($this->get("pageSize"),$this->get("skip"))->get_many_by("item_id", $filter['filters'][0]['value']);

		if(count($query)> 0) {
			$this->response(array("records"=>$query,"total"=>count($this->item_record->get_many_by("item_id", $filter['filters'][0]['value']))), 200);
		} else {
			$this->response(array("records"=>array("description"=>""), "status"=>"error", "message"=>"no data found!"),200);
		}
	}
	//GET 
	function item_record_get() {
		$item_receipt_id = $this->get('item_receipt_id');
		$filter = $this->get("filter");	
		
		if ($item_receipt_id != 0){
			$arr = $this->item_record->get_item_record_by_item_receipt_id($item_receipt_id);
			foreach($data as $row){
				$data[] = array(
					"id" 				=> $row->id,
					'item_receipt_id' 	=> $row->item_receipt_id,
					'item_id' 			=> $row->item_id,
					'description' 		=> $row->description,
					'unit_number' 		=> $row->unit_number,
					'cost' 				=> $row->cost,
					'quantity' 	    	=> $row->quantity,
					'amount' 	    	=> $row->amount,				
					'item_name'			=> $this->item->get_by('id',$row->item_id),
					'item_receipt'	    => $this->item_receipt->get_by('id',$row->item_receipt_id)
					
				);
			}
		} elseif (!empty($filter) && isset($filter)) {
			$data = $this->item_record->get_many_by(array('item_id'	=>$filter['filters'][0]['value'],
		  											   	  'status'	=>1));	
		}
		else{
			$data = $this->item_record->get_all();
		}
						
		$this->response($data, 200);		
	}
	
		
	//POST
	function item_record_post() {	
		$posted_data = $this->post();
		foreach($posted_data as $key => $value){
			if(count($value)>0 && $key !== "id") {
				$item_records[] = array(
						"bill_id" 		=> $value["bill_id"],
						"item_id" 		=> $value["item_id"],
						"description" 	=> $value["description"],
						"cost" 			=> $value["cost"],
						"price" 		=> $value["price"],
						"quantity" 		=> $value["quantity"],
						"amount" 		=> $value["amount"],
						"balance" 		=> ($this->item_record->last_balance_of($value["item_id"]) + $value["quantity"])
				);
				//Get the weighted average cost for each item
				//formula total amount/total quantity
				$items = array(
					"cost" => (($this->item->get_item_cost($value["item_id"]) * $this->item_record->last_balance_of($value["item_id"])) + $value["amount"]) / ($this->item_record->last_balance_of($value["item_id"]) + $value["quantity"]),
					"quantity" => $this->item->get_quantity($value["item_id"]) + $value["quantity"]
				);
				$item_ids[] = $value["item_id"];
				//Update Item
				$this->item->update($value["item_id"], $items);
			}
		}

		//Add Item Record
		$row = $this->item_record->insert_many($item_records);	
		if($row && count($row) > 0) {
			$this->response(array("status"=>"Succeed.", "error"=>"false", "results"=>$this->item_record->get_many($row)), 201);
		} else {
			$this->response(array("status"=>"Fail", "error"=>"true", "results"=>array()), 200);
		}	
	}
	
	//PUT
	function item_record_put() {
		$arr = array('item_receipt_id' 		=> $this->put('item_receipt_id'),
					 'item_id' 				=> $this->put('item_id'),
					 'description' 	        => $this->put('description'),
					 'unit_number' 	        => $this->put('unit_number'),
					 'cost' 	            => $this->put('cost'),
					 'quantity' 	        => $this->put('quantity'),
					 'amount' 	            => $this->put('amount')
					
		);
		
		$item = $this->item->get_by('id', $this->put('item_id'));
		$amount = $item->cost * $item->quantity	;
		
		//Get Average Cost
		$avg_cost = ($this->put('amount') + $amount) / ($this->put('quantity') + $item->quantity);
		
		$item->cost = $avg_cost;	
		$item->quantity += $this->put('quantity');
		
 		$this->item_record->update($this->put('id'), $arr);
		
		//Update Item		
		$this->item->update($item->id, $item);			
	}		
	
	//DELETE
	function item_record_delete() {
		//$this->response(array("status"=>$this->delete('id')), 200);
		
		$item = $this->item->get_by('id', $this->delete('item_id'));
		$amount = $item->cost * $item->quantity	;
		
		//Get Average Cost
		$avg_cost = ($this->delete('amount') + $amount) / ($this->delete('quantity') + $item->quantity);
		
		$item->cost = $avg_cost;	
		$item->quantity += $this->delete('quantity');
		
		$this->item_record->delete($this->delete('id'));
		
		//Update Item		
		$this->item->update($item->id, $item);		
	}
				
	/* --- ITEM TYPE --- */
	
	//GET 
	function item_type_get() {
		$data = $this->item_type->get_all();		
		$this->response($data, 200);
	}
	
	//POST
	function item_type_post() {			
	    $id = $this->item_type->insert($this->post());
		$this->response($this->item_type->get($id), 200);		
	}
	
	//PUT
	function item_type_put() {
 		 $this->item_type->update($this->put('id'), $this->put());
 		 $this->response($this->item_type->get($this->put('id')), 200);
	}
	
	//DELETE
	function item_type_delete() {
		
		$this->item_type->delete($this->delete('id'));
		$this->response(array("status"=>"Successfully deleted: " . $this->delete('id')), 200);
	}
	
	
	
	/* --- UNIT MEASURE --- */
	
	//GET 
	function unit_measure_get() {
		$data = $this->unit_measure->get_all();		
		$this->response($data, 200);
	}
	
	//POST
	function unit_measure_post() {			
		$this->unit_measure->insert($this->post());
		//$this->response($this->post(), 200);		
	}
	
	//PUT
	function unit_measure_put() {
 		 $this->unit_measure->update($this->put('id'), $this->put());
	}
	
	//DELETE
	function unit_measure_delete() {
		//$this->response(array("status"=>$this->delete('id')), 200);
		$this->unit_measure->delete($this->delete('id'));
	}
	
	
	/* --- ITEM RECEIPT --- */
	//GET 
	function item_receipt_get() {

		$receipt_type = $this->get('receipt_type');
		$data;	
			
		if ($receipt_type === "Item" || $receipt_type === "Expense"){
			$data = $this->item_receipt->get_item_receipt_by_receipt_type($receipt_type);
		
		}else{
			$data = $this->item_receipt->get_all();
		}	
			
		foreach($data as $row){
			$arr[] = array(
				"id" 				=> $row->id,
				'receipt_type'		=> $row->receipt_type,
				'bill_type' 		=> $row->bill_type,
				'account_id' 		=> $row->account_id,
				'vendor_id' 		=> $row->vendor_id,
				'ref_no' 			=> $row->ref_no,
				'payment_term_id' 	=> $row->payment_term_id,
				'total' 	    	=> $row->total,
				'bill_date' 	    => $row->bill_date,
				'due_date' 			=> $row->due_date,
				'discount_date' 	=> $row->discount_date,				
				'vendor' 			=> $this->people->get_by('id', $row->vendor_id),
				'payment_term'		=> $this->payment_term->get_by('id', $row->payment_term_id),
				'account_name'	    => $this->account->get_by('id',$row->account_id)
			);
			
		}
		$this->response($arr, 200);
	}
	
	//POST
	function item_receipt_post() {	
		$arr = array('account_id' 		=> $this->post('account_id'),
					 'receipt_type'		=> $this->post('receipt_type'),
					 'bill_type' 		=> $this->post('bill_type'),	
					 'vendor_id' 		=> $this->post('vendor_id'),				
					 'ref_no' 			=> $this->post('ref_no'),
					 'payment_term_id' 	=> $this->post('payment_term_id'),
					 'total' 		    => $this->post('total'),
					 'bill_date' 	    => date("Y-m-d", strtotime($this->post('bill_date'))),
					 'due_date' 	    => $this->post('due_date'),
					 'discount_date' 	=> $this->post('discount_date')
									
		);	
		$receipt_id = $this->item_receipt->insert($arr);
		
		//Session Flass Data Use to store receipt id, type
				
		$this->session->set_flashdata('receipt_id', $receipt_id);
		
		//$this->response(array('id' => $this->receipt_id ), 200);				
	}
	
	//PUT
	function item_receipt_put() {
		$arr = array('account_id' 		=> $this->put('account_id'),
					 'receipt_type'		=> $this->put('receipt_type'),
					 'bill_type' 		=> $this->put('bill_type'),	
					 'vendor_id' 		=> $this->put('vendor_id'),
					 'ref_no' 			=> $this->put('ref_no'),
					 'payment_term_id' 	=> $this->put('payment_term_id'),
					 'total' 		    => $this->put('total'),
					 'bill_date' 	    => date('Y-m-d', strtotime($this->put('bill_date'))),
					 'due_date' 	    => date('Y-m-d', strtotime($this->put('due_date'))),
					 'discount_date' 	=> date('Y-m-d', strtotime($this->put('discount_date')))
									
		);	
		
		//Session Flass Data Use to store receipt id
		$this->session->set_flashdata('receipt_id', $this->put('id'));
		
 		$this->item_receipt->update($this->put('id'), $arr);
		
	}
	
	//DELETE
	function item_receipt_delete() {
		//$this->response(array("status"=>$this->delete('id')), 200);
		$this->item_receipt->delete($this->delete('id'));
	}
	
	//GET CUSTOMER METER BY AREA
	function customer_meter_by_area_get(){
		$filter = $this->get("filter");		
		if(!empty($filter) && isset($filter)){			
			$arr = $this->meter->get_customer_meter_by_area_id($filter['filters'][0]['value'])->get_all();
			if(count($arr) >0){
				foreach($arr as $row) {				  
					$data[] = array('id' 				=> $row->id,							   
							   		'reading'			=> "",
							   		'fullname'			=> $row->fullname,
							   		'typeName'			=> $row->typeName,
							  	 	'meter_no'			=> $row->meter_no,							   
									'meter_records'		=> $this->meter_record->order_by("id", "desc")->limit(1)->get_by('meter_id', $row->id),
							  		'avg'				=> $this->meter_record->get_avg($row->id)							    								   
					);	
				}				
				$this->response($data, 200);		
			}else{
				$this->response(FALSE, 200);
			}
		}else{
			$this->response(FALSE, 200);
		}
	}	
}