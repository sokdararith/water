<?php

class Area_model extends MY_Model {
	
	public $_table = 'area';
	
	public $before_create = array( 'created_at', 'updated_at' );
    public $before_update = array( 'updated_at' );
		
}