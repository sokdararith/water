<?php

class People_type_model extends MY_Model {
	
	public $_table = 'people_types';
	public $before_create = array( 'created_at', 'updated_at' );
    public $before_update = array( 'updated_at' );
		
}

