<?php defined('BASEPATH') OR exit('No direct script access allowed');


require APPPATH.'/libraries/REST_Controller.php';

class Billitems extends REST_Controller {
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
		$data = array();
		$items = new Bill_line(null, $this->_database);
		if(isset($filters)){
			foreach($filters as $f) {
				$items->where($f['field'], $f['value']);
			}
		}
		$items->get_paged($page, $limit);
		foreach($items as $item) {
			$bill = $item->bill->get();
				
			if($bill->type === 'expense') {
				$line = $item->account->get();
				$data[] = array(
					'id'	=> $item->id,
					'number'=> $item->line_no,
					'item' => array(),
					'account' 	=> array(
						'id' => $line->id,
						'name' => $line->name,
						'description' => $line->description
					),
					'bill' 	=> array(
						'id' => $bill->id,
						'type'=> $bill->type,
						'amount' => $bill->amount
					),
					'unit'	=> (int) $item->unit,
					'unitReceipt' => (int) $item->unit_received,
					'rate'	=> (double) $item->rate,
					'amount'=> (double) $item->amount,
					'isTaxed'=>(bool) $item->isTaxed
				);
			} else {
				$line = $item->item->get();
				$data[] = array(
					'id'	=> $item->id,
					'number'=> $item->line_no,
					'item' 	=> array(
						'id' => $line->id,
						'name' => $line->name,
						'description' => $line->description
					),
					'account' => array(),
					'bill' 	=> array(
						'id' => $bill->id,
						'type'=> $bill->type,
						'amount' => $bill->amount
					),
					'unit'	=> (int) $item->unit,
					'unitReceipt' => (int) $item->unit_received,
					'rate'	=> (double) $item->rate,
					'amount'=> (double) $item->amount,
					'isTaxed'=>(bool) $item->isTaxed
				);
			}
		}
		$this->response(array(
			'results' => $data,
			'count' => count($data),
			'code' => 200,
			'msg' => 'results found'
		), 200);
	}
	public function index_post() {
		$request = json_decode($this->post("models"));
		// empty array for storing data to be returned;
		$data = array();
		foreach($request as $r) {
			$item = new Bill_line(null, $this->_database);
			$item->bill_id = $r->bill->id;
			$item->item_id = isset($r->item) ? $r->item->id : 0;
			$item->account_id = isset($r->account) ? $r->account->id: 0;
			// $item->line_no = $r->number;
			$item->unit    = (int) $r->unit;
			// $item->unit_received = (int) $r->unitReceipt;
			$item->rate    = (double) $r->rate;
			$item->amount  = (double) $r->amount;
			$item->isTaxed = $r->isTaxed;
			if($item->save()) {
				$data[] = array(
					'id'	=> $item->id,
					'number'=> $item->line_no,
					'item' 	=> isset($r->item) ? $r->item :  array(),
					'account' => isset($r->account) ? $r->account:  array(),
					'bill' 	=> $r->bill,
					'unit'	=> (int) $item->unit,
					'unitReceipt' => (int) $item->unitReceipt,
					'rate'	=> (double) $item->rate,
					'amount'=> (double) $item->amount,
					'isTaxed'=>(bool) $item->isTaxed
				);
			}
		}
		$this->response(array(
			'results' => $data,
			'count' => count($data),
			'code' => 201,
			'msg' => 'results found'
		), 201);
	}

	public function index_put() {
		$request = json_decode($this->put("models"));
		// empty array for storing data to be returned;
		$data = array();
		foreach($request as $r) {
			$item = new Bill_line(null, $this->_database);
			$item->where('bill_id', $r->bill->id)->get();
			$item->item_id = isset($r->item) ? $r->item->id : 0;
			$item->account_id = isset($r->account) ? $r->account->id: 0;
			// $item->line_no = $r->number;
			$item->unit    = (int) $r->unit;
			$item->unit_received = (int) $r->unitReceipt;
			$item->rate    = (double) $r->rate;
			$item->amount  = (double) $r->amount;
			$item->isTaxed = $r->isTaxed;
			if($item->save()) {
				$data[] = array(
					'id'	=> $item->id,
					// 'number'=> $item->line_no,
					'item' 	=> isset($r->item) ? $r->item :  array(),
					'account' => isset($r->account) ? $r->account:  array(),
					'bill' 	=> $r->bill,
					'unit'	=> (int) $item->unit,
					'rate'	=> (double) $item->rate,
					'amount'=> (double) $item->amount,
					'isTaxed'=>(bool) $item->isTaxed
				);
			}
		}
		$this->response(array(
			'results' => $data,
			'count' => count($data),
			'code' => 201,
			'msg' => 'results found'
		), 201);
	}

	public function index_delete() {
		$request = json_decode($this->delete("models"));
		// empty array for storing data to be returned;
		$data = array();
		foreach($request as $r) {
			$item = new Bill_line(null, $this->_database);
			$item->where('bill_id', $r->bill->id)->get();
			$item->deleted = 'true';
			if($item->save()) {
				$data[] = array(
					'id'	=> $item->id,
					// 'number'=> $item->line_no,
					'item' 	=> $r->item,
					'account' => $r->account,
					'bill' 	=> $r->bill,
					'unit'	=> (int) $item->unit,
					'rate'	=> (double) $item->rate,
					'amount'=> (double) $item->amount,
					'isTaxed'=>(bool) $item->isTaxed
				);
			}
		}
		$this->response(array(
			'results' => $data,
			'count' => count($data),
			'code' => 200,
			'msg' => 'item has moved/deleted permanatly.'
		), 200);
	}
}
//End Of Class