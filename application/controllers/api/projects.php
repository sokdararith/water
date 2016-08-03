<?php defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH.'/libraries/REST_Controller.php';

class Projects extends REST_Controller {
	
	function __construct() {
		parent::__construct();
		$this->load->model('project_m', 'project');
		$this->load->model('task_m', 'tasks');
	}
	
        function index_get() {
			$project = $this->project->get_many_by('finished', 0);
			
			if (!empty($project)) {
				foreach($project as $row) {
					$projectList['projects'][] = array(
						"id" 	=> $row->id,
						"project_name" 	=> $row->title,
						"description"	=> $row->description,
						"funded_by"		=> $row->funding_organization,
						"start_on"		=> $row->start_date,
						"end_date"		=> $row->end_date,
						"status"		=> $row->finished,
						"tasks"			=> $this->tasks->count_by('project_id', $row->id),
						"task_list"		=> $this->tasks->get_many_by('project_id', $row->id),
						"created_at"	=> $row->created_at

					);
					$projectList['count'] = $this->project->count_by('finished', 0);	
				}
				
				$this->response($projectList, 200);
			} else {
				$api = array(
					"status" => "null"
				);
				$this->response($api, 400);
			}
        }
		
		function index_post() {
			//$data =  $this->post();
			$data = array(
					"title" 		=> $this->post("project_name"),
					"description" 	=> $this->post("description"),
					"start_date"	=> date('Y-m-d', strtotime($this->post('start_date'))),
					"end_date" 		=> date('Y-m-d', strtotime($this->post('end_date')))
			);
			
			if( !empty($data) ) {
				
				$msg = $this->project->insert($data);
		
				if ( $msg !== false ) {
					$project = $this->project->get($msg);
					$projectList['projects'][] = array(
						"id" 	=> $row->id,
						"project_name" 	=> $project->title,
						"description"	=> $project->description,
						"funded_by"		=> $project->funding_organization,
						"start_on"		=> $project->start_date,
						"end_date"		=> $project->end_date,
						"status"		=> $project->finished,
						"tasks"			=> $this->tasks->count_by('project_id', $row->id),
						"task_list"		=> $this->tasks->get_many_by('project_id', $row->id),
						"created_at"	=> $project->created_at

					);
					$projectList['count'] = $this->project->count_by('finished', 0);	
				
					$this->response($projectList, 200);
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
			$data = array(
					"title" 		=> $this->put("project_name"),
					"description" 	=> $this->put("description"),
					"start_date"	=> date('Y-m-d', strtotime($this->put('start_on'))),
					"end_date" 		=> date('Y-m-d', strtotime($this->put('end_date')))
			);
			$msg 	= $this->project->update($id, $data);
			
			if ( $msg !== false ) {
				$project = $this->project->get($id);
					$projectList['projects'][] = array(
						"id" 			=> $project->id,
						"project_name" 	=> $project->title,
						"description"	=> $project->description,
						"funded_by"		=> $project->funding_organization,
						"start_on"		=> $project->start_date,
						"end_date"		=> $project->end_date,
						"status"		=> $project->finished,
						"tasks"			=> $this->tasks->count_by('project_id', $project->id),
						"task_list"		=> $this->tasks->get_many_by('project_id', $project->id),
						"created_at"	=> $project->created_at

					);
					$projectList['count'] = $this->project->count_by('finished', 0);	
				
					$this->response($projectList, 200);
			} else {
				$this->response(array("status" => "cannot add to the database."), 400);
			}
		}
		
		function index_delete() {
			
			$id		= $this->delete('id');			
			$msg 	= $this->project->delete($id);
			$this->response(array("hi"=>"OK"), 200);
		}
	
}