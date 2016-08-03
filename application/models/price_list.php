<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Price_list extends DataMapper {	
	protected $created_field = "created_at";
	protected $updated_field = "updated_at";

	public $has_one = array(
		'measurement' => array(
			'class' => 'measurement',
			'other_field' => 'price_list'
		),
		'item' => array(
			'class' => 'item',
			'other_field' => 'price_list'
		),
		'assembly' => array(
			'class' => 'item',
			'other_field' => 'assembly'
		),
		'currency' => array(
			'class' => 'currency',
			'other_field' => 'price_list'
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

/* End of file currency.php */
/* Location: ./application/models/currency.php */