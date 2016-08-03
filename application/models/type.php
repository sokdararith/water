<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Type extends DataMapper {
	public $has_many = array('login');

	public function __construct() {	
		parent::__construct();
	}
}

/* End of file type.php */
/* Location: ./application/models/type.php */