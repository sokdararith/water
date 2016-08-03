<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Province extends DataMapper {
	public $table = 'provinces';
	// protected $created_field = "created_at";
	// protected $updated_field = "updated_at";

	public $has_one = array(
		"country" => array(
			"class" => "country",
			"other_field" => "province"
		),
		"institute" => array(
			"class" => "institute",
			"other_field" => "province"
		)
	);

	// public $has_many = array(
	// 	'province' => array(
	// 		'class' => 'province',
	// 		'other_field' => 'country'
	// 	)
	// );

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

/* End of file province.php */
/* Location: ./application/models/province.php */