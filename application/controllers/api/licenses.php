<?php defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH.'/libraries/REST_Controller.php';

class Licenses extends REST_Controller {
	
	function __construct() {
		parent::__construct();
		$this->load->model('license_m', 'license');
	}
	
        function index_get() {
			$data = $this->license->get_all();
			
			if (!empty($data)) {
				$this->response($data, 200);
			} else {
				$api = array(
					"status" => "Error",
					"message"=> "There is not data in the record."
				);
				$this->response($api, 400);
			}
        }
		
		function index_post() {
			$data =  $this->post();
			
			$msg = $this->license->insert($data);
			
			if ( $msg !== false ) {
				$this->response(array("status" => "data $msg is added to the database."), 200);
			} else {
				$this->response(array("status" => "cannot add to the database."), 400);
			}
		}
		
		function index_put() {
			$data 	=  $this->put();
			$id		= $this->put('id');			
			$msg 	= $this->license->update($id, $data);
			
			if ( $msg !== false ) {
				$this->response(array("status" => "data $msg is added to the database."), 200);
			} else {
				$this->response(array("status" => "cannot add to the database."), 400);
			}
		}
		
		function index_delete() {
			
			$id		= $this->delete('id');	
					
			$msg 	= $this->license->delete($id);
		}
	
}