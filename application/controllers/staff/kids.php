<?php defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH.'/libraries/REST_Controller.php';

class Kids extends REST_Controller {
	
	function __construct() {
		parent::__construct();
		$this->load->model('staff/kid_m', 'model');
	}
	
        function index_get() {
			$data = $this->model->get_many_by('staff_id', 1 );
			
			if( !empty($data) ) {
				$this->response($data, 200);
			}
						
        }
		
		function index_post() {
			$data =  $this->post();
			
			if( !empty($data) ) {
				
				$existed = $this->staff->get_by('name', $data);
				if( !empty($existed) ) {
					
				} else {
					$msg = $this->staff->insert(array("name" => $data, "deletable" => $this->post('deletable')));
			
					if ( $msg !== false ) {
						$this->response(array("status" => "data $msg is added to the database."), 200);
					} else {
						$this->response(array("status" => "cannot add to the database."), 400);
					}
				}
					
			} else {
				
			}
		}
		
		function index_put() {
			$data 	=  $this->put();
			$id		= $this->put('id');			
			$msg 	= $this->staff->update($id, $data);
			
			if ( $msg !== false ) {
				$this->response(array("status" => "data $msg is added to the database."), 200);
			} else {
				$this->response(array("status" => "cannot add to the database."), 400);
			}
		}
		
		function index_delete() {
			
			//$id		= $this->delete('id');			
			//$msg 	= $this->nationality->delete($id);
			$this->response(array("hi"=>"OK"), 200);
		}
	
}