<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Account extends DataMapper {
	protected $created_field = "created_at";
	protected $updated_field = "updated_at";

	public $has_one = array("account_type",
		'parent' => array(
			'class' => "account",
			'other_field' => 'account'
		)
	);

	public $has_many = array(
		'entry' => array(
			'class' => 'entry',
			'other_field' => 'account'
		),
		'contact',
		'income' => array(
			'class' => 'item',
			'other_field' => 'income_account'
		),
		'cogs' => array(
			'class' => 'item',
			'other_field' => 'cogs_account'
		),
		'inventory' => array(
			'class' => 'item',
			'other_field' => 'inventory_account'
		),
		'account' => array(
			'class' => 'account',
			'other_field' => 'parent'
		),
		'contact' => array(
			'class' => 'contact',
			'other_field' => 'contact_account'
		),
		'discount' => array(
			'class' => 'contact',
			'other_field' => 'discount_account'
		),
		'deposit' => array(
			'class' => 'contact',
			'other_field' => 'deposit_account'
		),
		'bill',
		'item' => array(
			'class' => 'bill_line',
			'other_field' => 'account'
		)
	);

	// public $validation = array(
	// 		'code' => array(
	// 			'label' => 'Account Code',
	// 			'roles' => array('required', 'unique')
	// 		),
	// 		'name' => array(
	// 			'label' => 'Account Name',
	// 			'roles' => array('required', 'unique')
	// 		)
	// 	);

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

/* End of file account.php */
/* Location: ./application/models/account.php */