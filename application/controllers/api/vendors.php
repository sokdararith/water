<?php defined('BASEPATH') OR exit('No direct script access allowed');


require APPPATH.'/libraries/REST_Controller.php';

class Vendors extends REST_Controller {
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
		 
	public function index_get() {
		$requested_data = $this->get('filter');
		$filters = $requested_data['filters'];
		$limit = $this->get('limit') !== false ? $this->get('limit') : 100;
		$page = $this->get('page') !== false ? $this->get('page') : 1;
		$data = array();

		$types = new Contact_type(null, $this->entity);
		$types->where('parent_id', 2)->get_iterated();

		foreach($types as $type) {
			$typeIds[] = $type->id;
		}
		
		$vendors = new Contact(null, $this->entity);
		$vendors->where_in('contact_type_id', $typeIds);
		if(isset($filters)) {
			foreach($filters as $f) {
				if($f['operator'] === 'or') {
					$vendors->or_like($f['field'], $f['value'], 'before');
				} elseif($f['operator'] === 'and') {
					$vendors->where($f['field'], $f['value']);
				} elseif($f['operator'] === 'like'){
					$vendors->like($f['field'], $f['value'], 'before');
				}else {
					$vendors->like($f['field'], $f['value'], 'before');
				}	
			}
			$this->benchmark->mark('benchmark_start');
			$vendors->get_paged($page, $limit);
		} else {
			$this->benchmark->mark('benchmark_start');
			$vendors->where('deleted', 'false');
			$vendors->get_paged($page, $limit);
		}
		foreach($vendors as $row) {
			$row->contact_type->get();
			// $row->account->include_join_fields()->get();
			$row->business_type->get();
			$row->currency->get();
			$row->payment_main->get();
			$row->payment_second->get();
			$row->bank->get();
			$payment_term = new Payment_term(null, $this->entity);
			$payment_term->where('id', $row->payment_term_id)->get();
			$ap = $row->contact_account->get();
			$prepaid = $row->deposit_account->get();;
			$purchaseDiscount =$row->discount_account->get();;
			// foreach($row->account as $ac) {
			// 	if($ac->join_relation==='payable') {
			// 		$ap = array('id'=>$ac->id,'code'=>$ac->code,'name'=>$ac->name);
			// 	} elseif ($ac->join_relation==='prepayment') {
			// 		$prepaid = array('id'=>$ac->id,'code'=>$ac->code,'name'=>$ac->name);
			// 	} elseif ($ac->join_relation==='purchase discount') {
			// 		$purchaseDiscount = array('id'=>$ac->id,'code'=>$ac->code,'name'=>$ac->name);
			// 	}
			// }
			$data[] = array(
				'id' => $row->id,
				'company' => $row->company,
				'company_en' => $row->company_en,
				'bank' => array('id'=>$row->bank->id, 'name' => $row->bank->name, 'swift_code'=>$row->bank->swift_code),
				'bank_account_number' => $row->bank_account_number,
				'bank_account_name' => $row->bank_account_name,
				'bank_address' => $row->bank_address,
				'name_on_cheque'=> $row->name_on_cheque,
				'phone' => $row->phone,
				'email' => $row->email,
				'website' => $row->website,
				'address' => $row->address,
				'is_local' => $row->is_local === 'true' ? true:false,
				'credit_limit' => floatval($row->credit_limit),
				'business_type' => array('id'=>$row->business_type->id, 'type'=>$row->business_type->type),
				'vat_no' => $row->vat_no,
				'payment_term' => array('id' => $payment_term->id, 'name' => $payment_term->name, 'term'=>$payment_term->term, 'discount_percentage'=>$payment_term->discount_percentage),
				// 'image_url' => $row->image_url,
				// 'memo' => $row->memo,
				'payment_main' => array('id'=>$row->payment_main->id,'name'=>$row->payment_main->name),
				'payment_second' => array('id'=>$row->payment_second->id,'name'=>$row->payment_second->name),
				'ap'=> array('id'=>$ap->id, 'name'=>$ap->name),
				'prepaid' => array('id'=>$prepaid->id),
				'purchaseDiscount' => array('id'=>$purchaseDiscount->id),
				'currency' => array(
					'id' => $row->currency->id,
					'code'=> $row->currency->code,
					'locale'=> $row->currency->locale,
					'rate' => $row->currency->rate
				),
				'type' => array(
					'id' => $row->contact_type->id,
					'name' => $row->contact_type->name,
					'parent_type' => $row->contact_type->parent_id
				),
				'latitute' => $row->latitute,
				'longtitute' => $row->longtitute,
				'created_at' => $row->created_at
			);
		}
		if(count($data) > 0) {
			$this->benchmark->mark('benchmark_end');
			$this->response(array('results'=>$data, 'msg' => 'result found', 'count'=>$vendors->paged->total_rows, 'generatedIn'=>$this->benchmark->elapsed_time('benchmark_start', 'benchmark_end')), 200);
		} else {
			$this->response(array('error'=>'no result.', 'msg' => 'no result found'), 200);
		}
	}

