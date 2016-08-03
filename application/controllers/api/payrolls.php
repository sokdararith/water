<?php defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH.'/libraries/REST_Controller.php';

class Payrolls extends REST_Controller {
	
	function __construct() {
		parent::__construct();
		$this->load->model('salary_m', 'salary');
		$this->load->model('staff/employee_m', 'emp');
		$this->load->model('payroll_m', 'payroll');
	}

		//get operation for all salaries if there is no id pass
	function index_get($id="") {
		$query;
		if( $id != "" ) {
			$query = $this->payroll->get_by(array("id"=>$id,"paid"=>0));
			$payroll[] = array(
				"id"			=> $query->id,
				"staff"			=> $this->emp->get($query->staff_id),
				"amount"		=> $query->amount,
				"exchange_rate"	=> $query->exchange_rate,
				"advance_deduction"=> $query->advance_deduction,
				"date"			=> $query->date,
				"paid"			=> $query->paid
			);
			$this->response($payroll, 200);
		} else {
			$query = $this->payroll->get_many_by("paid", 0);
			foreach($query as $q) {
				$payroll[] = array(
					"id"			=> $q->id,
					"staff"			=> $this->emp->get($q->staff_id),
					"amount"		=> $q->amount,
					"exchange_rate"	=> $q->exchange_rate,
					"dependents"	=> $this->db->select("dependents")->where("staff_id",$q->staff_id)->limit(1)->get("staff_salaries")->result(),
					"advance_deduction"=> $q->advance_deduction,
					"date"			=> $q->date,
					"paid"			=> $q->paid
				);
			}
			$this->response($payroll, 200);
		}	
	}

	function index_post() {
		$staff = $this->post('staff');
		$data = array(
					"staff_id"		=> $staff['id'],
					"gross_salary" 	=> $this->post('gross_salary'),
					"dependents"	=> $this->post('dependents'),
					"benefit"		=> $this->post('benefit')
				);
		$id = $this->salary->insert($data);

		if (!empty($id)) {
			$query = $this->salary->get_by('id', $id);
			if( !empty($query) ) {
				$data = array(
					"id"			=> $query->id,
					"staff"			=> $this->emp->get($query->staff_id),
					"gross_salary" 	=> $query->gross_salary,
					"dependents"	=> $query->dependents,
					"benefit"		=> $query->benefit
			);
			$this->response($data, 200);
			} else {
				$message = array(
						"status" => "error",
						"message"=> "Cannot insert your data."
				);
				$this->response($message, 400);
			}
		}
	}

	function index_put() {
		$staff = $this->put('staff');
		$data	= array(
			"staff_id" 	=> $staff['id'],
			"amount"	=> $this->put('amount'),
			"advance_deduction" => $this->put('advance_deduction')
		);

		$result = $this->payroll->update($this->put('id'), $data);
		if($result) {
			$query = $this->payroll->get($this->put('id'));
			$payroll[] = array(
				"id"			=> $query->id,
				"staff"			=> $this->emp->get($query->staff_id),
				"amount"		=> $query->amount,
				"exchange_rate"	=> $query->exchange_rate,
				"advance_deduction"=> $query->advance_deduction,
				"date"			=> $query->date,
				"paid"			=> $query->paid
			);
			$this->response($payroll, 200);
		} else {
			$this->response(array('status'=>"error",'message'=>"internal error"), 500);
		}
	}

	function generate_post() {
		$exchange_rate = $this->post('exchange_rate');
		if(!empty($exchange_rate) || $exchange_rate > 0) {
			$payrolls = $this->salary->get_all();
			foreach($payrolls as $payment) {
				$data[] = array(
					"staff_id"			=> $payment->staff_id,
					"amount" 			=> ($payment->gross_salary + $payment->benefit),
					"exchange_rate"		=> $exchange_rate,
					"advance_deduction"	=> 0,
					"date"				=> date('Y-m-d', strtotime(date(time()))),
					"paid" 				=> 0
				);
			}
			$this->payroll->insert_many($data);
			$this->response($data, 201);
		} else {
			$this->response(array('status'=>'error generating payroll', 'message'=>'Exchange rate cannot be empty or 0'), 400);
		}
	}

	function index_delete() {
		$id		= $this->delete('id');			
		$msg 	= $this->payroll->delete($id);
		$this->response(array("hi"=>"OK"), 200);
	}

}