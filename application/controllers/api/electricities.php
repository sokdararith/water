<?php defined('BASEPATH') OR exit('No direct script access allowed');


require APPPATH.'/libraries/REST_Controller.php';

class Electricities extends REST_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model('power_m', 'power');
		$this->load->model('transformer_m', 'transformer');
		$this->load->model('transformer_attribute_m', 'attributes');
		$this->load->model('transrecord_m', 'record');
		$this->load->model('bill_model', 'bill');
		$this->load->model('accounting/journal_model', 'journal');
		$this->load->model('accounting/journal_entry_model', 'j_entry');
		$this->load->model('inventory/item_record_model', 'billItems');
		$this->load->model('bill_payment_m', 'bill_payment');
		$this->load->model('class_m', 'class');
		$this->load->model('distribution_m', 'line');
		$this->load->model('people/people_model', 'people');
		$this->load->model('inventory/meter_record_model', 'meterRecords');
		$this->load->model('distribution_area_model', 'distributionAreas');
		$this->load->model('generator_model', 'generators');
		$this->load->model('generator_record_model', 'generatorRecords');
	}

	// public function transformers_get($transformer_id = "") {
	// 	//check if transformer_id is present
	// 	if($transformer_id != "") {
	// 		$this->response($this->tranformer->get($transformer_id), 200);
	// 	} else {
	// 		//if not present return all the transformers
	// 		$this->response($this->transformer->get_all(), 200);
	// 	}	
	// }

	//Transformer Type
	public function transformerTypes_get() {
		$types = $this->transformer_type->get_all();

		if(count($types) > 0) {
			$this->response($types, 200);
		} else {
			$this->response(array("status"=>"404", "message"=>"No data found!"), 404);
		}
	}

	public function transformerTypes_post() {
		$postedData = $this->post();

		if($postedData) {
			$id = $this->transformer_type->insert($postedData);
			if($id !== FALSE) {
				$type = $this->transformer_type->get($id);
				$this->response($type, 200);
			} else {
				$this->response(array("status"=>"400","message"=>"Cannot save data"), 400);
			}
		} else {
			$this->response(array("status"=>"400","message"=>"You must provide valid data."), 400);
		}
	}

	public function transformerTypes_put() {
		$postedData = $this->put();

		if($postedData) {
			$id = $this->transformer_type->update($this->put('id'), $postedData);
			if($id !== FALSE) {
				$type = $this->transformer_type->get($id);
				$this->response($type, 200);
			} else {
				$this->response(array("status"=>"400","message"=>"Cannot save data"), 400);
			}
		} else {
			$this->response(array("status"=>"400","message"=>"You must provide valid data."), 400);
		}
	}

	public function transformerTypes_delete() {
		$postedData = $this->delete('id');

		if($postedData) {
			$id = $this->transformer_type->delete($postedData);
			if($id !== FALSE) {
				$this->response(array("status"=>"200","message"=>"deleted".$postedData), 200);
			} else {
				$this->response(array("status"=>"400","message"=>"Cannot save data"), 400);
			}
		} else {
			$this->response(array("status"=>"400","message"=>"You must provide valid data."), 400);
		}
	}

	public function get_last_reading_get() {
		$transID = $this->get("transID");
		if($transID !=="") {
			$data = $this->record->order_by('id', "DESC")->limit(1)->get_many_by("transformer_id", $transID);
			if(count($data) > 0 ) {
					foreach($data as $r) {
						$items[] = array(
							"id"				=> $r->id,
							"bill_id"			=> $r->bill_id,
							"id"				=> $r->id,
							"multiplier"		=> $r->multiplier,
							"new_reading"		=> $r->new_reading,
							"prev_reading"		=> $r->prev_reading,
							"tariff"			=> $r->tariff,
							"transformer"		=> $this->transformer->get($r->transformer_id),
							"created_at"		=> $r->created_at,
							"updated_at"		=> $r->updated_at
						);
					}			
				$this->response($items, 200);
			}
		}
	}

	//Getting the record of tranformer with given id
	public function transformerRecords_get() {
		$filter= $this->get('filter');
		$limit = $this->get("pageSize");
		$offset = $this->get("skip"); 
		if(!empty($filter) && isset($filter)){			
			$criteria = array();				
			for ($i = 0; $i < count($filter['filters']); ++$i) {				
				$criteria += array($filter['filters'][$i]['field'] => $filter['filters'][$i]['value']);
			}
			$query = $this->record->limit($limit, $offset)->get_many_by($criteria);
			$count = $this->record->count_by($criteria);

			if(count($query)>0) {
				foreach($query as $row){	
					$arr[] = array(
						"bill_id"			=> $row->bill_id,
						"id"				=> $row->id,
						"multiplier"		=> $row->multiplier,
						"new_reading"		=> $row->new_reading,
						"prev_reading"		=> $row->prev_reading,
						"tariff"			=> $row->tariff,
						"transformer_id"	=> $row->transformer_id,
						"amount"			=> $row->amount,
						"created_at"		=> $row->created_at,
						"updated_at"		=> $row->updated_at
					);						
				}
				$this->response(array("status"=>"OK", "count"=>$count, "message"=>"data found.", "results"=>$arr), 200);	
			} else {
				$this->response(array("status"=>"Error", "count"=>0, "results"=>array()), 200);
			}
		} else {
			$this->response(array("status"=>"Error", "count"=>0, "results"=>array()), 200);
		}
	}

	//By The Great Mighty Dawine
	public function transformer_record_post() {
		$transformer_id = $this->post('transformer_id');
		$record = $this->record->order_by('id', 'DESC')->limit(1)->get_by(array('transformer_id'=>$transformer_id, 'type'=>'LV' ));
		$dateReadTo = "0000-00-00";
		if(!empty($record) && isset($record)){
			$dateReadTo = $record->date_read_to;
		}

		$data = array(
			"type"				=> $this->post("type"),
			"transformer_id"	=> $this->post("transformer_id"),
  			"usage" 			=> $this->post("usage"),
  			"month_of" 			=> $this->post("month_of"),
  			"date_read_from"  	=> $dateReadTo,
  			"date_read_to"  	=> $this->post("date_read_to"),
  			"reader" 			=> $this->post("reader")
		);
		$id = $this->record->insert($data);
		$this->response($id, 200);
	}

	public function transformerRecords_post() {
		$postedData = json_decode($this->post('models'));
		foreach($postedData as $k=>$v) {
			$data[] = array(
					"bill_id" => $v->bill_id,
					"transformer_id" => $v->transformer_id,
					"new_reading" => $v->new_reading,
					"prev_reading" => $v->prev_reading,
					"multiplier" => $v->multiplier,
					"tariff" => $v->tariff,
					"amount" => $v->amount,
					"vendor_id" => $v->vendor_id
				);			
		}
		$ids = $this->record->insert_many($data);
		// $this->response($data, 200);
		if(count($ids) > 0) {
			$query = $this->record->get_many($ids);
			$this->response(array("status"=>"OK","message"=>"Records created","results"=>$query), 200);
		} else {
			$this->response(array("status"=>"Failed","message"=>"Records cannot be created"), 200);
		}
	}

	public function transformerRecords_put() {
		$postedData = json_decode($this->put('models'));
		$ids = array();
		if($postedData){
			foreach($postedData as $k=>$v) {
				$ids[] = $v->id;
				$data = array(
						"transformer_id" => $v->transformer_id,
						"new_reading" => $v->new_reading,
						"prev_reading" => $v->prev_reading,
						"multiplier" => $v->multiplier,
						"tariff" => $v->tariff,
						"amount" => $v->amount
					);
				$this->record->update($v->id, $data);			
			}
		
 			$query = $this->record->get_many($ids);
 			if(count($query) > 0) {
 				foreach($query as $q) {
					$results[] = array(
						"bill_id" => $q->bill_id,
						"transformer_id" => $q->transformer_id,
						"new_reading" => $q->new_reading,
						"prev_reading" => $q->prev_reading,
						"multiplier" => $q->multiplier,
						"tariff" => $q->tariff,
						"amount" => $q->amount,
						"vendor_id" => $q->vendor_id
					);
				}
				$this->response(array("status"=>"OK", "message"=>"Purchase Order created.", "results"=>$results), 201);
 			} else {
 				$this->response(array("status"=>"Error", "message"=>"No results found.", "results"=>array()), 200);
 			}
		} else {
			$this->response(array("status"=>"Error", "message"=>"No results found.", "results"=>array()), 200);
		}
	}

	public function transformerRecords_delete() {
		$ids = json_decode($this->delete('models'));
		$this->db->trans_start();
		foreach($ids as $key=>$value) {
			$this->record->delete($value->id);
		}	
		$this->db->trans_complete();

		if($this->db->trans_status() !== FALSE) {
			$this->response(array("status"=>"OK", "message"=>"Purchase Order deleted.", "results"=>array()), 200);
		} else {
			$this->response(array("status"=>"Failed", "message"=>"Cannot delete Purchase Order.", "results"=>array()), 200);
		}
	}

	public function powers_get($powerPurchase_id = 0) {
		$filter = $this->get('filter');
		$from 	= $filter['filters'][0]['value'];
		$to 	= $filter['filters'][1]['value'];
		if($powerPurchase_id > 0) {
			$this->response($this->power->get($powerPurchase_id), 200);
		} else {
			if(!empty($from)) {
				$this->response($this->power->between_dates($from,$to)->get_all(), 200);
			} else {
				$this->response($this->power->get_all(), 200);
			}
		}
	}

	public function powers_post() {
		$amount = $this->post('amount');
		$date 	= $this->post('date_recorded');

		if($amount != "" && $date != "") {
			$id = $this->power->insert($this->post());
			if($id){
				$this->response($this->power->get($id), 200);
			} else {
				$this->response(array("status"=>"error", "message"=>"Insert failed"), 400);
			}
		} else {
			$this->response(array("status"=>"error", "message"=>"You passed empty fields"), 400);
		}
	}

	public function powers_put($powerPerchase_id) {

	}

	public function powers_delete($powerPerchase_id) {

	}

	public function distributions_get() {
		$data = $this->line->get_all();
		if($data) {
			$this->response($data, 200);
		} else {
			$this->response(array("status"=>"error", "message"=>"there is no data returned."), 400);
		}
	}

	public function distributions_post() {
		$inserted_data = $this->post();

		if($inserted_data !== "") {
			$id = $this->line->insert($inserted_data);
			if ( $id > 0) {
				$data = $this->line->get($id);
				$this->response($data, 200);
			} else {
				$this->response(array("status"=>"error", "message"=>"there is no data."), 500);
			}
		} else {
			$this->response(array("status"=>"error", "message"=>"there is no data."), 400);
		}

	}

	public function distributions_put() {
		$update_id = $this->put('id');

		$result = $this->line->update($update_id, $this->put());
		if($result) {
			$data = $this->line->get($update_id);
			$this->response($data, 200);
		} else {
			$this->response(array("status"=>"error", "message"=>"there is no data."), 500);
		}
	}

	public function distributions_delete() {
		$deleted_id = $this->delete("id");

		$this->line->delete($deleted_id);
	}

	//By the great mighty Dawine
	function transformer_cascading_get() {
		$filter = $this->get("filter");
		if(!empty($filter) && isset($filter)){
			$data = $this->transformer->get_many_by("company_id", $filter['filters'][0]['value']);
		}else{
			$data = $this->transformer->get_all();
		}							
		$this->response($data, 200);
	}

	function transformer_get() {
		$filter = $this->get("filter");		
		if(!empty($filter) && isset($filter)){			
			$para = array();				
			for ($i = 0; $i < count($filter['filters']); ++$i) {				
				$para += array($filter['filters'][$i]['field'] => $filter['filters'][$i]['value']);
			}			
			$data = $this->transformer->get_many_by($para);			
			$this->response($data, 200);			
		}else{
			$data = $this->transformer->get_all();
			$this->response($data, 200);
		}		
	}

	public function transformers_get() {
		$filter= $this->get('filter');
		if(!empty($filter) && isset($filter)){			
			$criteria = array();				
			for ($i = 0; $i < count($filter['filters']); ++$i) {				
				$criteria += array($filter['filters'][$i]['field'] => $filter['filters'][$i]['value']);
			}
			$query = $this->transformer->get_many_by($criteria);
		} else {
			$query = $this->transformer->get_all();
		}

		if(count($query) > 0) {
			foreach($query as $transformer) {
				$data[] = array(
					'id' => $transformer->id,
					'license' => $this->class->get($transformer->license_id), 
					'transformerNumber' => $transformer->transformer_number,
					'attributes' => $this->attributes->get_many_by("transformer_id", $transformer->id),
					'capacity' => $transformer->capacity,
					'type' => $transformer->type,
					'brand' => $transformer->brand,
					'location' => $transformer->location,
					'latitute' => $transformer->latitute,
					'longtitute' => $transformer->longtitute,
					'numberOfMeters' => array(),
					'numberOfCustomers' => array(),
					'numberOfBoxes' => array(),
					'price'	=> $transformer->price,
					'vendor' => $this->people->get($transformer->vendor_id),
					'created_at' => $transformer->created_at
				);
			}
			$this->response(array("status"=>"OK", "results"=>$data), 200);	
		} else {
			$this->response(array("status"=>"Error", "count"=>0, "results"=>array()), 200);
		}		
	}

	public function transformers_post() {
		$attr = array() ;
		foreach($this->post('attributes') as $k=>$v) {
			$attr[] = $v;
		}

		$transformer = array(
				'license_id' => $this->post('license'),
				'transformer_number' => $this->post('tranformerNumber'),
				'capacity' => $this->post('capacity'),
				'type' => $this->post('type'),
				'brand' => $this->post('brand'),
				'location' => $this->post('location'),
				'latitute' => $this->post('latitute'),
				'longtitute' => $this->post('longtitute')
			);
		$id = $this->transformer->insert($transformer);
		if ( $id > 0) {
			$index = 0;
			
			if(isset($attr)) {
				for($index; $index < count($attr); $index++) {
					$attr[$index]['transformer_id'] = $id;
				}
				$this->attributes->insert_many($attr);
			}

			$tran = $this->transformer->get($id);

			if($tran) {
			
				$data[] = array(
					'id' => $tran->id,
					'license' => $this->class->get($tran->license_id), 
					'transformerNumber' => $tran->transformer_number,
					'attributes' => $this->attributes->get_many_by("transformer_id", $tran->id),
					'type' => $tran->type,
					'capacity' => $tran->capacity,
					'brand' => $tran->brand,
					'location' => $tran->location,
					'latitute' => $tran->latitute,
					'longtitute' => $tran->longtitute
				);
				
				$this->response($data, 200);
			} else {
				$this->response(array("status"=>"error", "message"=>"there is no data returned."), 400);
			}
		} else {
			$this->response(array("status"=>"error", "message"=>"there is no data."), 500);
		}

	}

	public function transformers_put() {
		//$this->response(array("status"=>$this->put('attributes')), 200);
		$update_id = $this->put('id');
		$license = $this->put('license');
		$attr = array() ;
		if($this->put('attributes')) {
			foreach($this->put('attributes') as $k=>$v) {
				$attr[] = $v;
			}
		}
		

		$transformer = array(
				'license_id' => $license['id'],
				'transformer_number' => $this->put('transformerNumber'),
				'type'	=> $this->put('type'),
				'capacity' => $this->put('capacity'),
				'brand' => $this->put('brand'),
				'location' => $this->put('location'),
				'latitute' => $this->put('latitute'),
				'longtitute' => $this->put('longtitute')
			);
		$id = $this->transformer->update($update_id, $transformer);
		if ( $id ) {
			if(isset($attr)) {
				for($index = 0; $index < count($attr); $index++) {
					$this->attributes->update_by(array("transformer_id"=>$update_id, "id"=>$attr[$index]['id']), $attr[$index]);
				}
				
				$tran = $this->transformer->get($update_id);
			}

			if(count($tran) > 0) {
				$data = array(
					'id' => $tran->id,
					'license' => $this->class->get($tran->license_id), 
					'transformerNumber' => $tran->transformer_number,
					'attributes' => $this->attributes->get_many_by("transformer_id", $tran->id),
					'type'	=> $tran->type,
					'capacity' => $tran->capacity,
					'brand' => $tran->brand,
					'location' => $tran->location,
					'latitute' => $tran->latitute,
					'longtitute' => $tran->longtitute
				);
				$this->response($data, 200);
			} else {
				$this->response(array("status"=>"error", "message"=>"there is no data returned."), 400);
			}
		} else {
			$this->response(array("status"=>"error", "message"=>"there is no data."), 500);
		}
	}

	public function transformers_delete() {
		$deleted_id = $this->delete("id");

		$this->transformer->delete($deleted_id);
	}

	public function bills_get() {
		$filter = $this->get('filter');

		if($filter['filters']['0']["value"] === null && $filter['filters']['2']["value"] === null) {
			$criteria = array("created_at >=" => $filter['filters']['1']["value"]);
		}
		if($filter['filters']['0']["value"] !== null && $filter['filters']['2']["value"] === null) {
			$criteria = array("status" => $filter['filters']['0']["value"],
							  "created_at >=" => $filter['filters']['1']["value"]);
		}
		if($filter['filters']['0']["value"] !== null && $filter['filters']['2']["value"] !== null) {
			$criteria = array("status" => $filter['filters']['0']["value"],
							  "created_at >=" => $filter['filters']['1']["value"],
							  "vendor_id" => $filter['filters']['2']["value"]);
		}

		if($filter) {
			$data = $this->bill->get_many_by($criteria);

			if(count($data) > 0) {
				foreach($data as $row) {
					$bills[] = array(
						"id" 			=> $row->id,
						"vendor_id" 	=> $row->vendor_id,
						"bill_type" 	=> $row->bill_type,
						"amount_billed" => $row->amount_billed,
						"amount_due" 	=> ($row->amount_billed - $this->bill_payment->amount_paid($row->id)),
						"amount_paid" 	=> $this->bill_payment->amount_paid($row->id),
						"amount_pay" 	=> 0,
						"payment_term_id"=> $row->payment_term_id,
						"invoiceNumber" => $row->invoice_number,
						"voucher"		=> $row->voucher,
						"date"			=> $row->date,
						"dueDate"		=> $row->due_date,
						"status"		=> $row->status,
						"billPayment"	=> $this->bill_payment->get_many_by(array("bill_id"=>$row->id)),
						"items"			=> $this->billItems->get_many_by(array("bill_id"=>$row->id)),
						"journal"		=> $this->journal->get_by("number", $row->id)
					);
				}
				$this->response(array("status" => "OK","message"=>"successfully queried", "bills"=>$bills), 200);				
			} else {
				$this->response(array("status" => "Failed","message"=>"No result found.", "bills"=>array()), 200);
			}
		} else {	
			$this->response(array("status" => "Failed","message"=>"No query provided.", "bills"=>array()), 200);					
		}
	}

	public function bills_post() {
		$generatedId = $this->v4();
		$bill = array(
			"id"=> $generatedId,
			"vendor_id" => $this->post('vendor_id'),
			"payment_term_id" => $this->post("paymentTerm"),
			"employee_id"  => $this->post("employee_id"),
			"bill_type"	=>$this->post("bill_type"),
			"date"	=> $this->post("date"),
			"due_date" => $this->post("due_date"),
			"amount_billed" => $this->post("amount_billed"),
			"voucher" => $this->post("voucher"),
			"invoice_number" => $this->post("invoiceNumber"),
			"status" => $this->post("status")
		);		
		$this->bill->insert($bill);

		$query = $this->bill->get($bill['id']);

		if(count($query) > 0) {
			// add items
			// foreach($this->post('items') as $k=>$v) {
			// 	$items[] = array(
			// 		"id" => $this->v4(),
			// 		"bill_id" => $query->id,
			// 		"item_id" => $v['item_id'],
			// 		"description" => $v['description'],
			// 		"cost" => $v['cost'],
			// 		"quantity" => $v['quantity'],
			// 		"amount" => $v['amount'],
			// 		"invoice_id" => $this->post('invoiceNumber')
			// 	); 
			// }

			// $this->billItems->insert_many($items);
			// $itemQuery = $this->billItems->get_many_by(array("bill_id"=>$bill['id']));
			
			// if(count($itemQuery) > 0) {
				$this->response(array("type" => $this->post('type'), "bill"=>$this->bill->get($bill['id'])), 201);
			// } else {
			// 	$this->response(array("status"=>"failed", "message"=>"Cannot insert items into database"), 200);
			// }
		} else {
			$this->response(array("status"=>"failed", "message"=>"Cannot insert into database"), 200);
		}
		
	}

	public function bills_put() {
		
	}

	public function bills_delete() {
		
	}

