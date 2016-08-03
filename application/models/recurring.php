<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Recurring extends DataMapper {
	protected $created_field = "created_at";
	protected $updated_field = "updated_at";

	// public $has_one = array("account_type",
	// 	'parent' => array(
	// 		'class' => "account",
	// 		'other_field' => 'account'
	// 	)
	// );

	public $has_many = array(
		'item' => array(
			'class' => 'recurringitem',
			'other_field' => 'recurring'
		)
	);

	// public $validation = array(
	// 		'code' => array(
	// 			'label' => 'Account Code',
	// 			'roles' => array('required', 'unique')
	// 		),
	// 		'name' => array(
	// 			'label' => 'Account Name',
	// 			'roles' => array('required', 'unique')
	// 		)
	// 	);

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

/* End of file account.php */
/* Location: ./application/models/account.php */