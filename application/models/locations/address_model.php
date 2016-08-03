<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Address_model extends MY_Model {
	
	public $_table = 'addresses';
	
	public $before_create = array( 'created_at', 'updated_at' );
    public $before_update = array( 'updated_at' );
	
	
}
