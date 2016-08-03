<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Token extends DataMapper {
	protected $created_field = 'created_at';
	protected $updated_field = 'updated_at';
	public $has_one = array('user');
	function __construct() {
		parent::__construct();
	}
}

/* End of file token.php */
/* Location: ./application/models/token.php */