	public function index_post() {
		$requested_data = json_decode($this->post('models'));
		$data = array();
		$this->benchmark->mark('benchmark_start');
		foreach($requested_data as $res) {
			$vendor = new Contact(null, $this->entity);
			$vendor->where('company', $res->company)->get();
			if(!$vendor->exists()) {
				$vendor->company 		= $res->company;
				$vendor->company_en 	= $res->company_en;
				$vendor->contact_type_id= $res->type->id;
				$vendor->website		= $res->website;
				$vendor->vat_no 		= $res->vat_no;
				$vendor->phone 			= $res->phone;
				$vendor->address 		= $res->address;
				$vendor->email 			= $res->email;
				$vendor->business_type_id= $res->business_type === null ? '' : $res->business_type->id;
				$vendor->is_local		= $res->is_local;
				$vendor->payment_main_id=$res->payment_main === null ? '' :$res->payment_main->id;
				$vendor->payment_second_id = $res->payment_second === null ? '' : $res->payment_second->id;
				$vendor->currency_id	= $res->currency->id;
				$vendor->payment_term_id= $res->payment_term === null ? $res->payment_term : $res->payment_term->id;
				$vendor->credit_limit 	= floatval($res->credit_limit);
				$vendor->name_on_cheque = $res->name_on_cheque;
				$vendor->bank_id		= $res->bank === null ? $res->bank : $res->bank->id;
				$vendor->bank_account_number = $res->bank_account_number;
				$vendor->bank_account_name = $res->bank_account_name;
				$vendor->bank_address 	= $res->bank_address;
				$vendor->contact_account_id= $res->ap->id;
				$vendor->deposit_account_id= $res->prepaid->id;
				$vendor->discount_account_id= $res->purchaseDiscount->id;
				$vendor->latitute = $res->latitute;
				$vendor->longtitute = $res->longtitute;
				if($vendor->save()) {
					$vendor->payment_main->get();
					$vendor->payment_second->get();
					$data[] = array(
						'id' 			=> $vendor->id,
						'company' 		=> $vendor->company,
						'company_en' 	=> $vendor->company_en,
						'type' 			=> $vendor->type,
						'website'		=> $vendor->website,
						'vat_no' 		=> $vendor->vat_no,
						'phone' 		=> $vendor->phone,
						'address' 		=> $vendor->address,
						'email' 		=> $vendor->email,
						'business_type' => $res->business_type,
						'is_local'		=> boolval($vendor->is_local),
						'payment_main' => array('id'=>$vendor->payment_main->id,'name'=>$vendor->payment_main->name),
						'payment_second' => array('id'=>$vendor->payment_second->id,'name'=>$vendor->payment_second->name),
						'currency' 		=> $res->currency,
						'payment_term' 	=> $res->payment_term,
						'ap' 			=> $res->ap,
						'prepaid'		=> $res->prepaid,
						'purchaseDiscount'=>$res->purchaseDiscount,
						'credit_limit' 	=> floatval($vendor->credit_limit),
						'name_on_cheque'=> $vendor->name_on_cheque,
						'bank'			=> $res->bank,
						'bank_account_number' => $vendor->bank_account_number,
						'bank_account_name' => $vendor->bank_account_name,
						'bank_address' => $vendor->bank_address,
						'latitute' => $vendor->latitute,
						'longtitute' => $vendor->longtitute,
						'created_at' => $vendor->created_at
					);
				} else {
					$this->response(array('error'=>TRUE, 'results'=>array(), 'msg' => 'error creating', 'count'=>1, 'generatedIn'=>$this->benchmark->elapsed_time('benchmark_start', 'benchmark_end')), 200);
				}
			} else {
				$this->response(array('error'=>TRUE,'results'=>array(), 'msg' => 'already existed', 'count'=>1, 'generatedIn'=>$this->benchmark->elapsed_time('benchmark_start', 'benchmark_end')), 200);
			}
		}
		
		$this->benchmark->mark('benchmark_end');
		if(count($data) > 0) {
			$this->response(array('error'=>FALSE,'results'=>$data, 'msg' => 'result found', 'count'=>count($data), 'generatedIn'=>$this->benchmark->elapsed_time('benchmark_start', 'benchmark_end')), 201);
		} else {
			$this->response(array('error'=>TRUE,'results'=>array(), 'msg' => 'no result found', 'count'=>0, 'generatedIn'=>$this->benchmark->elapsed_time('benchmark_start', 'benchmark_end')), 200);
		}
	}

