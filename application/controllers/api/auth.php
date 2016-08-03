<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); //disallow direct access to this file

require APPPATH.'/libraries/REST_Controller.php';

class Auth extends REST_Controller {
	public $entity;
	public function __construct() {
		parent::__construct();
		// if($this->_get_token() !== FLASE) {
		// 	// good to go
		// } else {
		// 	// block from using
		// }
		// $this->load->library('DatabaseEx');
		$this->entity = $this->input->get_request_header('Entity');
	}
	function index_get() {
		$requested_data = $this->get('filter');
		$filters = $requested_data['filters'];
		$users = new User(null, $this->entity);
		foreach($filters as $f) {
			if($f['field'] == 'password') {
				$users->where($f['field'], $this->_encrypt($f['value']));
				$pass = $this->_encrypt($f['value']);
			} else {
				$users->where($f['field'], $f['value']);
			}
 		}
 		$users->get();
 		if($users->exists() && $users->status !== FALSE) {
 			$roles = $users->role->get_raw();
 			$contacts = $users->contact->get_raw();
			$data[] = array(
				'id' => $users->id,
				'username' => $users->username,
				'password' => $users->password,
				'status' => $users->status,
				'roles' => $roles->result(),
				'contacts' => $contacts->result(),
				'created_at' => $users->created_at,
				'updated_at' => $users->updated_at
			);
			$this->response(array('results'=>$data), 200);
 		} else {
 			$this->response(array('results'=>array(), 'msg'=>'user either not exist or not active.'), 200);
 		}
	}

	function index_post() {
		// $limit = $this->post('limit');
		// $filter = $this->post('filter');
		// $username = $filter['filters'][0]['value'];
		// $password = $this->_encrypt($filter['filters'][1]['value']);
		// $keys = array('username' => $username, 'password' => $password);
		// $u = new User(null, 'db_banhji');
		// $companies = array();
		
		// $u->where($keys)->get();
		// $u->company->get();
		// if($u->result_count() > 0) {
		// 	if(!empty($u->company)) {
		// 		foreach($u->company as $c) {
		// 			$companies[] = array(
		// 				"id" => $c->id,
		// 				"name" => $c->name,
		// 				"address" => $c->address,
		// 				"mobile" => $c->mobile,
		// 				"parent_id" => $c->parent_id
		// 			);
		// 		}
		// 	}
			
		// 	$data[] = array(
		// 		"id" => $u->id,
		// 		"username" => $u->username,
		// 		"password" => "*****",
		// 		"status"   => $u->status,
		// 		"companies" => $companies
		// 	);
		// 	$this->response(array('results'=>$data), 200);
		// } else {
		// 	$this->response(array('results'=>array(), 'meta'=>array('msg'=>'could not login.')), 200);
		// }
		// $this->response(array('results'=>array(), 'meta'=>array('msg'=>'please provide username and password')), 200);
	}

	function register_post() {
		$model = json_decode($this->post('models'));

		$u = new User();
		if($this->_email_existed($model[0]->email)) {
			$this->response(array('data'=>array(), 'metadata'=>array(
				'msg'=>'email already used.',
				'code' => 500
			)), 500);
		} else {
			$u->username = $model[0]->email;
			$u->password = $this->_encrypt($model[0]->password);
			$u->confirm_token = md5(uniqid(mt_rand(), true));
			$u->status = 'true';
			if(isset($model->institute)) {
				$institute = new Institute();
				$institute->where('id', $model->institute)->get();
				if($u->save($institute)){
					$token = new Token();
					$token->user_id = $u->id;
					$token->token = md5(uniqid(mt_rand(), true));
					$token->expired = date('Y-m-d', strtotime('+30 days'));
					$token->save();
					$data = array(
						"id" => $u->id,
						"token" => $token->token,
						"username" => $u->username,
						"password" => "hidden",
						"status"   => $u->status === 1 ? true : false,
						"confirmation" => $u->confirm_token,
						"companies" => array()
					);
				}
			} else {
				if($u->save()){
					$token = new Token();
					$token->user_id = $u->id;
					$token->token = md5(uniqid(mt_rand(), true));
					$token->expired = date('Y-m-d', strtotime('+30 days'));
					$token->save();
					$data = array(
						"id" => $u->id,
						"token" => $token->token,
						"username" => $u->username,
						"password" => "hidden",
						"status"   => $u->status === 1 ? true : false,
						"confirmation" => $u->confirm_token,
						"companies" => array()
					);
				}
			}
				
			$this->response(array('user'=>$data, 'metadata'=>array(
				'msg'=>'user created, waiting for validation.',
				'code' => 201
			)), 201);
		}
	}

	function index_put() {
		$model = json_decode($this->put('models'));
		$u = new User(null, $this->entity);
		$u->where('email', $model[0]->email);
		if($u->password !== $this->_encrypt($model[0]->password)) {
			$u->password = $this->_encrypt($model[0]->password);
		}
		$u->save();
	}

	function _encrypt($field){
        $hash = null;
        // Don't encrypt an empty string
        if (!empty($field))
        {
            $hash = sha1($this->config->item('encryption_key').$field);
        }
        return $hash;
    }

    function _email_existed($email) {
    	$u = new User();
    	$u->get_by_username($email);
    	if($u->username) {
    		return TRUE;
    	} else {
    		return FALSE;
    	}
    }
    private function _get_token() {
    	if(apache_request_headers()['access-token']) {
    		return apache_request_headers()['access-token'];
    	} else {
    		return FALSE;
    	}
    }
}

/* End of file auth.php */
/* Location: ./application/models/auth.php */