<?php defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH.'/libraries/REST_Controller.php';

class Tasks extends REST_Controller {
	
	function __construct() {
		parent::__construct();
		$this->load->model('task_m', 'task');
		$this->load->model('staff/employee_m', 'emp');
		$this->load->model('project_m', 'project');
	}
	
    function index_get($id="") {
    	$query;
    	if( $id == "" ) :
    		$query = $this->task->get_all();
    	else :
    		$query = $this->task->get_many_by('staff_id', $id);
		endif;

		foreach($query as $task) {
			$data[] = array(
				"id" 				=> $task->id,
				"service_id" 		=> $task->service_id,
				"title"				=> $task->title,
				"description" 		=> $task->description,
				"requested_date" 	=> $task->requested_date,
				"finished_date" 	=> $task->finished_date,
				"hours" 			=> $task->hours,
				"due_date" 			=> $task->due_date,
				"status"			=> $task->status,
				"priority"			=> $task->priority,
				"in_project"		=> $this->project->get($task->project_id),
				"assigned_to" 		=> $this->emp->get($task->staff_id),
				"creator"			=> $this->emp->get($task->created_by)
			);
		}
		
		if (!empty($query)) {
			$this->response($data, 200);
		} else {
			$api = array(
				"status" => "null"
			);
			$this->response($api, 400);
		}
    }
	
	function index_post() {
		//$data =  $this->post();
		$staff = $this->post("assigned_to");
		$creator=$this->post("creator");

		$data = array(
				"service_id" 		=> $this->post('service_id'),
				"description" 		=> $this->post('description'),
				"title"				=> $this->post('title'),
				"requested_date" 	=> date('Y-m-d', strtotime($this->post('requested_date'))),
				"finished_date" 	=> date('Y-m-d', strtotime($this->post('finished_date'))),
				"hours" 			=> $this->post('hours'),
				"due_date" 			=> date('Y-m-d', strtotime($this->post('due_date'))),
				"status"			=> $this->post('status'),
				"priority"			=> $this->post('priority'),
				"staff_id" 			=> $staff['id'],
				"created_by"		=> "6"
		);
		
		if( !empty($data) ) {
			
			$msg = $this->task->insert($data);
	
			if ( $msg !== false ) {
				$task = $this->task->get($msg);

				$data = array(
					"id" 				=> $task->id,
					"service_id" 		=> $task->service_id,
					"description" 		=> $task->description,
					"requested_date" 	=> $task->requested_date,
					"finished_date" 	=> $task->finished_date,
					"hours" 			=> $task->hours,
					"due_date" 			=> $task->due_date,
					"status"			=> $task->status,
					"priority"			=> $task->priority,
					"staff" 			=> $this->emp->get($task->staff_id) ? $this->emp->get($task->staff_id) : FALSE,
					"creator"			=> $this->emp->get($task->created_by)
				);

				$this->response($data, 200);
			} else {
				$this->response(array("status" => "cannot add to the database."), 400);
			}
				
		} else {
			$this->response(array("status" => "cannot add to the database."), 500);
		}
	}
	
	function index_put() {
		//$data 	=  $this->put();
		$id		= $this->put('id');
		$staff = $this->put('assigned_to');			
		$data = array(
				"service_id" 		=> $this->put('service_id'),
				"title"				=> $this->put('title'),
				"description" 		=> $this->put('description'),
				"requested_date" 	=> date('Y-m-d', strtotime($this->put('requested_date'))),
				"finished_date" 	=> date('Y-m-d', strtotime($this->put('finished_date'))),
				"hours" 			=> $this->put('hours'),
				"due_date" 			=> date('Y-m-d', strtotime($this->put('due_date'))),
				"status"			=> $this->put('status'),
				"priority"			=> $this->put('priority'),
				"staff_id" 			=> $staff['id']
		);
		$msg 	= $this->task->update($id, $data);
		
		if ( $msg !== false ) {
			$task = $this->task->get($id);
			$data = array(
					"id" 				=> $task->id,
					"service_id" 		=> $task->service_id,
					"description" 		=> $task->description,
					"requested_date" 	=> $task->requested_date,
					"finished_date" 	=> $task->finished_date,
					"hours" 			=> $task->hours,
					"due_date" 			=> $task->due_date,
					"status"			=> $task->status,
					"priority"			=> $task->priority,
					"staff" 			=> $this->emp->get($task->staff_id),
					"creator"			=> $this->emp->get($task->created_by)
				);
			$this->response($data, 200);
		} else {
			$this->response(array("status" => "cannot add to the database."), 400);
		}
	}

	function update_put() {
		//$data 	=  $this->put();
		$id		= $this->put('id');
		//$staff = $this->put('assigned_to');			
		$data = array(
				"service_id" 		=> $this->put('service_id'),
				"title"				=> $this->put('title'),
				"description" 		=> $this->put('description'),
				"requested_date" 	=> date('Y-m-d', strtotime($this->put('requested_date'))),
				"finished_date" 	=> date('Y-m-d', strtotime($this->put('finished_date'))),
				"hours" 			=> $this->put('hours'),
				"due_date" 			=> date('Y-m-d', strtotime($this->put('due_date'))),
				"status"			=> $this->put('status'),
				"priority"			=> $this->put('priority'),
				"staff_id" 			=> $this->put('assigned_to')
		);
		$msg 	= $this->task->update($id, $data);
		
		if ( $msg !== false ) {
			$task = $this->task->get($id);
			$data = array(
					"id" 				=> $task->id,
					"service_id" 		=> $task->service_id,
					"description" 		=> $task->description,
					"requested_date" 	=> $task->requested_date,
					"finished_date" 	=> $task->finished_date,
					"hours" 			=> $task->hours,
					"due_date" 			=> $task->due_date,
					"status"			=> $task->status,
					"priority"			=> $task->priority,
					"staff" 			=> $this->emp->get($task->staff_id),
					"creator"			=> $this->emp->get($task->created_by)
				);
			$this->response($data, 200);
		} else {
			$this->response(array("status" => "cannot add to the database."), 400);
		}
	}
	
	function index_delete() {
		
		$id		= $this->delete('id');			
		$msg 	= $this->task->delete($id);
		$this->response(array("hi"=>"OK"), 200);
	}

}