	public function index_put() {
		$requested_data = json_decode($this->put('models'));
		$data = array();
		$this->benchmark->mark('benchmark_start');
		foreach($requested_data as $res) {
			$vendor = new Contact(null, $this->entity);
			$vendor->where('id', $res->id)->get();
			$vendor->company 		= $res->company;
			$vendor->company_en 	= $res->company_en;
			$vendor->contact_type_id= $res->type === null ? $res->type: $res->type->id;
			$vendor->website		= $res->website;
			$vendor->vat_no 		= $res->vat_no;
			$vendor->phone 			= $res->phone;
			$vendor->address 		= $res->address;
			$vendor->email 			= $res->email;
			$vendor->business_type_id= $res->business_type === null ? $res->business_type : $res->business_type->id;
			$vendor->is_local		= $res->is_local === true? 'true':'false';
			$vendor->payment_main  	=$res->payment_main == null ? $res->payment_main : $res->payment_main->id;
			$vendor->payment_second = $res->payment_second !== null ? $res->payment_second : $res->payment_second->id;
			$vendor->currency_id	= $res->currency === null ? $res->currency : $res->currency->id;
			$vendor->payment_term_id= $res->payment_term === null ? $res->payment_term : $res->payment_term->id;
			$vendor->credit_limit 	= floatval($res->credit_limit);
			$vendor->name_on_cheque = $res->name_on_cheque;
			$vendor->bank_id		= $res->bank === null ? $res->bank : $res->bank->id;
			$vendor->bank_account_number = $res->bank_account_number;
			$vendor->bank_account_name = $res->bank_account_name;
			$vendor->contact_account_id= $res->ap->id;
			$vendor->deposit_account_id= $res->prepaid->id;
			$vendor->discount_account_id= $res->purchaseDiscount->id;
			$vendor->latitute = $res->latitute;
			$vendor->longtitute = $res->longtitute;
			$vendor->bank_address 	= $res->bank_address;
			if($vendor->save()) {
				$data[] = array(
					'id' 			=> $vendor->id,
					'company' 		=> $vendor->company,
					'company_en' 	=> $vendor->company_en,
					'type' 			=> $res->type,
					'website'		=> $vendor->website,
					'vat_no' 		=> $vendor->vat_no,
					'phone' 		=> $vendor->phone,
					'address' 		=> $vendor->address,
					'email' 		=> $vendor->email,
					'business_type' => $res->business_type,
					'is_local'		=> boolval($vendor->is_local),
					'payment_main' => $res->payment_main,
					'payment_second' => $res->payment_second,
					'currency' 		=> $res->currency,
					'payment_term' 	=> $res->payment_term,
					'ap' 			=> $res->ap,
					'prepaid'		=> $res->prepaid,
					'purchaseDiscount'=>$res->purchaseDiscount,
					'credit_limit' 	=> $vendor->credit_limit,
					'name_on_cheque'=> $vendor->name_on_cheque,
					'bank'			=> $res->bank,
					'bank_account_number' => $vendor->bank_account_number,
					'bank_account_name' => $vendor->bank_account_name,
					'bank_address' => $vendor->bank_address,
					'latitute' => $vendor->latitute,
					'longtitute' => $vendor->longtitute,
					'created_at' => $vendor->created_at
				);
			}
		}
		
		$this->benchmark->mark('benchmark_end');
		if(count($data) > 0) {
			$this->response(array('results'=>$data, 'msg' => 'result found', 'count'=>count($data), 'generatedIn'=>$this->benchmark->elapsed_time('benchmark_start', 'benchmark_end')), 201);
		} else {
			$this->response(array('results'=>array(), 'msg' => 'no result found', 'count'=>0, 'generatedIn'=>$this->benchmark->elapsed_time('benchmark_start', 'benchmark_end')), 200);
		}
	}

