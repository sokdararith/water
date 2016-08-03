<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Connection extends DataMapper {
	
	protected $created_field = 'created_on';
	protected $updated_field = 'updated_on';
	public $has_one = array(
		"institute"	=> array(
			'class' => 'institute',
			'other_field' => 'connection'
		)
	);

	public function __construct() {	
		parent::__construct();
	}
}

/* End of file connection.php */
/* Location: ./application/models/connection.php */