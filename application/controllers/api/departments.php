<?php defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH.'/libraries/REST_Controller.php';

class Departments extends REST_Controller {
	
	function __construct() {
		parent::__construct();
		$this->load->model('department_m', 'dept');
	}
	
        function index_get() {
			$department = $this->dept->get_all();
			
			if (!empty($department)) {
				$this->response($department, 200);
			} else {
				$api = array(
					"status" => "null"
				);
				$this->response($api, 400);
			}
        }
		
		function index_post() {
			$data =  $this->post('name');
			
			if( !empty($data) ) {
				
				$existed = $this->dept->get_by('name', $data);
				if( !empty($existed) ) {
					
				} else {
					$msg = $this->dept->insert(array("name" => $data, "deletable" => $this->post('deletable')));
			
					if ( $msg !== false ) {
						$this->response($this->dept->get($msg), 200);
					} else {
						$this->response(array("status" => "cannot add to the database."), 400);
					}
				}
					
			} else {
				
			}
		}
		
		function index_put() {
			$id		= $this->put('id');			
			$msg 	= $this->dept->update($id, array("name"=>$this->put('name')));
			
			if ( $msg !== false ) {
				$this->response($this->dept->get($id), 200);
			} else {
				$this->response(array("status" => "cannot add to the database."), 400);
			}
		}
		
		function index_delete() {
			
			$id		= $this->delete('id');			
			$msg 	= $this->dept->delete($id);
			$this->response(array("hi"=>"OK"), 200);
		}
	
}