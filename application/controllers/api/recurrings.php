<?php defined('BASEPATH') OR exit('No direct script access allowed');


require APPPATH.'/libraries/REST_Controller.php';

class Recurrings extends REST_Controller {
	
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
		$this->benchmark->mark('benchmark_start');
		$recurrings = new Recurring(null, $this->_database);
		if(isset($filters)) {
			foreach($filters as $filter) {
				$recurrings->where($filter['field'], $filter['value']);
			}
		}
		$recurrings->get_paged($page, $limit);

		if($recurrings->exists()) {
			foreach($recurrings as $recurring) {
				$items = $recurring->item->get_raw();
				$data[] = array(
					'id' => $recurring->id,
					'name' => $recurring->name,
					'type' => $recurring->type,
					'date' => $recurring->date,
					'recurring_number' => $recurring->recurring_number,
					'items' => $items->result()
				);
			}
			$this->benchmark->mark('benchmark_end');
			$this->response(array('results'=>$data, 'error'=>FALSE, 'msg' => 'result found', 'count'=>$recurrings->paged->total_rows, 'generatedIn'=>$this->benchmark->elapsed_time('benchmark_start', 'benchmark_end')), 200);
		} else {
			$this->response(array('results'=>array(), 'error'=>TRUE, 'msg' => 'no result found', 'count'=>$recurrings->paged->total_rows, 'generatedIn'=>$this->benchmark->elapsed_time('benchmark_start', 'benchmark_end'), 'errorCode'=> 404), 200);
		}
	}

	public function index_post() {
		$requested_data = json_decode($this->post('models'));
		$data = array();
		$this->benchmark->mark('benchmark_start');
		
		foreach($requested_data as $row) {
			$date = new DateTime($row->date);
			$recurrings = new Recurring(null, $this->_database);
			$recurrings->name = $row->name;
			$recurrings->type = $row->type;
			$recurrings->date = $date->format('d-m');
			$recurrings->recurring_number = $row->recurring_number->id;
			if($recurrings->save()) {
				$recItems = array();
				foreach($row->items as $item) {
					$recurringItems = new Recurringitem(null, $this->_database);
					$recurringItems->recurring_id = $recurrings->id;
					$recurringItems->item_id = $item->item->id;
					$recurringItems->contact_id = $item->contact->id;
					$recurringItems->dr = $item->dr;
					$recurringItems->cr = $item->cr;
					if($recurringItems->save()) {
						$recItems[] = array(
							'recurring_id' => $recurringItems->recurring_id,
							'item'	=> $item->item,
							'contact'=> $item->contact,
							'dr'	=> $recurringItems->dr,
							'cr' 	=> $recurringItems->cr
						);
					}
				}
				$data[] = array(
					'id' => $recurrings->id,
					'name' => $recurrings->name,
					'type' => $recurrings->type,
					'date' => $recurrings->date,
					'recurring_number' => $recurrings->recurring_number,
					'items' => $recItems
				);
			}
		}
		$this->benchmark->mark('benchmark_end');
		if(count($data) > 0) {
			$this->response(array('results'=>$data, 'error'=>FALSE, 'msg' => 'result found', 'count'=>count($data), 'generatedIn'=>$this->benchmark->elapsed_time('benchmark_start', 'benchmark_end')), 201);
		} else {
			$this->response(array('results'=>array(), 'error'=>TRUE, 'msg' => 'no result found', 'count'=>0, 'generatedIn'=>$this->benchmark->elapsed_time('benchmark_start', 'benchmark_end')), 200);
		}
	}

	public function index_put() {
		$requested_data = json_decode($this->put('models'));
		$data = array();
		$this->benchmark->mark('benchmark_start');
		
		foreach($requested_data as $row) {
			$recurrings = new Recurring(null, $this->_database);
			$recurrings->where('id', $row->id)->get();
			$recurrings->name = $row->name;
			$recurrings->type = $row->type;
			$recurrings->date = $row->date;
			$recurrings->recurring_number = $row->recurring_number->id;
			if($recurrings->save()) {
				$recItems = array();
				foreach($row->items as $item) {
					$recurringItems = new Recurringitem(null, $this->_database);
					$reccuringItems->where('id', $item->id)->get();
					$recurringItems->recurring_id = $recurrings->id;
					$recurringItems->item_id = $item->item->id;
					$recurringItems->contact_id = $item->contact->id;
					$recurringItems->dr = $item->dr;
					$recurringItems->cr = $item->cr;
					if($recurringItems->save()) {
						$recItems[] = array(
							'recurring_id' => $recurrings->id,
							'item_id'	=> $recurringItems->item_id,
							'contact_id'=> $$recurringItems->contact_id,
							'dr'	=> $recurringItems->dr,
							'cr' 	=> $recurringItems->cr
						);
					}
				}
				$data[] = array(
					'id' => $recurring->id,
					'name' => $recurring->name,
					'type' => $recurring->type,
					'date' => $recurring->date,
					'recurring_number' => $recurring->recurring_number,
					'items' => $recItems
				);
			}
		}
		$this->benchmark->mark('benchmark_end');
		if(count($data) > 0) {
			$this->response(array('results'=>$data, 'error'=>FALSE, 'msg' => 'result found', 'count'=>count($data), 'generatedIn'=>$this->benchmark->elapsed_time('benchmark_start', 'benchmark_end')), 201);
		} else {
			$this->response(array('results'=>array(), 'error'=>TRUE, 'msg' => 'no result found', 'count'=>count($data), 'generatedIn'=>$this->benchmark->elapsed_time('benchmark_start', 'benchmark_end')), 200);
		}
	}

	public function index_delete() {
		$requested_data = json_decode($this->delete('models'));
		$data = array();
		$this->benchmark->mark('benchmark_start');
		
		foreach($requested_data as $row) {
			$recurrings = new Recurring(null, $this->_database);
			$recurrings->where('id', $row->id)->get();
			if($recurrings->delete()) {
				$recurringItems = new Recurringitem(null, $this->_database);
				$recurringItems->where('recurring_id', $row->id)->get();
				if($recurringItems->exists()) {
					$recurringItems->delete();
				}
			}
			$data[] = array('id' => $recurring->id);
		}
		$this->benchmark->mark('benchmark_end');
		if(count($data) > 0) {
			$this->response(array('results'=>$data, 'error'=>FALSE, 'msg' => 'result found', 'count'=>count($data), 'generatedIn'=>$this->benchmark->elapsed_time('benchmark_start', 'benchmark_end')), 200);
		} else {
			$this->response(array('results'=>array(), 'error'=>TRUE, 'msg' => 'no result found', 'count'=>count($data), 'generatedIn'=>$this->benchmark->elapsed_time('benchmark_start', 'benchmark_end')), 200);
		}
	}
	
}