/**********************************
****** Start of Bill Payment ******
**********************************/

	public function bill_payments_get() {
		$filter = $this->get("filter");		
		if(!empty($filter) && isset($filter)){			
			$criteria = array();				
			for ($i = 0; $i < count($filter['filters']); ++$i) {				
				$criteria += array($filter['filters'][$i]['field'] => $filter['filters'][$i]['value']);
			}
			// $this->response($para, 200);
			$query = $this->bill_payment->get_many_by($criteria);
		} else {
			$query = $this->bill_payment->get_all();
		}

		if(count($query) > "0") :
			foreach($query as $row) {
				$data[] = array(
					"id" 		=> $row->id,
					"bill_id" 	=> $row->bill_id,
					"bills" 	=> $this->journal->get($row->bill_id),
					"payment_id"=> $row->payment_id,
					"date"		=> $row->date,
					"amount_paid"=> $row->amount_paid,
					"created_at"=> $row->created_at
				);
			}
			$this->response(array("status"=>"OK", "message"=>"Data found ".count($data), "results"=>$data), 200);
		else :
			$this->response(array("status"=>"Error", "message"=>$this->db->_error_message(), "results"=>array()), 200);
		endif;
	}

	public function bill_payments_post() {
		$arrayData = $this->post();
		foreach($arrayData as $key => $value) {
			$data[] = $value;
		}
		$ids[] = $this->bill_payment->insert_many($data);
		
		
		if(count($ids) > 0) {
			//Update Bill if amount due = 0
			$bill_Ids = array();
			foreach($data as $r) {
				//get billed amount
				$journal = $this->journal->get($r['bill_id']);

				//get paid amount
				$paid_amount = $this->bill_payment->amount_paid($r['bill_id']);
				if($journal->amount_billed == $paid_amount) {
					$updated = $this->journal->update($r['bill_id'], array('amount_paid'=>$paid_amount, 'amount_due'=>$journal->amount_billed-$paid_amount,'status'=>1));
				} else {
					$this->journal->update($r['bill_id'], array('amount_paid'=>$paid_amount, 'amount_due'=>$journal->amount_billed-$paid_amount));
				}
			}
			//$this->bill->update_many($bill_Ids, array('status'=>1));
			//$this->response($data, 200);
			// $this->response(array("status"=>"Successful", "billed"=>$journal->amount_billed), 200);
		} else {
			//$this->response(array("status"=>"error", "message"=>"You passed empty fields"), 400);
		}	
	}

	public function bill_payments_put() {

	}

	public function bill_payments_delete() {

	}


	//Customer Report
	public function customers_get() {
		$data['segment'] = array(
			"0" => array("type"=>"ធម្មតា", "number" => $this->people->count_by("people_type_id",3)),
			"1" => array("type"=>"ពាណិជ្ជកម្ម", "number" => $this->people->count_by("people_type_id",4)),
			"2"	=> array("type"=>"បរទេស", "number" => $this->people->count_by("people_type_id",5)),
			"3" => array("type"=>"រដ្ឋ", "number" => $this->people->count_by("people_type_id",6))
		);
		$data['energyUsed'] = $this->meterRecords->get_all();

		$this->response($data, 200);
	}

	//distribution areas
	public function distributionAreas_get() {
		//do something
		$class = $this->get('class_id');
		//if($class != 0 || isset($class)) {
		//	$query = $this->distributionAreas->get_many_by("class_id", $class);
		//} else {
			$query = $this->distributionAreas->get_all();
		//}

		if(count($query)>0) {
			foreach($query as $result) {
				$data[] = array(
					"id" => $result->id,
					"class" => $this->class->get($result->class_id),
					"commune" => $result->commune,
					"village" => $result->village,
					"total_families" => $result->total_families,
					"family_has_electricity" => $result->family_has_electricity,
					"use_mv" => $result->use_mv,
					"use_lv" => $result->use_lv,
					"created_at" => $result->created_at,
					"updated_at" => $result->updated_at
				);
			}
			$this->response($data, 200);
		} else {
			$this->response(array("status"=>"error", "message"=>"not found!"), 404);
		}
		
	}

	public function distributionAreas_post() {
		//do something
		$class = $this->post('class');
		$data_posted = array( 
			"class_id" => $class['id'],
			"commune" => $this->post('commune'),
			"village" => $this->post('village'),
			"total_families" => $this->post('total_families'),
			"family_has_electricity" => $this->post('family_has_electricity'),
			"use_mv" => $this->post('use_mv'),
			"use_lv" => $this->post('use_lv')
		);

		$query = $this->distributionAreas->insert($data_posted);

		if($query) {
			$result = $this->distributionAreas->get($query);
			$data[] = array(
					"id" => $result->id,
					"class" => $this->class->get($result->class_id),
					"commune" => $result->commune,
					"village" => $result->village,
					"total_families" => $result->total_families,
					"family_has_electricity" => $result->family_has_electricity,
					"use_mv" => $result->use_mv,
					"use_lv" => $result->use_lv,
					"created_at" => $result->created_at,
					"updated_at" => $result->updated_at
				);
			$this->response($data, 200);
		} else {
			$this->respnose(array("status"=>"error"), 400);
		}
	}

	public function distributionAreas_put() {
		//do something
		$class = $this->put('class');
		$data_posted = array( 
			"class_id" => $class['id'],
			"commune" => $this->put('commune'),
			"village" => $this->put('village'),
			"total_families" => $this->put('total_families'),
			"family_has_electricity" => $this->put('family_has_electricity'),
			"use_mv" => $this->put('use_mv'),
			"use_lv" => $this->put('use_lv')
		);

		$query = $this->distributionAreas->update($this->put('id'), $data_posted);

		if($query) {
			$result = $this->distributionAreas->get($this->put('id'));
			$data[] = array(
					"id" => $result->id,
					"class" => $this->class->get($result->class_id),
					"commune" => $result->commune,
					"village" => $result->village,
					"total_families" => $result->total_families,
					"family_has_electricity" => $result->family_has_electricity,
					"use_mv" => $result->use_mv,
					"use_lv" => $result->use_lv,
					"created_at" => $result->created_at,
					"updated_at" => $result->updated_at
				);
			$this->response($data, 200);
		} else {
			$this->respnose(array("status"=>"error"), 400);
		}
	}

	public function distributionAreas_delete() {
		//do something
		$data_posted = $this->delete('id');

		$query = $this->distributionAreas->delete($data_posted);

		if($query) {
			$this->response(array("status"=>"successfully deleted", "record"=>$this->delete('id')), 200);
		} else {
			$this->respnose(array("status"=>"error"), 400);
		}
	}

	//Generator Section
	public function generators_get() {
		//do something
		$class = $this->get('class_id');
		if($class != 0 || isset($class)) {
			$query = $this->generators->get_many_by("class_id", $class);
		} else {
			$query = $this->generators->get_all();
		}

		if(count($query)>0) {
			$this->response($query, 200);
		} else {
			$this->response(array("status"=>"error"), 404);
		}
		
	}

	public function generators_post() {
		//do something
		$data_posted = $this->post();

		$query = $this->generators->insert($data_posted);

		if($query) {
			$this->response($this->generators->get($query), 200);
		} else {
			$this->respnose(array("status"=>"error"), 400);
		}
	}

	public function generators_put() {
		//do something
		$data_posted = $this->put();

		$query = $this->generators->update($this->put('id'), $data_posted);

		if($query) {
			$this->response($this->generators->get($this->put('id')), 200);
		} else {
			$this->respnose(array("status"=>"error"), 400);
		}
	}

	public function generators_delete() {
		//do something
		$data_posted = $this->delete('id');

		$query = $this->generators->delete($data_posted);

		if($query) {
			$this->response(array("status"=>"successfully deleted", "record"=>$this->delete('id')), 200);
		} else {
			$this->respnose(array("status"=>"error"), 400);
		}
	}

	//generator records
	public function generator_records_get() {
		//do something
		//$class = $this->get('class_id');
		//if($class != 0 || isset($class)) {
		//	$query = $this->generatorRecords->get_many_by("class_id", $class);
		//} else {
			$query = $this->generatorRecords->get_all();
		//}

		if(count($query)>0) {
			foreach( $query as $r ) {
				$data = array(
					"generator" => $this->generators->get($r->generator_id),
					"productionDate" => $r->production_date,
					"energyProduced" => $r->energy_produced,
					"energyInHouseUsed" => $r->energy_used_within,
					"fuelUsed" => $r->fuel_used,
					"lubUsed" => $r->lubricant_used,
					"dateCreated" => $r->created_at,
					"dateUpdated" => $r->updated_at
				);
			}
			$this->response($data, 200);
		} else {
			$this->response(array("status"=>"error"), 404);
		}
		
	}

	public function generator_records_post() {
		//do something
		$data_posted = $this->post();

		$query = $this->generatorRecords->insert($data_posted);

		if($query) {
			$result = $this->generatorRecords->get($query);
			$data = array(
					"generator" => $this->generators->get($result->generator_id),
					"productionDate" => $result->production_date,
					"energyProduced" => $result->energy_produced,
					"energyInHouseUsed" => $result->energy_used_within,
					"fuelUsed" => $result->fuel_used,
					"lubUsed" => $result->lubricant_used,
					"dateCreated" => $result->created_at,
					"dateUpdated" => $result->updated_at
				);
			$this->response($data, 200);
		} else {
			$this->respnose(array("status"=>"error"), 400);
		}
	}

	public function generator_records_put() {
		//do something
		$data_posted = $this->put();

		$query = $this->generatorRecords->update($this->put('id'), $data_posted);

		if($query) {
			$this->response($this->generatorRecords->get($this->put('id')), 200);
		} else {
			$this->respnose(array("status"=>"error"), 400);
		}
	}

	public function generator_records_delete() {
		//do something
		$data_posted = $this->delete('id');

		$query = $this->generatorRecords->delete($data_posted);

		if($query) {
			$this->response(array("status"=>"successfully deleted", "record"=>$this->delete('id')), 200);
		} else {
			$this->respnose(array("status"=>"error"), 400);
		}
	}

	public function consumer_usages_get() {
		$query = $this->meterRecords->get_all();

		// if( count($query) > 0 ) {
		// 	foreach($query as $record) {
		// 		$data[] = array(

		// 		);
		// 	}
		// }
	}

	public function v4($trim = false) {        
        $format = ($trim == false) ? '%04x%04x-%04x-%04x-%04x-%04x%04x%04x' : '%04x%04x%04x%04x%04x%04x%04x%04x';
    
        return sprintf($format,

                // 32 bits for "time_low"
                mt_rand(0, 0xffff), mt_rand(0, 0xffff),

                // 16 bits for "time_mid"
                mt_rand(0, 0xffff),

                // 16 bits for "time_hi_and_version",
                // four most significant bits holds version number 4
                mt_rand(0, 0x0fff) | 0x4000,

                // 16 bits, 8 bits for "clk_seq_hi_res",
                // 8 bits for "clk_seq_low",
                // two most significant bits holds zero and one for variant DCE1.1
                mt_rand(0, 0x3fff) | 0x8000,

                // 48 bits for "node"
                mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
        );
    }
}

/* End of file electricities.php */
/* Location: ./application/controllers/api/electricities.php */