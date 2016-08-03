<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Journal extends DataMapper {
	protected $created_field = "created_at";
	protected $updated_field = "updated_at";

	// public $has_one = array('contact');

	public $has_many = array("contact",
		'entry' => array(
			'class' => 'entry',
			'other_field' => 'journal'
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

/* End of file journal.php */
/* Location: ./application/models/journal.php */