	public function index_delete() {
		$requested_data = json_decode($this->delete('models'));
		$data = array();
		$this->benchmark->mark('benchmark_start');
		foreach($requested_data as $res) {
			$vendor = new Contact(null, $this->entity);
			$vendor->where('id', $res->id)->get();
			$vendor->deleted = 'true';

			if($vendor->save()) {
				$data[] = array(
					'id' 			=> $vendor->id,
					'company' 		=> $vendor->company,
					'company_en' 	=> $vendor->company_en,
					'type' 			=> $vendor->type,
					'website'		=> $vendor->website,
					'vat_no' 		=> $vendor->vat_no,
					'phone' 		=> $vendor->phone,
					'address' 		=> $vendor->address,
					'email' 		=> $vendor->email,
					'business_type' => $res->business_type,
					'is_local'		=> $vendor->is_local,
					'payment_main'  => $vendor->payment_main,
					'payment_second'=> $vendor->payment_second,
					'currency' 		=> $res->currency,
					'payment_term' 	=> $res->payment_term,
					'ap' 			=> $res->ap,
					'prepaid'		=> $res->prepaid,
					'purchaseDiscount'=>$res->purchaseDiscount,
					'credit_limit' 	=> $vendor->credit_limit,
					'name_on_cheque'=> $vendor->name_on_cheque,
					'bank'			=> $res->bank,
					'bank_account_number' => $vendor->bank_account_number,
					'bank_account_name' => $vendor->bank_account_name,
					'bank_address' => $vendor->bank_address
				);
			}
		}
		$this->benchmark->mark('benchmark_end');
		if(count($data) > 0) {
			$this->response(array('results'=>$data, 'msg' => count($data).' record(s) deleted.', 'count'=>count($data), 'generatedIn'=>$this->benchmark->elapsed_time('benchmark_start', 'benchmark_end')), 201);
		} else {
			$this->response(array('error'=>'no result.', 'msg' => 'no result found', 'generatedIn'=>$this->benchmark->elapsed_time('benchmark_start', 'benchmark_end')), 200);
		}
	}

	public function bills_get() {
		$requested_data = $this->get('filter');
		$filters = $requested_data['filters'];
		$limit = $this->get('limit') !== false ? $this->get('limit') : 100;
		$page = $this->get('page') !== false ? $this->get('page') : 1;
		$data = array();

		$bills = new Bill(null, $this->entity);
		$bills->where_related_vendor('id', $filters[0]['value']);
		$bills->where('deleted', 'false')->get_iterated();
		foreach($bills as $bill) {
			$data[] = array(
				'id' => $bill->id,
				'type' => $bill->type,
				'due_date' => $bill->due_date,
				'amount' => floatval($bill->amount),
				'expected_date' => $bill->expected_date
			);
		}
		$this->response(array('results'=>$data), 200);
	}

