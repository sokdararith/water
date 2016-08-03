<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Credential_m extends MY_Model {

	public $_table = "login_credential";
	public $before_create = array( 'created_at', 'updated_at' );
	public $before_update = array( 'updated_at' );

	
}