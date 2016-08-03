<?php defined('BASEPATH') OR exit('No direct script access allowed');


require APPPATH.'/libraries/REST_Controller.php';

class Tariffs_api extends REST_Controller {
	
	//CONSTRUCTOR
	function __construct() {
		parent::__construct();
		$this->load->model('tariffs/Tariff_model', 'tariff');
		$this->load->model('tariffs/Tariff_item_model', 'tariff_item');
		$this->load->model('tariffs/Exemption_model', 'exemption');
	}
	
	
	
	/* --- TARIFF --- */
	
	//GET 
	function tariff_get() {
		//$data = $this->tariff->get_all();		
		$data = $this->tariff->get_tariff_with_currency();
		$this->response($data, 200);
	}
	
	//POST
	function tariff_post() {	
		$this->tariff->insert($this->post());		
	}
	
	//PUT
	function tariff_put() {
 		 $this->tariff->update($this->put('id'), $this->put());
	}
	
	//DELETE
	function tariff_delete() {
		//$this->response(array("status"=>$this->delete('id')), 200);
		$this->tariff->delete($this->delete('id'));
	}
	
	
	
	/* --- TARIFF ITEM --- */
	
	//GET 
	function tariff_item_get() {
		$data = $this->tariff_item->get_all();		
		$this->response($data, 200);
	}
	
	//POST
	function tariff_item_post() {	
		$this->tariff_item->insert($this->post());		
	}
	
	//PUT
	function tariff_item_put() {
 		 $this->tariff_item->update($this->put('id'), $this->put());
	}
	
	//DELETE
	function tariff_item_delete() {
		//$this->response(array("status"=>$this->delete('id')), 200);
		$this->tariff_item->delete($this->delete('id'));
	}
	
	
	
	/* --- EXEMPTION --- */
	
	//GET 
	function exemption_get() {
		$data = $this->exemption->get_all();		
		$this->response($data, 200);
	}
	
	//POST
	function exemption_post() {	
		$this->exemption->insert($this->post());		
	}
	
	//PUT
	function exemption_put() {
 		 $this->exemption->update($this->put('id'), $this->put());
	}
	
	//DELETE
	function exemption_delete() {
		//$this->response(array("status"=>$this->delete('id')), 200);
		$this->exemption->delete($this->delete('id'));
	}
	
	
	
	
	
	
}