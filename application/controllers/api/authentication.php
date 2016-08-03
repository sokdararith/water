<?php defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH.'/libraries/REST_Controller.php';

class Authentication extends REST_Controller {

	public $entity;
	function __construct() {
		parent::__construct();
		$this->entity = $this->input->get_request_header('Entity');
	}

	// get user information
	// @param: optional userId
	// return userdata
	function index_get() {
		$requested_data = $this->get("filter");
		$filters = $requested_data['filters'];
		$limit = $this->get('limit') ? $this->get('limit'): 50;
		$offset= $this->get('offset')? $this->get('offset'): null;

		$users = new Login();
		$users->limit($limit, $offset);
		if(isset($filters)) {
			$users->where('username', $filters[0]['value'])->get();
			if($users->exists()) {
				if($users->hashedPassword === hash('sha512', $this->config->item('encryption_key').$filters[1]['value'])){
					$institute = $users->institute->get_raw();
					$permission= $users->permission->get();
					$data[] = array(
						'id' 	   => $users->id,
						'username' => $users->username,
						'firstName'=> $users->first_name,
						'lastName' => $users->last_name,
						'password' => '*******',
						'institute'=> $institute->result(),
						'perm'     => $permission->id !== null ? $permission->id : 0
					);
					$this->response(
						array('error' => false, 'msg' => 'user found', 'results'=>$data, 'count'=>count($data)),
					 	200
					);
				} else {
					$this->response(array('error' => true, 'msg' => 'bad password', 'results'=>array(), 'count'=>0), 200);
				}
			} else {		
				$this->response(
					array('error' => false, 'msg' => 'no user found', 'results'=>array(), 'count'=>0), 200);
			}	
		} else {
			$this->response(array('error' => true, 'msg' => 'no filter', 'results'=>array(), 'count'=>0), 200);
		}
	}

	// update user information
	// @param: user data
	// return userdata
	function index_put() {
		$requested_data = json_decode($this->put('models'));
		foreach($requested_data as $user) {
			$User = new Login(null, $this->entity);
			$User->where('username', $user->username)->get();
			if($User->exists()) {
				if(hash('sha512', $this->config->item('encryption_key'.$user->password)) === $User->hashedPassword) {
					$User->hashedPassword = hash('sha512', $this->config->item('encryption_key'.$user->confirmPassword));
					$User->first_name = $user->firstName;
					$User->last_name  = $user->lastName;
					$User->save();
				
					if($User->save()) {
						$data[] = array(
							'id' 		=> intval($User->id),
							'username' 	=> $User->username,
							'firstName' => $User->first_name,
							'lastName' => $User->last_name,
							'password'  => '*********'
						);
						$this->response(array('error' => false, 'msg' => 'user found', 'results'=>$data, 'count'=>count($data)), 200);	
					} else {
						$this->response(array('error' => true, 'msg' => 'could not execute your request', 'results'=>array(), 'count'=>0), 200);
					}
				} else {
					$this->response(array('error' => true, 'msg' => 'bad password', 'results'=>array(), 'count'=>0), 200);
				}
			} else {
				$this->response(array('error' => true, 'msg' => 'no user found', 'results'=>array(), 'count'=>0), 200);
			}
		}
	}

	// create user information
	// @param: user data
	// return userdata
	function index_post() {
		$requested_data = json_decode($this->post('models'));
		
		foreach($requested_data as $user) {
			$User = new Login();
			$User->where('username', $user->username)->get();
			if($User->exists()) {
				$inst = new Institute();
				$inst->where('id', $user->institute)->get();
				if($User->save($inst)) {
					$institute = $User->institute->get_raw();
					$perm = $User->permission->get();
					$data[] = array(
						'id' => $User->id,
						'username' => $User->username,
						'firstName' => $User->first_name,
						'lastName' => $User->last_name,
						'institute'=> $institute->result(),
						'perm' => $perm->id
					);
				}
				$this->response(array('error' => true, 'msg' => 'dupliate_user', 'results'=>$data, 'count'=>count($data)), 200);
			} else {
				$User->username = $user->username;
				$User->first_name = $user->firstName;
				$User->last_name = $user->lastName;
				$User->hashedPassword = hash('sha512', $this->config->item('encryption_key').$user->password);
				if(isset($user->institute)){
					$inst = new Institute();
					$inst->where('id', $user->institute)->get();
					if($User->save($inst)) {
						$institute = $User->institute->get_raw();
						$perm = $User->permission->get();
						$data[] = array(
							'id' => $User->id,
							'username' => $User->username,
							'firstName' => $User->first_name,
							'lastName' => $User->last_name,
							'institute'=> $institute->result(),
							'perm' => $perm->id
						);
					}
				} else {
					if($User->save()) {
						$institute = $User->institute->get_raw();
						$perm = $User->permission->get();
						$data[] = array(
							'id' => $User->id,
							'username' => $User->username,
							'firstName' => $User->first_name,
							'lastName' => $User->last_name,
							'institute'=> $institute->result(),
							'perm' => $perm->id
						);
					}
				}
			}	
		}
		if(count($data) > 0) {
			$this->response(array('error' => false, 'msg' => 'user found', 'results'=>$data, 'count'=>count($data)), 201);
		} else {
			$this->response(array('error' => true, 'msg' => 'no user found', 'results'=>array(), 'count'=>0), 200);
		}
	}

	// delete user information
	// @param: user data
	// return true: successful, false: failed
	function index_delete() {
		$$requested_data = json_decode($this->post('models'));
		foreach($requested_data as $user) {
			$User = new Login();
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

	function users_get() {
		$requested_data = $this->get("filter");
		$filters = $requested_data['filters'];
		$limit = $this->get('limit') ? $this->get('limit'): 50;
		$offset= $this->get('offset')? $this->get('offset'): null;

		$inst = new Institute();
		$inst->limit($limit, $offset);
		// if(isset($this->entity)) {
		// 	$inst->where('id', $this->entity);
		// } else 
		if(isset($filters)) {
			foreach($filters as $f) {
				$inst->where($f['field'], $f['value']);
			}
		} 

		$inst->get();
		if($inst->exists()) {
			$users = $inst->login->get();
			foreach($users as $user) {
				$permission= $user->permission->get();
				$data[] = array(
					'id' 	   => $user->id,
					'username' => $user->username,
					'firstName'=> $user->first_name,
					'lastName' => $user->last_name,
					'password' => '*******',
					'institute'=> array(
						'id' => $inst->id,
						'name' => $inst->name,
						'logo' => $inst->logo
					),
					'perm'     => $permission->id !== null ? $permission->id : 0
				);
			}					
			$this->response(
				array('error' => false, 'msg' => 'user found', 'results'=>$data, 'count'=>count($data)),
			 	200
			);
		} else {		
			$this->response(
				array('error' => false, 'msg' => 'no user found', 'results'=>array(), 'count'=>0), 200);
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