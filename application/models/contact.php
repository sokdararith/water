<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contact extends DataMapper {
	protected $created_field = "created_at";
	protected $updated_field = "updated_at";

	public $has_one = array("user",
		"installment" => array(
			'class' => "installment",
			'other_field' => 'contact'
		),
		"company" => array(
			'class' => "company",
			'other_field' => 'contact'
		),		
		"currency" => array(
			'class' => "currency",
			'other_field' => 'contact'
		),
		"bank" => array(
			'class' => 'bank',
			'other_field' => 'contact'
		),		
		'contact_type' => array(
			'class' => 'contact_type',
			'other_field' => 'contact'
		),
		'payment_main' => array(
			'class' => 'payment_method',
			'other_field' => 'first_payment'
		),
		'payment_second' => array(
			'class' => 'payment_method',
			'other_field' => 'second_payment'
		),
		'business_type' => array(
			'class' => 'business_type',
			'other_field' => 'contact'
		),
		'contact_account' => array(
			'class' => 'account',
			'other_field' => 'contact'
		),
		'discount_account' => array(
			'class' => 'account',
			'other_field' => 'discount'
		),
		'deposit_account' => array(
			'class' => 'account',
			'other_field' => 'deposit'
		),
		'ebranch' => array(
			'class' => 'company',
			'other_field' => 'ebranch'
		),
		'wbranch' => array(
			'class' => 'company',
			'other_field' => 'wbranch'
		),
		'elocation' => array(
			'class' => 'location',
			'other_field' => 'elocation'
		),
		'wlocation' => array(
			'class' => 'location',
			'other_field' => 'wlocation'
		)
	);

	public $has_many = array("email", "address", "meter", "journal", 'entry', "invoice",
		'item' => array(
			'class' => 'item',
			'other_field' => 'contact'
		),
		'item_contact' => array(
			'class' => 'item_contact',
			'other_field' => 'contact'
		),
		'contact_person' => array(
			'class' => 'contact_person',
			'other_field' => 'contact'
		),
		'note' => array(
			'class' => 'note',
			'other_field' => 'contact'
		),
		'item_record' => array(
			'class' => 'item_record',
			'other_field' => 'contact'
		),
		'phone' => array(
			'class' => 'phone',
			'other_field' => 'contact'
		),			
		'biller_invoice' => array(
			'class' => 'invoice',
			'other_field' => 'biller'
		),
		"vendor" => array(
			'class' => 'item',
			'other_field' => 'preferred_vendor'
		),
		"bill" => array(
			"class" => "bill",
			"other_field" => "vendor"
		),
		"payment" => array(
			"class" => "payment",
			"other_field" => "contact"
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

/* End of file contact.php */
/* Location: ./application/models/contact.php */