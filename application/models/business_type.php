<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Business_type extends DataMapper {
	var $table = "business_types";

	protected $created_field = "created_at";
	protected $updated_field = "updated_at";

	public $has_many = array(
		"contact" => array(
			'class' => 'contact',
			'other_field' => 'business_type'
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

/* End of file business_type.php */
/* Location: ./application/models/business_type.php */