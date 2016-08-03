<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Meter_record extends DataMapper {
	protected $created_field = "created_at";
	protected $updated_field = "updated_at";

	public $has_one = array("meter", "invoice_line",
		'employee' => array(
			'class' => "employee",
			'other_field' => 'meter_record'
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

/* End of file meter_record.php */
/* Location: ./application/models/meter_record.php */