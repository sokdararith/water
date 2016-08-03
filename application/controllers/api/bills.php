<?php defined('BASEPATH') OR exit('No direct script access allowed');


require APPPATH.'/libraries/REST_Controller.php';

class Bills extends REST_Controller {
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
		 
	public function index_get() {
		$requested_data = $this->get('filter');
		$filters = $requested_data['filters'];
		$limit = $this->get('limit') !== false ? $this->get('limit') : 100;
		$page = $this->get('page') !== false ? $this->get('page') : 1;

		$bills = new Bill(null, $this->_database);
		$x = new Bill(null, $this->_database);
		if(isset($filters)) {
			foreach($filters as $f) {
				if(isset($f['operator'])) {
					if($f['operator'] === 'or') {
						$x->or_where($f['field'], $f['value']);
					} else {
						$x->where($f['field'], $f['value']);
					}
					
				}
			}
		}
		$x->where('deleted', 'false');
		// $x->where('created_at >=', date('Y').'-01-01');
		// $x->where('status !=', 'closed');
		$x->get_iterated();
		$po = 0;
		$inv= 0;
		$invO=0;
		$sum = 0;
		foreach($x as $y) {
			if($y->type === 'po') {
				$po++;
			}
			if($y->type === 'expense' || $y->type === 'purchase') {
				$now = date('Y-m-d');
				$inv++;
				if(strtotime($now) > strtotime($y->due_date)) {
					$invO++;
				}
				$pmt = new Payment(null, $this->_database);
				$pmt->select_sum('amount');
				$pmt->where('reference_id', $y->id);
				$pmt->where('deleted', 'false');
				$pmt->or_where('type', 'expense');
				$pmt->or_where('type', 'purchase');
				$pmt->where('type', 'bill')->get();
				$payments = 0;
				if($pmt->exists()) {
					foreach($pmt as $p) {
						$payments += $p->amount;
					}			
				}

				$sum = ($sum + $y->amount) - $payments;
			}
		}
		if(isset($filters)) {
			$this->benchmark->mark('benchmark_start');
			foreach($filters as $f) {
				// if($f['field'] === 'vendor') {
					// $bills->where('vendor_id', 1839);
				// } else {
					if($f['operator'] === 'where_in') {
						$bills->where_in($f['field'], $f['value']);
					} elseif($f['operator'] === 'where_not_in') {
						$bills->where_not_in($f['field'], $f['value']);
					} elseif($f['operator'] === 'like') {
						$bills->like($f['field'], $f['value']);
					} elseif($f['operator'] === 'or_like') {
						$bills->or_like($f['field'], $f['value']);
					} elseif($f['operator'] === 'or_where') {
						$bills->or_where($f['field'], $f['value']);
					} else {
						$bills->where($f["field"], $f['value']);
					}	
				// }
			}
			// $items->include_related('category', null);
		} else {
			// $items->include_related('category', null);
			$this->benchmark->mark('benchmark_start');
			$bills->where('deleted', 'false');
		}
		$bills->get_paged($page, $limit);	
		if($bills->exists()) {
			foreach($bills as $bill) {
				$bill->payment_term->get();
				$pmt = new Payment(null, $this->_database);
				$pmt->select_sum('amount');
				$pmt->where('reference_id', $bill->id);
				$pmt->where('deleted', 'false');
				$pmt->where('type', 'bill')->get();
				$payments = 0;
				$reference = array();
				if($pmt->exists()) {
					foreach($pmt as $p) {
						$payments += $p->amount;
					}			
				}
				$segments = $bill->segmentlist->get();
				if(isset($bill->reference_id)) {
					$ref = new Bill(null, $this->_database);
					$ref->where('id', 179)->get();
					if($ref->exists()) {
						$reference = array(
						'id' => $ref->id,
						'invoice_number' => $ref->invoice_number,
						'voucher' => $ref->voucher);
					}
				}
				$seg = array();
				if($segments->exists()) {
					foreach($segments as $s) {
						$seg[] = array(
							'id' => $s->id,
							'name' => $s->name,
							'code' => $s->code
						);
					}
				}
				$v = $bill->vendor->get();
				if($v->exists()) {
					$locale = $v->currency->get();
 					$vendor = array('id' => $v->id, 'company' => $v->company, 'locale' => $locale->locale);
				} else {
					$vendor = array();
				}
				$account = $bill->account->get();
				$data[] = array(
					'id' => $bill->id,
					'type' => $bill->type,
					'reference' => $reference,
					'account' => array('id' => $account->id, 'code' => $account->code, 'name' => $account->name),
					'invoice_number' => $bill->invoice_number,
					'voucher' => $bill->voucher,
					'amount' => floatval($bill->amount),
					'paid' => floatval($payments),
					'paidCash' => $bill->paidCash === 'true' ? true:false,
					'taxAmount' => $bill->taxAmount,
					'status'	=> $bill->status,
					'due_date' => $bill->due_date,
					'expected_date' => $bill->expected_date,
					'notice'	=> $bill->notice,
					'internal_notice' => $bill->internal_notice,
					'comment' 	=> $bill->comment,
					'segment'   => $seg,
					'address'  	=> $bill->address,
					'delivery_address' => $bill->delivery_address,
					'payment_term' => array('id'=>$bill->payment_term->id, 'name'=>$bill->payment_term->name, 'term'=>$bill->payment_term->term, 'discount_percentage'=>$bill->payment_term->discount_percentage),
					'vendor' => $vendor
				);
			}
			$this->benchmark->mark('benchmark_end');
			$this->response(array('results'=>$data, 
								  'meta'=>array(
								  	'po'=> $po, 
								  	'inv'=> $inv,
								  	'invO' => $invO,
								  	'balance' => $sum
								  ), 
								  'count'=>$bills->paged->total_rows, 
								  'generatedIn'=>$this->benchmark->elapsed_time('benchmark_start', 'benchmark_end')), 200);
		} else {
			$this->response(array('error'=>'no criteria.','results'=>array(),'meta'=>array('po'=>$po,'inv'=>$inv,'invO'=>$invO, 'balance'=> $sum), 'msg' => 'no result found'), 200);
		}							
	}	
	
