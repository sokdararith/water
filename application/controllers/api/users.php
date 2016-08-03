<?php defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH.'/libraries/REST_Controller.php';

class Users extends REST_Controller {

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
		$requested_data = $this->get("filter");
		$filters = $requested_data['filters'];
		$limit = $this->get('limit') ? $this->get('limit'): 50;
		$offset= $this->get('offset')? $this->get('offset'): null;

		$users = new User(null, $this->entity);
		$users->limit($limit, $offset);
		if(isset($filters)) {
			foreach($filters as $f) {
				$users->where($f['field'], $f['value']);
			}	
		}
		$users->get_iterated();
		foreach($users as $user) {
			$data[] = array(
						'id' 		=> intval($user->id),
						'username' 	=> $user->username,
						'password' 	=> $user->password,
						'first_name'=> $user->first_name,
						'last_name' => $user->last_name,
						'status'	=> boolval($user->status),
						'created_at'=> $user->created_at,
						'updated_at'=> $user->updated_at
					);
		}

		$users->flush_cache();
		if(isset($filters)) {
			foreach($filters as $f) {
				$users->where($f['field'], $f['value']);
			}
		}
		$users->get_iterated();
		if($users->result_count() > 0) {
			$this->response(array('results'=>$data, 'count'=>$users->result_count()), 200);
		} else {
			$this->response(array('results'=>$data, 'count'=>$users->result_count()), 200);
		}
	}

	// update user information
	// @param: user data
	// return userdata
	function index_put() {
		$requested_data = json_decode($this->put('models'));
		foreach($requested_data as $user) {
			$User = new User(null, $this->entity);
			$User->where('id', $user->id)->get();

			if($User->password !== $this->_encrypt($user->password)) {
				$User->password = $user->password;
			}
			if($User->status !== $user->status) {
				$User->status = $user->status;
			}
			$User->save();
			
			if($User->save()) {
				$data[] = array(
					'id' 		=> intval($User->id),
					'username' 	=> $User->username,
					'password' 	=> '*******',
					'status'   	=> boolval($User->status),
					'created_at'=> $User->created_at,
					'updated_at'=> $User->updated_at
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
		
		foreach($requested_data as $user) {
			$User = new User(null, $this->entity);
			$User->username = $user->username;
			$User->password = $this->_encrypt($user->password);
			$User->status = 1;
			if($User->save()) {
				$data[] = array(
					'id' => $User->id,
					'username' => $User->username,
					'password' => '*******',
					'status'   => $User->status,
					'created_at'=> $User->created_at,
					'updated_at'=> $User->updated_at
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
		$$requested_data = json_decode($this->post('models'));
		foreach($requested_data as $user) {
			$User = new User(null, $this->entity);
			$User->status = 0;
			if($User->save()) {
				$data[] = array(
					'id' => $User->id,
					'username' => $User->username,
					'password' => '*******',
					'status'   => $User->status,
					'created_at'=> $User->created_at,
					'updated_at'=> $User->updated_at
				);
			}
		}
		if(count($data) > 0) {
			$this->response(array('results'=>$data, 'count'=> count($data)), 201);
		} else {
			$this->response(array('results'=>array(), 'count'=> 0), 201);
		}
	}

	/* Get all roles for user
	* @param: user id
	*/
	function roles_get() {
		$filter = $this->get('filter')?$this->get('filter'): null;
		$limit = $this->get('limit');
		$offset = $this->get('offset')?$this->get('offset'):0;

		$user = new User(null, $this->entity);
		foreach($filter['filters'] as $f) {
			$user->where($f['field'], $f['value']);
		}

		$data = $user->include_related('role', NULL, TRUE)->get_raw();
		$this->response(array('results'=>$data->result()), 200);
	}

	/* assign user to role
	* @param: user id and role id
	*/
	function roles_post() {
		$requested_data = json_decode($this->post('models'));

		foreach($requested_data as $d) {
			$user = new User(null, $this->entity);
			$user->where('id', $d->user_id);
			$user->get();

			$role = new Role(null, $this->entity);
			$role->where('id', $d->role_id);
			$role->get();

			if($user->exists() && $role->exists()) {
				if($user->save($role)){
					$r = $user->include_related('role', NULL, TRUE)->get_raw();
					$this->response(array('msg'=>'assigned successfully.', 'results'=>$r->result()), 201);
				} else {
					$this->response(array('msg'=>'error assigning to role.', 'results'=>array()), 201);
				}
			} else {
				$this->response(array('msg'=>'either role or user does not exist', 'results'=>array()), 201);
			}
		}
		// $this->response(array('msg'=>'assigned successfully.', 'results'=>$r->result()), 201);
	}

	/* remove user from role
	* @param: user id and role id
	*/
	function roles_delete() {
		$requested_data = json_decode($this->delete('models'));

		foreach($requested_data as $d) {
			$user = new User(null, $this->entity);
			$user->where('id', $d->id)->get();
			$role = $user->role->where('id', $d->role_id)->get();

			if($role->exists()) {
				$role->delete($user);
				// if($role->delete($user)){
				// 	$this->response(array('msg'=>'deleted successfully.', 'results'=>$r->result()), 201);
				// } else {
				// 	$this->response(array('msg'=>'error removing from role.', 'results'=>array()), 201);
				// }

			} //else {
			// 	$this->response(array('msg'=>'either role or user does not exist', 'results'=>array()), 201);
			// }
		}
	}

	private function _check_email($email) {
		$query = $this->login->get_by(array("username"=>$email));
		if(!empty($query)) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	function _encrypt($field){
        $hash = null;
        // Don't encrypt an empty string
        if (!empty($field))
        {
            $hash = $this->{$field} = sha1($this->config->item('encryption_key').$field);
        }
        return $hash;
    }
}
/* End of file users.php */
/* Location: ./application/controllers/api/users.php */