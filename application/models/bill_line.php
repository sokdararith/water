<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Bill_line extends DataMapper {
	public $table = "bill_items";

	public $has_one = array(
		'bill' => array(
			'class' => 'bill',
			'other_field' => 'bill_line'
		),
		'item' => array(
			'class' => 'item',
			'other_field' => 'bill_line'
		),
		'account' => array(
			'class' => 'account',
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
/* End of file segmentlist.php */
/* Location: ./application/models/segmentlist.php */