	// vendors phone number based on vendor ID
	public function phones_get() {
		$requested_data = $this->get('filter');
		$filters = $requested_data['filters'];
		$limit = $this->get('limit') !== false ? $this->get('limit') : 100;
		$page = $this->get('page') !== false ? $this->get('page') : 1;
		$data = array();
		
		$phones = new Phone(null, $this->entity);
		if(isset($filters)){
			foreach($filters as $f) {
				$phones->where($f['field'], $f['value']);
			}
			$this->benchmark->mark('benchmark_start');
			$phones->get();
			if($phones->exists()) {
				foreach($phones as $phone) {	
					$data[] = array(
						'id' => $phone->id,
						'contact_id' => $phone->contact_id,
						'phone' => $phone->phone,
						'name' => $phone->name,
						'department' => $phone->department,
						'type' => $phone->type
					);
				}				
			}
			if(count($data) > 0) {
				$this->benchmark->mark('benchmark_end');
				$this->response(array('results'=>$data, 'msg' => 'result found', 'count'=> count($data), 'generatedIn'=>$this->benchmark->elapsed_time('benchmark_start', 'benchmark_end')), 200);
			} else {
				$this->response(array('results'=>array(), 'msg' => 'no result found', 'count'=>0), 200);
			}
		} else {
			$this->response(array('results'=>array(), 'msg' => 'no result found', 'count'=>0), 200);
		}
	}
	public function phones_post() {
		$requested_data = json_decode($this->post('models'));
		$data = array();
		$this->benchmark->mark('benchmark_start');
		foreach($requested_data as $res) {
			$phone = new Phone(null, $this->entity);
			$phone->contact_id = $res->contact_id;
			$phone->phone = $res->phone;
			$phone->type = $res->type;
			$phone->department = $res->department;
			$phone->name = $res->name;
			if($phone->save()) {
				$data[] = array(
					'id' => $phone->id,
					'contact_id' => $phone->contact_id,
					'phone' => $phone->phone,
					'name' => $phone->name,
					'department' => $phone->department,
					'type' => $phone->type
				); 
			}
		}
		if(count($data) > 0) {
			$this->benchmark->mark('benchmark_end');
			$this->response(array('results'=>$data, 'msg' => 'result found', 'count'=> count($data), 'generatedIn'=>$this->benchmark->elapsed_time('benchmark_start', 'benchmark_end')), 201);
		} else {
			$this->response(array('results'=>array(), 'msg' => 'no result found', 'count'=>0), 200);
		}
	}
	public function phones_put() {
		$requested_data = json_decode($this->put('models'));
		$data = array();
		$this->benchmark->mark('benchmark_start');
		foreach($requested_data as $res) {
			$phone = new Phone(null, $this->entity);
			$phone->where('id', $res->id)->get();
			$phone->contact_id = $res->contact_id;
			$phone->phone = $res->phone;
			$phone->type = $res->type;
			$phone->department = $res->department;
			$phone->name = $res->name;
			if($phone->save()) {
				$data[] = array(
					'id' => $phone->id,
					'contact_id' => $phone->contact_id,
					'phone' => $phone->phone,
					'name' => $phone->name,
					'department' => $phone->department,
					'type' => $phone->type
				); 
			}
		}
		if(count($data) > 0) {
			$this->benchmark->mark('benchmark_end');
			$this->response(array('results'=>$data, 'msg' => 'result found', 'count'=> count($data), 'generatedIn'=>$this->benchmark->elapsed_time('benchmark_start', 'benchmark_end')), 200);
		} else {
			$this->response(array('results'=>array(), 'msg' => 'no result found', 'count'=>0), 200);
		}
	}
	public function phones_delete() {
		$requested_data = json_decode($this->delete('models'));
		$data = array();
		$this->benchmark->mark('benchmark_start');
		foreach($requested_data as $res) {
			$phone = new Phone(null, $this->entity);
			$phone->where('id', $res->id)->get();
			
			if($phone->exists()) {
				$phone->delete();
				$data[] = array(
					'id' => $res->id,
					'contact_id' => $res->contact_id,
					'phone' => $res->phone,
					'name' => $res->name,
					'department' => $res->department,
					'type' => $res->type
				); 
			}
		}
		if(count($data) > 0) {
			$this->benchmark->mark('benchmark_end');
			$this->response(array('results'=>$data, 'msg' => 'deleted', 'count'=> count($data), 'generatedIn'=>$this->benchmark->elapsed_time('benchmark_start', 'benchmark_end')), 200);
		} else {
			$this->response(array('results'=>array(), 'msg' => 'no result found', 'count'=>0), 200);
		}
	}
	public function types_get() {
 		$requested_data = $this->get('filter');
		$filters = $requested_data['filters'];
		$limit = $this->get('limit') !== false ? $this->get('limit') : 100;
		$page = $this->get('page') !== false ? $this->get('page') : 1;
		$data = array();
		
		$vendors = new Contact_type(null, $this->entity);
		$vendors->where('parent_id', 2);
		if(isset($filters)) {
			foreach($filters as $f) {
				if($f['operator'] === 'or') {
					$vendors->or_like($f['field'], $f['value'], 'before');
				} elseif($f['operator'] === 'and') {
					$vendors->where($f['field'], $f['value']);
				} else {
					$vendors->like($f['field'], $f['value'], 'before');
				}
				
			}
			$this->benchmark->mark('benchmark_start');
			$vendors->get_paged($page, $limit);
			foreach($vendors as $row) {
				$data[] = array(
					'id' => $row->id,
					'name' => $row->name
				);
			}
			if(count($data) > 0) {
				$this->benchmark->mark('benchmark_end');
				$this->response(array('results'=>$data, 'msg' => 'result found', 'count'=>$vendors->paged->total_rows, 'generatedIn'=>$this->benchmark->elapsed_time('benchmark_start', 'benchmark_end')), 200);
			} else {
				$this->response(array('error'=>'no criteria.', 'msg' => 'no result found'), 200);
			}
		} else {
			$this->benchmark->mark('benchmark_start');
			$vendors->get_paged($page, $limit);
			foreach($vendors as $row) {
				$data[] = array(
					'id' => $row->id,
					'name' => $row->name
				);
			}
			if(count($data) > 0) {
				$this->benchmark->mark('benchmark_end');
				$this->response(array('results'=>$data, 'msg' => 'result found', 'count'=>$vendors->paged->total_rows, 'generatedIn'=>$this->benchmark->elapsed_time('benchmark_start', 'benchmark_end')), 200);
			} else {
				$this->response(array('error'=>'no result.', 'msg' => 'no result found'), 200);
			}
		}
	}

