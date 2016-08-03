<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Institute extends DataMapper {
	
	protected $created_field = 'created_on';
	protected $updated_field = 'updated_on';
	public $has_one = array(
		"connection" => array(
			'class' => 'connection',
			'other_field' => 'institute'
		),
		"industry" => array(
			'class' => 'industry',
			'other_field' => 'institute'
		),
		"country" => array(
			'class' => 'country',
			'other_field' => 'institute'
		),
		"province" => array(
			'class' => 'province',
			'other_field' => 'institute'
		),
		"type" => array(
			"class" => "institute_type",
			"other_field" => "institute"
		)	
	);
	public $has_many = array('login', 'module');

	public function __construct() {	
		parent::__construct();
	}
}

/* End of file institute.php */
/* Location: ./application/models/institute.php */