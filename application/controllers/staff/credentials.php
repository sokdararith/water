<?php defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH.'/libraries/REST_Controller.php';

class Credentials extends REST_Controller {
	
	function __construct() {
		parent::__construct();
		$this->load->model('staff/credential_m', 'login');
	}
	
        function index_get() {
			$login = $this->login->get_all();
			
			if (!empty($login)) {
				$this->response($login, 200);
			} else {
				$api = array(
					"status" => "null"
				);
				$this->response($api, 200);
			}
        }
		
		function index_post() {
			$data =  $this->post();
			
			$msg = $this->login->insert($data);
			
			if ( $msg !== false ) {
				$this->response(array("status" => "data $msg is added to the database."), 200);
			} else {
				$this->response(array("status" => "cannot add to the database."), 400);
			}
		}
		
		function index_put() {
			$data 	=  $this->put();
			$id		= $this->put('id');			
			$msg 	= $this->login->update($id, $data);
			
			if ( $msg !== false ) {
				$this->response(array("status" => "data $msg is added to the database."), 200);
			} else {
				$this->response(array("status" => "cannot add to the database."), 400);
			}
		}
		
		function index_delete() {
			
			$id		= $this->delete('id');			
			$msg 	= $this->login->delete($id);
		}
	
}
