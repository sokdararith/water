<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Entity extends DataMapper {
	public $table = 'companies';
	protected $created_field = 'created_at';
	protected $updated_field = 'updated_at';
	// public $has_many = array('user', 'contact', 'fee');
	function __construct($id = null) {
		parent::__construct($id);
	}
}

/* End of file company.php */
/* Location: ./application/models/company.php */