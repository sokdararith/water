<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Item_record extends DataMapper {
	protected $created_field = "created_at";
	protected $updated_field = "updated_at";

	public $has_one = array(		
		'contact' => array(
			'class' => 'contact',
			'other_field' => 'item_record'
		),
		'currency' => array(
			'class' => 'currency',
			'other_field' => 'item_record'
		),		
		'item' => array(
			'class' => 'item',
			'other_field' => 'item_record'
		),
		'measurement' => array(
			'class' => 'measurement',
			'other_field' => 'item_record'
		),
		'invoice' => array(
			'class' => 'invoice',
			'other_field' => 'item_record'
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

/* End of file stock.php */
/* Location: ./application/models/stock.php */