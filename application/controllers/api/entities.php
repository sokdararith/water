<?php defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH.'/libraries/REST_Controller.php';

/* for creating and editing company and their database */

class Entities extends REST_Controller {
	
	function __construct() {
		parent::__construct();	
		$this->entity = $this->input->get_request_header('Entity');
		$this->user = null;
		$this->db = null;
		$this->pwd= null;
		$user = new Login();
		$user->where('id', $this->input->get_request_header('User'))->get();
		if($user->exists()) {
			$institute = $user->institute->connection->get();
			if($institute->exist()) {
				$this->user = $institute->username;
				$this->db   = $institute->server_name;
				$this->pwd  = $institute->password;
			} else {
				$this->response(array('error' => true, 'msg' => 'no institute found', 'results'=>array(), 'count'=>0), 200);
			}
		} else {
			$this->response(array('error' => true, 'msg' => 'no user exists', 'results'=>array(), 'count'=>0), 200);
		}
	}


	public function index_get() {
		$filter = json_decode($this->get('filter'));
		$limit = $this->get('limit');
		$offset= $this->get('offset');
		foreach($filter->filters as $v) {
			if(isset($v->operator) && $v->operator === 'like') {
				$this->db->like($v->field, $v->value);
			}
			if(isset($v->operator) && $v->operator === 'or_like') {
				$this->db->or_like($v->field, $v->value);
			}
			if(isset($v->operator) && $v->operator === 'where_in') {
				$this->db->where_in($v->field, $v->value);
			}
			if(isset($v->operator) && $v->operator === 'having') {
				$this->db->having($v->field, $v->value);
			}
			if(isset($v->operator)) {
				$this->db->where($v->field, $v->value);
			}
		}
		
		$this->db->limit($limit, $offset);
		$query = $this->db->get('companies');
		$this->response(array('results'=>$query->result(), 'count'=>1), 200);
	}

	public function index_post() {
		// decode data sent from client back to php array for processing
		$posted = json_decode($this->post('models'));

		foreach($posted as $c) {
			$this->db->insert('companies', $c);
			$id = $this->db->insert_id();
			$ids[] = $id;
			$this->db->insert('tenants', array(
				'company_id' => $id,
				'name' => $c->name,
				'db_host' => 'localhost',
				'db_user' => 'root',
				'db_password' => '',
				'db_port' => 3306
			));
		}
		$this->db->flush_cache();
		$this->db->where_in('id', $ids);
		$this->db->from('companies');
		$query = $this->db->get();
		$this->response(array('results'=>$query->result(), 'count'=>count($ids)), 201);
	}

	public function index_put() {
		$posted = json_decode($this->put('models'));

		foreach($posted as $c) {
			$this->db->where('id', $c->id);
			$this->db->update('companies', $c);
			$ids[] = $c->id;
		}

		$this->db->flush_cache();
		$this->db->where_in('id', $ids);
		$this->db->from('companies');
		$query = $this->db->get();
		$this->response(array('results'=>$query->result(), 'count'=>count($ids)), 200);
	}

	public function index_delete() {
		$posted = json_decode($this->delete('models'));

		foreach($posted as $c) {
			$this->db->where('id', $c->id);
			$this->db->delete('companies');
			$ids[] = $c->id;
		}
		$this->response(array('results'=>array(), 'count'=>count($ids)), 200);
	}
}
