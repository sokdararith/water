<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Invoice extends DataMapper {
	protected $created_field = "created_at";
	protected $updated_field = "updated_at";

	public $has_one = array("company", "currency", "payment_term", "payment_method", "location", "contact",		       
        'biller' => array(
            'class' => 'contact',
            'other_field' => 'biller_invoice'
        ) 
	);
	public $has_many = array(				
		'invoice_line',
		'item_record' => array(
            'class' => 'item_record',
            'other_field' => 'invoice'
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

/* End of file invoice.php */
/* Location: ./application/models/invoice.php */