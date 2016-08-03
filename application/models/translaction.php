<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Transaction extends DataMapper {
	protected $created_field = 'created_at';
	protected $updated_field = 'updated_at';
	public $has_many = array('jentry');

	function __construct($id = null, $company = null) {
		parent::__construct($id);
		$dsn = "dbdriver://root:''@hostname/".$company;
		$this->load->database($dsn);
	}	
}

/* End of file transaction.php */
/* Location: ./application/models/transaction.php */