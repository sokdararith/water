<?php defined('BASEPATH') OR exit('No direct script access allowed');


require APPPATH.'/libraries/REST_Controller.php';

class Location_api extends REST_Controller {
	
	//CONSTRUCTOR
	function __construct() {
		parent::__construct();		
		$this->load->model('locations/Area_model', 'area');
		$this->load->model('locations/Address_model', 'address');
		$this->load->model('locations/Province_model', 'province');
		$this->load->model('locations/District_model', 'district');
		$this->load->model('locations/Commune_model', 'commune');
		$this->load->model('locations/Village_model', 'village');
	}
	
	
	
	/* --- AREA --- */
	
	//GET 
	function area_get() {
		$data = $this->area->get_all();		
		$this->response($data, 200);
	}
	
	//POST
	function area_post() {	
		$this->area->insert($this->post());		
	}
	
	//PUT
	function area_put() {
 		 $this->area->update($this->put('id'), $this->put());
	}
	
	//DELETE
	function area_delete() {
		//$this->response(array("status"=>$this->delete('id')), 200);
		$this->area->delete($this->delete('id'));
	}
	
	
	
	/* --- ADDRESS --- */
	
	//GET 
	function address_get() {
		$data = $this->address->get_all();		
		$this->response($data, 200);
	}
	
	//POST
	function address_post() {	
		$this->area->insert($this->post());		
	}
	
	//PUT
	function address_put() {
 		 $this->address->update($this->put('id'), $this->put());
	}
	
	//DELETE
	function address_delete() {
		//$this->response(array("status"=>$this->delete('id')), 200);
		$this->address->delete($this->delete('id'));
	}
	
	
	
	
	/* --- PROVINCE --- */
	
	//GET 
	function province_get() {
		$data = $this->province->get_all();		
		$this->response($data, 200);
	}
	
	//POST
	function province_post() {	
		$this->province->insert($this->post());		
	}
	
	//PUT
	function province_put() {
 		 $this->province->update($this->put('id'), $this->put());
	}
	
	//DELETE
	function province_delete() {
		//$this->response(array("status"=>$this->delete('id')), 200);
		$this->province->delete($this->delete('id'));
	}
		
	
	
	/* --- DISTRICT --- */
	
	//GET 
	function district_get() {		
		$data = $this->district->get_many_by(array("province_id"=>$this->get('value')));		
		$this->response($data, 200);
	}
	
	//POST
	function district_post() {	
		$this->district->insert($this->post());		
	}
	
	//PUT
	function district_put() {
 		 $this->district->update($this->put('id'), $this->put());
	}
	
	//DELETE
	function district_delete() {
		//$this->response(array("status"=>$this->delete('id')), 200);
		$this->district->delete($this->delete('id'));
	}
	
	
	
	/* --- COMMUNE --- */
	
	//GET 
	function commune_get() {
		$data = $this->commune->get_many_by(array("district_id"=>$this->get('value')));	
		$this->response($data, 200);
	}
	
	//POST
	function commune_post() {	
		$this->commune->insert($this->post());		
	}
	
	//PUT
	function commune_put() {
 		 $this->commune->update($this->put('id'), $this->put());
	}
	
	//DELETE
	function commune_delete() {
		//$this->response(array("status"=>$this->delete('id')), 200);
		$this->commune->delete($this->delete('id'));
	}
	
	
	
	
	/* --- VILLAGE --- */
	
	//GET 
	function village_get() {		
		$data = $this->village->get_many_by(array("commune_id"=>$this->get('value')));		
		$this->response($data, 200);
	}
	
	//POST
	function village_post() {	
		$this->village->insert($this->post());		
	}
	
	//PUT
	function village_put() {
 		 $this->village->update($this->put('id'), $this->put());
	}
	
	//DELETE
	function village_delete() {
		//$this->response(array("status"=>$this->delete('id')), 200);
		$this->village->delete($this->delete('id'));
	}
	
	
	
}