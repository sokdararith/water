<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Distribution_Area_model extends MY_Model {
	public $before_create = array( 'created_at', 'updated_at' );
	public $before_update = array( 'updated_at' );
}

/* End of file Distribution_Area_model.php */
/* Location: ./application/models/distribution_area_model.php */