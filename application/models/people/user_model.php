<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_model extends MY_Model {
	public $before_create = array( 'created_at', 'updated_at' );
	public $before_update = array( 'updated_at' );
	
	//validating input
	public $validate = array(
		array( 'field' => 'email',
			   'label' => 'email',
			   'rules' => 'required|valid_email|is_unique[users.email]' ),
		array( 'field' => 'username',
			   'label' => 'username',
			   'rules' => 'required|is_unique[users.username]' )
	);

}