	public function index_post() {
		$requested_data = json_decode($this->post('models'));
		$data = array();
		$this->benchmark->mark('benchmark_start');
		foreach($requested_data as $bill) {
			$b = new Bill(null, $this->_database);
			$b->type = $bill->type;
			$b->invoice_number = $bill->invoice_number;
			$b->due_date = $bill->due_date;
			$b->expected_date = $bill->expected_date;
			$b->vendor_id = $bill->vendor->id;
			$b->amount = floatval($bill->amount);
			$b->notice = $bill->notice;
			$b->internal_notice = $bill->internal_notice;
			$b->address= $bill->address;
			$b->paidCash = 'false';
			$b->delivery_address = $bill->delivery_address;
			if($b->save()){
				// save classes for bill
				if(count($bill->segment)> 0) {
					foreach($bill->segment as $item) {
						$segItem = new Segmentlist(null, $this->_database);
						$segItem->where('id', $item->id)->get();
						$segItem->save($b);
					}
				}

				$data[] = array(
					'id' =>$b->id,
					'type'=>$b->type,
					'invoice_number' => $bill->invoice_number,
					'due_date' => $b->due_date,
					'expected_date' => $b->expected_date,
					'amount' => floatval($b->amount),
					'address'=> $b->address,
					'delilvery_address' => $b->delivery_address,
					'notice' => $b->notice,
					'internal_notice' => $b->internal_notice,
					'vendor' => array(
						'id' => $bill->vendor->id,
						'company' => $bill->vendor->company
					)
				);
			}
		}
		
		$this->benchmark->mark('benchmark_end');
		if(count($data) > 0) {
			$this->response(array('results'=>$data, 'error'=>FALSE, 'msg' => 'result found', 'count'=>count($data), 'generatedIn'=>$this->benchmark->elapsed_time('benchmark_start', 'benchmark_end')), 201);
		} else {
			$this->response(array('error'=>FALSE, 'msg'=>'no data recorded.', 'count'=>count($data), 'generatedIn'=>$this->benchmark->elapsed_time('benchmark_start', 'benchmark_end')), 200);
		}
	}
	
