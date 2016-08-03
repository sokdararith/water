<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Recurringitem extends DataMapper {
	// public $table = 'account_types';
	protected $created_field = 'created_at';
	protected $updated_field = 'updated_at';
	// public $has_many = array('account');
	public $has_one = array(
		'recurring' => array(
			'class' => 'recurring',
			'other_field' => 'item'
		)
	);

	public function __construct($id = null, $db = null) {	
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
		parent::__construct($id);
	}
}

/* End of file account_type.php */
/* Location: ./application/models/account_type.php */