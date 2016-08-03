<?php defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH.'/libraries/REST_Controller.php';

class Employees extends REST_Controller {
	public $entity;
	function __construct() {
		parent::__construct();
		$institute = new Institute();
		$institute->where('id', $this->input->get_request_header('Entity'))->get();
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
		$types->where('parent_id', 3)->get_iterated();

		foreach($types as $type) {
			$typeIds[] = $type->id;
		}

		$employees = new Contact(null, $this->entity);
		$employees->where_in('contact_type_id', array(3));

		$this->benchmark->mark('benchmark_start');
		
		if(isset($filters)) {
			foreach($filters as $f) {
				if(isset($f['operator'])) {
					if($f['operator'] === 'or') {
						$employees->or_like($f['field'], $f['value'], 'before');
					} elseif($f['operator'] === 'and') {
						$employees->where($f['field'], $f['value']);
					} elseif($f['operator'] === 'like'){
						$employees->like($f['field'], $f['value'], 'before');
					}
				} else {
					$employees->where($f['field'], $f['value']);
				}	
			}
		}
		$employees->get_paged($page, $limit);
		if($employees->exists()) {
			foreach($employees as $row) {
				$data[] = array(
					'id' => $row->id,
					'surname' => $row->surname,
					'name' => $row->name,
					'gender' => $row->gender,
					'dob' => $row->dob,
					'phone' => $row->phone,
					'email' => $row->email,
					'user_id' => $row->user_id,
					'address' => $row->address
				);
			}
			$this->benchmark->mark('benchmark_end');
			$this->response(array(
				'results'=>$data, 
				'msg' => 'result found', 
				'count'=>$employees->paged->total_rows, 
				'generatedIn'=>$this->benchmark->elapsed_time('benchmark_start', 'benchmark_end')
				),
			200);
		} else {
			$this->response(array('error'=>'no result.', 'msg' => 'no result found', 'generatedIn'=>$this->benchmark->elapsed_time('benchmark_start', 'benchmark_end')), 200);
		}
	}

	public function index_post() {
		$requested_data = json_decode($this->post('models'));
		$data = array();
		$this->benchmark->mark('benchmark_start');
		foreach($requested_data as $res) {
			$employees = new Contact(null, $this->entity);
			$employees->surname 	= $res->surname;
			$employees->name 		= $res->name;
			$employees->phone 		= $res->phone;
			$employees->email 		= $res->email;
			$employees->dob 		= $res->dob;
			$employees->gender 		= $res->gender;
			$employees->address 	= $res->address;
			$employees->user_id 	= $res->user_id;
			$employees->contact_type_id = 3;

			if($employees->save()) {
				$data[] = array(
					'id' => $employees->id,
					'surname' => $employees->surname,
					'name' => $employees->name,
					'gender' => $employees->gender,
					'dob' => $employees->dob,
					'phone' => $employees->phone,
					'email' => $employees->email,
					'user_id' => $employees->user_id,
					'address' => $employees->address
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

	public function index_put() {
		$requested_data = json_decode($this->put('models'));
		$data = array();
		$this->benchmark->mark('benchmark_start');
		foreach($requested_data as $res) {
			$employees = new Contact(null, $this->entity);
			$employees->where('id', $res->id)->get();
			$employees->surname 	= $res->surname;
			$employees->name 		= $res->name;
			$employees->phone 		= $res->phone;
			$employees->email 		= $res->email;
			// $employees->dob 		= $res->dob;
			$employees->gender 		= $res->gender;
			$employees->address 	= $res->address;
			$employees->user_id 	= $res->user_id;

			if($employees->save()) {
				$data[] = array(
					'id' => $employees->id,
					'surname' => $employees->surname,
					'name' => $employees->name,
					'gender' => $employees->gender,
					// 'dob' => $employees->dob,
					'phone' => $employees->phone,
					'email' => $employees->email,
					'user_id' => $employees->user_id,
					'address' => $employees->address
				);
			}
		}
		
		$this->benchmark->mark('benchmark_end');
		if(count($data) > 0) {
			$this->response(array('results'=>$data, 'msg' => 'result found', 'count'=>count($data), 'generatedIn'=>$this->benchmark->elapsed_time('benchmark_start', 'benchmark_end')), 200);
		} else {
			$this->response(array('results'=>array(), 'msg' => 'no result found', 'count'=>0, 'generatedIn'=>$this->benchmark->elapsed_time('benchmark_start', 'benchmark_end')), 200);
		}
	}

	public function index_delete() {
		$requested_data = json_decode($this->delete('models'));
		$data = array();
		$this->benchmark->mark('benchmark_start');
		$count = 0;
		foreach($requested_data as $res) {
			$employees = new Employee(null, $this->entity);
			$employees->where('id', $res->id)->get();
			$employees->deleted = 'true';

			if($employees->save()) {
				$count++;
			}
		}
		
		$this->benchmark->mark('benchmark_end');
		if(count($data) > 0) {
			$this->response(array('results'=>array(), 'msg' => $count .' affected.', 'count'=>$count, 'generatedIn'=>$this->benchmark->elapsed_time('benchmark_start', 'benchmark_end')), 201);
		} else {
			$this->response(array('results'=>array(), 'msg' => 'no result found', 'count'=>0, 'generatedIn'=>$this->benchmark->elapsed_time('benchmark_start', 'benchmark_end')), 200);
		}
	}
	
}