<?php defined('BASEPATH') OR exit('No direct script access allowed');


require APPPATH.'/libraries/REST_Controller.php';

class Electricity_unit_api extends REST_Controller {
	
	//CONSTRUCTOR
	function __construct() {
		parent::__construct();		
		$this->load->model('electricity_units/Ampere_model', 'ampere');
		$this->load->model('electricity_units/Phase_model', 'phase');
		$this->load->model('electricity_units/Voltage_model', 'voltage');
		$this->load->model('electricity_units/Fuse_model', 'fuse');
	}
	
	
	
	/* --- Ampere --- */
	
	//GET 
	function ampere_get() {
		$data = $this->ampere->get_all();		
		$this->response($data, 200);
	}
	
	//POST
	function ampere_post() {	
		$this->ampere->insert($this->post());		
	}
	
	//PUT
	function ampere_put() {
 		 $this->ampere->update($this->put('id'), $this->put());
	}
	
	//DELETE
	function ampere_delete() {
		//$this->response(array("status"=>$this->delete('id')), 200);
		$this->ampere->delete($this->delete('id'));
	}
	
	
	
	/* --- Phase --- */
	
	//GET 
	function phase_get() {
		$data = $this->phase->get_all();		
		$this->response($data, 200);
	}
	
	//POST
	function phase_post() {	
		$this->phase->insert($this->post());		
	}
	
	//PUT
	function phase_put() {
 		 $this->phase->update($this->put('id'), $this->put());
	}
	
	//DELETE
	function phase_delete() {
		//$this->response(array("status"=>$this->delete('id')), 200);
		$this->phase->delete($this->delete('id'));
	}
	
	
	
	/* --- Voltage --- */
	
	//GET 
	function voltage_get() {
		$data = $this->voltage->get_all();		
		$this->response($data, 200);
	}
	
	//POST
	function voltage_post() {	
		$this->voltage->insert($this->post());		
	}
	
	//PUT
	function voltage_put() {
 		 $this->voltage->update($this->put('id'), $this->put());
	}
	
	//DELETE
	function voltage_delete() {
		//$this->response(array("status"=>$this->delete('id')), 200);
		$this->voltage->delete($this->delete('id'));
	}
	
		
	
	/* --- Fuse --- */
	
	//GET 
	function fuse_get() {
		$data = $this->fuse->get_all();		
		$this->response($data, 200);
	}
	
	//POST
	function fuse_post() {	
		$this->fuse->insert($this->post());		
	}
	
	//PUT
	function fuse_put() {
 		 $this->fuse->update($this->put('id'), $this->put());
	}
	
	//DELETE
	function fuse_delete() {
		//$this->response(array("status"=>$this->delete('id')), 200);
		$this->fuse->delete($this->delete('id'));
	}
	
	
	
	
}