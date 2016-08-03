<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Administrator extends CI_Model {
	public function __construct($id = null) {
		parent::__construct($id);
	}

	public function addUser($user_data) {
		$ids = array();
		foreach($user_data as $d) {
			$data = array(
				'username' => $d->username,
				'password' => $this->_encrypt($d->password)
			);
			$this->db->insert('admins', $data);
			$ids[] = $this->db->insert_id();
		}
		
		$query = $this->db->where_in($ids)->get('Admin');
		return $query->result();
	}

	public function updateUser($user_date) {
		foreach($user_data as $admin) {
			$ids[] = $admin->id;
			$this->db->where('id', $admin->id);
			$this->db->update('admins', $admin);
		}

		$this->db->flush_cache();
		$this->db->where_in('id', $ids);
		$query = $this->db->get('admins');
		return $query->result();
	}

	private function _encrypt($data) {
		$addSalt = $data . $this->config->item('encryption_key');;
		return hash('sha256', $addSalt);
	}
}

/* End of file user.php */
/* Location: ./application/models/user.php */