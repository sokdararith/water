<?php defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH.'/libraries/REST_Controller.php';

class Workhistories extends REST_Controller {
	
	function __construct() {
		parent::__construct();
		$this->load->model('staff/work_m', 'work');
	}
	
	function index_get() {
		$criteria = $this->get('staff_id');
		
		if (!empty($criteria)) {
			$data = $this->work->get_many_by('staff_id', $criteria);
			if (!empty($data)) {
				$this->response($data, 200);
			} else {
				$this->response(array('status'=>'not found'), 404);
			}
		} else {
			$data = $this->work->get_all();
			if (!empty($data)) {
				$this->response($data, 200);
			} else {
				$this->response(array('status'=>'not found'), 400);
			}
		}
	}
	function index_post() {

		$data = array(
			"staff_id" 		=> $this->post('staff_id'),
			"job_id"		=> $this->post('job_id'),
			"title"			=> $this->post('title'),
			"institution"	=> $this->post('institution'),
			"description"	=> $this->post('description'),
			"from"			=> date('Y-m-d', strtotime($this->post('from'))),
			"to"			=> date('Y-m-d', strtotime($this->post('to')))
		);	
		if( !empty($data) ) {
			$msg = $this->work->insert($data);

			if ( $msg !== false ) {
				$this->response($this->work->get_by("id", $msg), 200);
			} else {
				$this->response(array("status" => "cannot add to the database."), 500);
			}
		} else {
			$this->response(array("status" => "cannot add to the database."), 400);
		}
	}
	function index_put() {
		$data = array(
			"staff_id" 		=> $this->put('staff_id'),
			"job_id"		=> $this->put('job_id'),
			"title"			=> $this->put('title'),
			"institution"	=> $this->put('institution'),
			"description"	=> $this->put('description'),
			"from"			=> date('Y-m-d', strtotime($this->put('from'))),
			"to"			=> date('Y-m-d', strtotime($this->put('to')))
		);
		$id		= $this->put('id');			
		$msg 	= $this->work->update($id, $data);
		
		if ( $msg !== false ) {
			$this->response($this->work->get_by("id", $id), 200);
		} else {
			$this->response(array("status" => "cannot add to the database."), 400);
		}
		$this->response($this->work->get_by("id", $id), 200);
	}

	function index_delete() {
		$id		= $this->delete('id');			
		$msg 	= $this->work->delete($id);
		$this->response(array("hi"=>"OK"), 200);
	}
}