<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Location extends DataMapper {
	protected $created_field = "created_at";
	protected $updated_field = "updated_at";

	public $has_one = array(
		"company" => array(
			"class" => "company", 
			"other_field" => "location"
		)		
	);

	public $has_many = array(		
		"invoice" => array(
			'class' => "invoice",
			'other_field' => 'location'
		),
		"meter" => array(
			'class' => "meter",
			'other_field' => 'location'
		),
		"electricity_box" => array(
			'class' => "electricity_box",
			'other_field' => 'location'
		),
		'elocation' => array(
			'class' => 'contact',
			'other_field' => 'elocation'
		),
		'wlocation' => array(
			'class' => 'contact',
			'other_field' => 'wlocation'
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

/* End of file location.php */
/* Location: ./application/models/location.php */