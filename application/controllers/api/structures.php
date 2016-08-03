<?php defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH.'/libraries/REST_Controller.php';

class Structures extends REST_Controller {
	public $entity;
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

	// get user information
	// @param: optional userId
	// return userdata
	function index_get() {
		// $requested_data = $this->get("filter");
		// $filters = $requested_data['filters'];
		// $logic = $requested_data['logic'];
		$limit = $this->get('limit') ? $this->get('limit'): 50;
		$offset= $this->get('offset')? $this->get('offset'): null;
		if(isset($filters)) {
			$Structures = new Structure(null, $this->entity);
			$Structures->limit($limit, $offset);
			foreach($filters as $f) {
				if($f['operation'] === 'and') {
					$Structures->where($f['field'], $f['value']);
				} else if($f['operation'] === 'or') {
					$Structures->or_where($f['field'], $f['value']);
				} else if($f['operation'] === 'like') {
					$Structures->like($f['field'], $f['value']);
				} else if($f['operation'] === 'or_like') {
					$Structures->or_like($f['field'], $f['value']);
				} else if($f['operation'] === 'where_in') {
					$Structures->where_in($f['field'], $f['value']);
				} else {
					$Structures->where($f['field'], $f['value']);
				}
			}
			$Structures->get_iterated();
			foreach($Structures as $seg) {
				$segment = $seg->segment->get_raw();
				$data[] = array(
							'id' 		=> intval($seg->id),
							'code' 	=> $seg->code,
							'description' 	=> $seg->description,
							'segments'		=> $segment->result(),
							'created_at'=> $seg->created_at,
							'updated_at'=> $seg->updated_at
						);
			}

			$Structures->flush_cache();
			if(isset($filters)) {
				foreach($filters as $f) {
					$Structures->where($f['field'], $f['value']);
				}
			}
			$Structures->get_iterated();
			if($Structures->result_count() > 0) {
				$this->response(array('results'=>$data, 'count'=>$Structures->result_count()), 200);
			} else {
				$this->response(array('error'=>'no result found', 'code'=>3010), 200);
			}	
		} else {
			$Structures = new Structure(null, $this->entity);
			$Structures->limit($limit, $offset);
			$Structures->get_iterated();
			
			if($Structures->result_count() > 0) {
				foreach($Structures as $structure) {
					$s =$structure->segment->get_raw();
					$data[] = array(
						'id' => $structure->id,
						'description' => $structure->description,
						'code' => $structure->code,
						'segments' => $s->result(),
						'created_at' => $structure->created_at,
						'updated_at' => $structure->updated_at
					);
					// $data[] = $s->result();
				}
			}

			$Structures->flush_cache();
			$Structures->get();
			$this->response(array('results'=>$data, 'count'=>$Structures->result_count()), 200);
		}
	}

	// update user information
	// @param: user data
	// return userdata
	function index_put() {
		$requested_data = json_decode($this->put('models'));
		foreach($requested_data as $d) {
			$Segments = new Structure(null, $this->entity);
			$Segments->where('id', $user->id)->get();

			$Segments->code_length = $d->code_length;
			$Segments->name = $d->name;
			
			if($Segments->save()) {
				$data[] = array(
					'id' 			=> intval($Segments->id),
					'code' 			=> $Segments->code,
					'description'   => $Segment->description,
					'segments'   => $Segment->segments,
					'created_at' 	=> $Segment->created_at,
					'updated_at' 	=> $Segment->updated_at
				);
			}
		}
		if(count($data) > 0) {
			$this->response(array('msg'=>'good', 'results'=>$data, 'count'=> count($data)), 200);
		} else {
			$this->response(array('results'=>array(), 'count'=> 0), 200);
		}
	}

	// create user information
	// @param: user data
	// return userdata
	function index_post() {
		$requested_data = json_decode($this->post('models'));
		
		foreach($requested_data as $d) {
			$Segments = new Segment(null, $this->entity);
			foreach($d->segments as $seg) {
				$seg_data[] = $seg->id;
			}
			$Segments->where_in('id', $seg_data)->get();
			$Structure = new Structure(null, $this->entity);

			$Structure->code = $d->code;
			$Structure->description = $d->description;
			if($Structure->save($Segments->all)) {
				$segment = $Structure->segment->get_raw();
				$data[] = array(
					'id' 			=> intval($Structure->id),
					'code' 			=> $Structure->code,
					'description'   => $Structure->description,
					'segments'		=> $segment->result(),
					'created_at' 	=> $Structure->created_at,
					'updated_at' 	=> $Structure->updated_at
				);
			}
		}
		if(count($data) > 0) {
			$this->response(array('results'=>$data, 'count'=> count($data)), 201);
		} else {
			$this->response(array('results'=>array(), 'count'=> 0), 201);
		}
	}

	// delete user information
	// @param: user data
	// return true: successful, false: failed
	function index_delete() {
		$requested_data = json_decode($this->delete('models'));
		$count = 0;
		foreach($requested_data as $d) {
			$Segments = new Structure(null, $this->entity);
			$Segments->where('id', $d->id)->get();
			if($User->delete()) {
				$count += 1;
			}
		}
		$this->response(array('msg'=>count($requested_data). 'sent '.$count. " deleted.", 'results'=>$array(), 'count'=> count($data)), 301);	
	}
}
/* End of file users.php */
/* Location: ./application/controllers/api/users.php */