	public function index_put() {
		$requested_data = json_decode($this->put('models'));
		
		$data = array();
		$this->benchmark->mark('benchmark_start');
		foreach($requested_data as $bill) {
			if($bill->status === 'closed' || $bill->status === 'partial') {
				$old = new Bill(null, $this->_database);
				$old->where('id', $bill->id)->get();
				$old->status = $bill->status;
				$old->save();
				$data[] = array(
					'id' =>$bill->id,
					'type'=>$bill->type,
					'invoice_number' => $bill->invoice_number,
					'due_date' => $bill->due_date,
					'account' => isset($bill->account) ? $bill->account : null,
					'expected_date' => $bill->expected_date,
					'amount' => floatval($bill->amount),
					'status' => $bill->status,
					'notice' => $bill->notice,
					'internal_notice' => $bill->internal_notice,
					'comment'=> $bill->comment,
					'address'=> $bill->address,
					'delilvery_address' => $bill->delivery_address,
					'vendor' => array(
						'id' => $bill->vendor->id,
						'company' => $bill->vendor->company,
					)
				);
			} else {
				$old = new Bill(null, $this->_database);
				$old->where('id', $bill->id)->get();
				$old->status  = 'closed';
				$old->deleted = 'true';
				$old->save();
				$b = new Bill(null, $this->_database);
				$b->invoice_number = $bill->invoice_number;
				$b->type = $bill->type;
				$b->voucher = $bill->voucher;
				$b->account = isset($bill->account) ? $bill->account->id: null;
				$b->due_date = $bill->due_date;
				$b->expected_date = $bill->expected_date;
				$b->vendor_id = $bill->vendor->id;
				$b->notice = $bill->notice;
				$b->internal_notice = $bill->internal_notice;
				$b->comment= $bill->comment;
				$b->address= $bill->address;
				$b->delivery_address = $bill->delivery_address;
				$b->status = $bill->status;
				$b->paidCash = $bill->paidCash === true ? 'true' : 'false';
				$b->payment_term = $bill->payment_term->id !== null ? $bill->payment_term->id : null;
				$b->amount = floatval($bill->amount);
				if($b->save()){
					if(count($bill->segment)> 0) {
						foreach($bill->segment as $item) {
							$segItem = new Segmentlist(null, $this->_database);
							$segItem->where('id', $item->id)->get();
							$segItem->save($b);
							// $data[] = array('id'=>$segItem->id);
						}
					}
					// $vendor = $b->vendor->get();
					$data[] = array(
						'id' =>$b->id,
						'type'=>$b->type,
						'invoice_number' => $bill->invoice_number,
						'due_date' => $b->due_date,
						'account' => $bill->account,
						'expected_date' => $b->expected_date,
						'amount' => floatval($b->amount),
						'status' => $b->status,
						'notice' => $b->notice,
						'internal_notice' => $b->internal_notice,
						'comment'=> $b->comment,
						'address'=> $b->address,
						'delilvery_address' => $b->delivery_address,
						'vendor' => array(
							'id' => $bill->vendor->id,
							'company' => $bill->vendor->company,
						)
					);
				}
			}
		}
		$this->benchmark->mark('benchmark_end');
		if(count($data) > 0) {
			$this->response(array('results'=>$data, 'msg' => 'result found', 'count'=>count($data), 'generatedIn'=>$this->benchmark->elapsed_time('benchmark_start', 'benchmark_end')), 200);
		} else {
			$this->response(array('error'=>array('msg'=>'no data recorded.'), 'count'=>count($data), 'generatedIn'=>$this->benchmark->elapsed_time('benchmark_start', 'benchmark_end')), 200);
		}
	}
	
	public function index_delete() {
		$requested_data = json_decode($this->delete('models'));
		
		$data = array();
		$this->benchmark->mark('benchmark_start');
		foreach($requested_data as $bill) {
			$b = new Bill(null, $this->_database);
			$b->where('id', $bill->id)->get();
			$b->deleted = $bill->deleted;
			if($b->save()){
				$journal = new Journal(null, $this->_database);
				$journal->where('type', 'bill');
				$journal->where('reference', $b->id)->get();
				$entries = $journal->entry->get();

				foreach($entries as $entry) {
					$entry->deleted = 'true';
					$entry->save();
				}
			}

			$vendor = $b->vendor->get();
			$data[] = array(
				'id' =>$b->id,
				'type'=>$b->type,
				'due_date' => $b->due_date,
				'expected_date' => $b->expected_date,
				'amount' => floatval($b->amount),
				'paid'	=> boolval($b->paid),
				'vendor' => array(
					'id' => $bill->vendor->id,
					'name' => $bill->vendor->name,
					'surname' => $bill->vendor->surname
				)
			);
		}
		$this->benchmark->mark('benchmark_end');
		if(count($data) > 0) {
			$this->response(array('results'=>$data, 'msg' => count($data).' bill(s) deleted.', 'count'=>count($data), 'generatedIn'=>$this->benchmark->elapsed_time('benchmark_start', 'benchmark_end')), 301);
		} else {
			$this->response(array('error'=>array('msg'=>'no data recorded.'), 'count'=>count($data), 'generatedIn'=>$this->benchmark->elapsed_time('benchmark_start', 'benchmark_end')), 200);
		}
	}

	function ValueMapper_get() {
		$data =[];
		$this->response(array('results'=>$data), 200);
	}
}//End Of Class