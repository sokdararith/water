<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Institute_type extends DataMapper {
	public $table = 'institute_types';
	// protected $created_field = "created_at";
	// protected $updated_field = "updated_at";

	// public $has_one = array("account_type");

	public $has_many = array(
		'institute' => array(
			'class' => 'institute',
			'other_field' => 'type'
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

/* End of file country.php */
/* Location: ./application/models/country.php */