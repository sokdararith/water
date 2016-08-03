<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Itemrecord extends DataMapper {
	protected $created_field = "created_at";
	protected $updated_field = "updated_at";
	public $table = 'irecords';
	public $has_one = array(
		'item' => array(
			'class' => 'item',
			'other_field' => 'itemcord'
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

/* End of file item.php */
/* Location: ./application/models/item.php */