	public function paymentMethods_get() {
		$requested_data = $this->get('filter');
		$filters = $requested_data['filters'];
		$limit = $this->get('limit') !== false ? $this->get('limit') : 100;
		$page = $this->get('page') !== false ? $this->get('page') : 1;
		$data = array();
		
		$pmtMethod = new Payment_method(null, $this->entity);
		if(isset($filters)) {
			foreach($filters as $f) {
				if($f['operator'] === 'or') {
					$vendors->or_like($f['field'], $f['value'], 'before');
				} elseif($f['operator'] === 'and') {
					$vendors->where($f['field'], $f['value']);
				} else {
					$vendors->like($f['field'], $f['value'], 'before');
				}
				
			}
			$this->benchmark->mark('benchmark_start');
			$pmtMethod->get_paged($page, $limit);
			foreach($pmtMethod as $row) {
				$data[] = array(
					'id' => $row->id,
					'name' => $row->name,
					'description' => $row->description
				);
			}
			if(count($data) > 0) {
				$this->benchmark->mark('benchmark_end');
				$this->response(array('results'=>$data, 'msg' => 'result found', 'count'=>$pmtMethod->paged->total_rows, 'generatedIn'=>$this->benchmark->elapsed_time('benchmark_start', 'benchmark_end')), 200);
			} else {
				$this->response(array('error'=>'no criteria.', 'msg' => 'no result found'), 200);
			}
		} else {
			$this->benchmark->mark('benchmark_start');
			$pmtMethod->get_paged($page, $limit);
			foreach($pmtMethod as $row) {
				$data[] = array(
					'id' => $row->id,
					'name' => $row->name,
					'description' => $row->description
				);
			}
			if(count($data) > 0) {
				$this->benchmark->mark('benchmark_end');
				$this->response(array('results'=>$data, 'msg' => 'result found', 'count'=>$pmtMethod->paged->total_rows, 'generatedIn'=>$this->benchmark->elapsed_time('benchmark_start', 'benchmark_end')), 200);
			} else {
				$this->response(array('error'=>'no result.', 'msg' => 'no result found'), 200);
			}
		}
	}
}//End Of Class