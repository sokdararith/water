<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class DMEX extends DataMapper {	
	function __construct($id = null, $db = null) {
		if($db != null) {
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
				'database' => $db,
				'prefix'   => ''
			);
		}
	}
}

/* End of file test.php */
/* Location: ./application/models/test.php */