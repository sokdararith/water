<?php defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH.'/libraries/REST_Controller.php';

class Credentials extends REST_Controller {
	
	function __construct() {
		parent::__construct();
		$this->load->model('credential_m', 'credential');
		$this->load->model('staff/employee_m', 'staff');
		$this->load->model('staff/user_role_m', 'role');
	}
	
    function index_get() {
        $filter = $this->get("filter");		
		if(!empty($filter) && isset($filter)){			
			$criteria = array();				
			for ($i = 0; $i < count($filter['filters']); ++$i) {				
				$criteria += array($filter['filters'][$i]['field'] => $filter['filters'][$i]['value']);
			}
			$cred = $this->credential->get_many_by($criteria);
			if(count($cred) > 0) {
				foreach($cred as $login) {
					$data[] = array(
						"id" => $login->id,
						"role" => $this->role->get($login->role_id),
						"username" => $login->username,
						"password" => "",
						"created_at" => $login->created_at,
						"updated_at" => $login->updated_at
					);
	 			}
 				$this->response(array("status"=>"OK", "results"=>$data), 200);
 			}	
		}
    }
		
	function index_post() {
		$role = $this->post('role');
		$data = array(
			"role_id" 	=> $role['id'],
			"company_id"=> $this->post('company_id'),
			"username" 	=> $this->post('username'),
			"password" 	=> sha1($this->post('password'))
		);
		if( !empty($data) ) {
			
			$code = $this->post('username');
			
			//check for empty string
			if ($code == "" ) {
				$this->response(array("status"=>"Failed to create.", "message"=>"Some emty data fields"), 401);
			} else {
				$existed = $this->credential->get_by('username', $this->post('username'));
				
				//check if staff existed
				if( !empty($existed) ) {
					$this->response(array("status"=>"Failed to create.", "message"=>"Code existed, try different code."), 401);
				} else {
					$msg = $this->credential->insert($data);
		
					if ( $msg !== false ) {
						$cred = $this->credential->get($msg);
						$data[] = array(
							"id" => $cred->id,
							"role" => $this->role->get($cred->role_id),
							"username" => $cred->username,
							"password" => $cred->password,
							"created_at" => $cred->created_at,
							"updated_at" => $cred->updated_at
						);
						$this->response(array("status"=>"OK", "results"=>$data), 200);
					} else {
						$this->response(array("status" => "ERROR", "results"=>$array()), 200);
					}
				}
			}
		} else {
			
		}	
	}
		
	function index_put() {
		$id		= $this->put('id');
		$role 	= $this->put('role');
		$password = sha1($this->put('password'));	

		$msg 	= $this->credential->update($id, array("role_id" => $role['id'], "password"=>$password));
		if ( $msg !== false ) {
			$cred = $this->credential->get($id);
			$data[] = array(
				"id" => $cred->id,
				"role" => $this->role->get($cred->role_id),
				"username" => $cred->username,
				"password" => "",
				"created_at" => $cred->created_at,
				"updated_at" => $cred->updated_at
			);
			$this->response(array("status"=>"OK", "results"=>$data), 200);
		} else {
			$this->response(array("status" => "ERROR", "results"=>$array()), 200);
		}
	}
	
	function index_delete() {
		
		$id		= $this->delete('id');			
		$msg 	= $this->credential->delete($id);
		$this->response(array("hi"=>"OK"), 200);
	}

	function change_password_put() {

	}
	
}