<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Entry extends DataMapper {
	public $table = 'entries';
	protected $created_field = "created_at";
	protected $updated_field = "updated_at";

	public $has_one = array('journal',
		'account' => array(
			'class' => 'account',
			'other_field' => 'entry'
		),
		'journal' => array(
			'class' => 'journal',
			'other_field' => 'entry'
		)
	);
	public $has_many = array("contact", 
		'segmentlist' => array(
			'class' => 'segmentlist',
			'other_field' => 'entry'
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

/* End of file entry.php */
/* Location: ./application/models/entry.php */