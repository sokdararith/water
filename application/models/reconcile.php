<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reconcile extends DataMapper {
	protected $created_field = "created_at";
	protected $updated_field = "updated_at";

	public $has_one = array(
		'company' => array(
			'class' => 'company',
			'other_field' => 'reconcile'
		)
	);

	public $has_many = array(
		"reconcile_item" => array(
			'class' => 'reconcile_item',
			'other_field' => 'reconcile'
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

/* End of file reconcile.php */
/* Location: ./application/models/reconcile.php */