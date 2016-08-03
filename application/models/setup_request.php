<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Setup_request extends DataMapper {
	public function __construct($id = null) {	
		$this->db_params = array(
				'dbdriver' => 'mysql',
				'pconnect' => true,
				'db_debug' => true,
				'cache_on' => false,
				'char_set' => 'utf8',
				'cachedir' => '',
				'dbcollat' => 'utf8_general_ci',
				'hostname' => 'localhost',
				'username' => 'root',
				'password' => '',
				'database' => 'banhji',
				'prefix'   => ''
			);
		parent::__construct($id);
	}
}

/* End of file Setup_request.php */
/* Location: ./application/models/Setup_request.php */