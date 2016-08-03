<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); //disallow direct access to this file
require APPPATH.'/libraries/REST_Controller.php';
class Settings extends REST_Controller {
	
	function __construct() {
		parent::__construct();
		$this->load->model('company_m', 'company');
		$this->load->model('setting_m', 'setting');
		$this->load->model('class_m', 'class');
		if($this->session->userdata('loggedin') !== TRUE) {
			//redirect('auth');
		}
	}
	function index_get() {
		$this->response($this->setting->get_all(), 200);
	}
	function index_put() {
		if($this->setting->update($this->put("id"), $this->put())){
			$this->response($this->setting->get($this->put("id")), 200);
		}
		
	}
	function companies_get() {
		$company = $this->company->current($this->session->userdata('company_id'))->get_all();

		if (!empty($company)) {
			$this->response($company, 200);
		} else {
			$api = array(
				"status" => "null"
			);
			$this->response($api, 200);
		}
	}

	function companies_post() {
		$data = array(
				"id" => $this->post('id'),
				"name"=> $this->post('name'),
				"year_founded"=> $this->post('year_founded'),
				"parent_id"	=> $this->session->userdata("company_id"),
				"operation_license"=>$this->post('operation_license'),
				"mobile" => $this->post('mobile'),
				"phone" =>$this->post('phone'),
				"representative"	=>$this->post('representative')
		);

		$id = $this->company->insert($data);
		if($id) {
			$result = $this->company->get($id);
			$this->response($result, 200);
		} else {
			$this->response(array("status"=>"error"), 400);
		}
	}

	function companies_put() {
		$update = array(
				"id" => $this->put('id'),
				"name"=> $this->put('name'),
				"year_founded"=> $this->put('year_founded'),
				"parent_id"	=> $this->put('parent_id'),
				"operation_license"=>$this->put('operation_license'),
				"mobile" => $this->put('mobile'),
				"phone" =>$this->put('phone'),
				"address" => $this->put('address'),
				"representative"	=>$this->put('representative')
		);
		$result = $this->company->update($this->put('id'), $update);
		if($result) {
			$company = $this->company->get($this->put('id'));
			$data = array(
				"id" => $company->id,
				"name"=> $company->name,
				"year_founded"=> $company->year_founded,
				"parent_id"	=> $company->parent_id,
				"operation_license"=>$company->operation_license,
				"sub" => $this->company->get_by('parent_id', $company->id),
				"mobile" => $company->mobile,
				"phone" =>$company->phone,
				"address"=>$company->address,
				"representative"	=>$company->representative
			);
			$this->response($data, 200);
		} else {
			$this->response(array("status"=>"error"), 400);
		}
	}

	public function companies_delete() {
		$del = $this->company->delete($this->delete("id"));
	}

	public function sub_companies_get() {
		$company = $this->company->get_sub($this->session->userdata('company_id'))->get_all();

		if (!empty($company)) {
			$this->response($company, 200);
		} else {
			$api = array(
				"status" => "null"
			);
			$this->response($api, 200);
		}
	}

	public function config_get() {
		$data = $this->setting->get_by('company_id', $this->session->userdata('company_id'));

		if($data) {
			$this->response($data, 200);
		} else {
			$this->response(array("status"=>"error"), 400);
		}
	}
	public function config_put() {
		$id = $this->put('id');
		$data = array(
			"name" => $this->put('name'),
			"fiscal_year" => date('Y-m-d', strtotime($this->put('fiscal_year'))),
			"based_currency" => $this->put('based_currency')
		);
		$result = $this->setting->update($id, $data);

		if($result !== FALSE) {
			$criteria = array(
				'company_id'=>$this->session->userdata('company_id'),
				'id' => $id
			);
			$this->response($this->setting->get_by($criteria), 200);
		} else {
			$this->response(array("status"=>"error"), 400);
		}
	}

	public function classes_get() {
		// $types = array("Class", "Budget", "Donor", "Location");
		// if(in_array($type, $types, true)) {

		// } else {
		// 	$this->response(array("error"=>"Type passed is wrong.", "message"=>"Please make sure the type is in Capital letter and contains: Class, Budget, Donor, or Location."), 200);
		// }
		$query = $this->class->get_all();
		if( count($query)> 0 ) {
			$this->response($query, 200);
		} else {
			$this->response(array("error"=>"Error","message"=>"No data found."), 404);
		}
	}

	public function classes_post() {
		$data = array(
			"name" => $this->post('name'),
			"type" => $this->post('type')
		);

		$query = $this->class->insert($data);
		if($query > 0) {
			$this->response($this->class->get($query), 201);
		} else {
			$this->response(array("error"=>"Error","message"=>"Internal Error."), 500);
		}
	}

	public function classes_put() {
		$data = array(
			"name" => $this->put('name'),
			"type" => $this->put('type')
		);

		$query = $this->class->update($this->put('id'),$data);
		if($query > 0) {
			$this->response($this->class->get($query), 200);
		} else {
			$this->response(array("error"=>"Error","message"=>"Internal Error."), 500);
		}
	}
}
/* End of file settings.php */
/* Location: ./application/controllers/api/settings.php */