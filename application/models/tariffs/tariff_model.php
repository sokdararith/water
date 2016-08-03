<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tariff_model extends MY_Model {
		
	public $before_create = array( 'created_at', 'updated_at' );
    public $before_update = array( 'updated_at' );
	
	
	//Get tariff with currency
	function get_tariff_with_currency()
	{
		$this->db->select('*');
		$this->db->from('tariffs');
		$this->db->join('currencies', 'currencies.id = tariffs.currency_id');
		
		$q = $this->db->get();
		
		if ( $q->num_rows() > 0 ) :
			return $q->result();
		endif;		
	}	
	
}