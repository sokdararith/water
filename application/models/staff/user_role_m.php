<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class User_Role_m extends MY_Model {
	public $_table 			= "user_roles";
	
	public $before_create 	= array( 'created_at', 'updated_at' );
	public $before_update 	= array( 'updated_at' );
}