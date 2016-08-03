<?php defined('BASEPATH') OR exit('No direct script access allowed');


require APPPATH.'/libraries/REST_Controller.php';

class Payments extends REST_Controller {
	
	//CONSTRUCTOR
	function __construct() {
		parent::__construct();		
		$this->load->model('accounting/payment_model', 'payment');
		$this->load->model('accounting/payment_method_model', 'payment_method');
		$this->load->model('accounting/invoice_model', 'invoice');
		$this->load->model('accounting/invoice_item_model', 'invoice_item');
		$this->load->model("people/people_model", "people");
		$this->load->model('inventory/meter_model', 'meter');
		$this->load->model('inventory/meter_record_model', 'meter_record');
		$this->load->model('inventory/electricity_box_model', 'electricity_box');		
	}

	function index_get() {
		$filter = $this->get("filter");	
		if($filter) {		
			$criteria = array();				
			for ($i = 0; $i < count($filter['filters']); ++$i) {
				if(isset($filter['filters'][$i]['operator']) && $filter['filters'][$i]['operator'] === 'or')	{
					$this->db->or_where($filter['filters'][$i]['field'], $filter['filters'][$i]['value']);
				}
				$this->db->where($filter['filters'][$i]['field'], $filter['filters'][$i]['value']);	
				$criteria += array($filter['filters'][$i]['field'] => $filter['filters'][$i]['value']);
			}
			$filterQuery = $this->db->get('bill_payments');
			if($filterQuery->num_rows()) {
				foreach($filterQuery->result() as $r) {
					$data[] = array(
						"id" 				=> $r->id,
						"bill_id"			=> $r->bill_id,
						"account_id" 		=> $r->account_id,
						"payment_method" 	=> $r->payment_method,
						"payment_note" 		=> $r->payment_note,
						"company_id" 		=> $r->company_id,
						"contact_id"		=> $r->contact_id,
						"user_id" 			=> $r->user_id,
						"taxed"				=> $r->taxed,
						"created_at"		=> $r->created_at,
						"updated_at" 		=> $r->updated_at
					);
	 			}
 				$this->response(array("status"=>"OK", "results"=>$data), 200);
			} else {
				$this->response(array("status"=>"false", "message"=>"There is no result found.", "results"=>array()), 200);
			}
		} else {
			$this->db->select('*');
			$this->db->where('id', $this->session->userdata('userData')->company_id);
			$query = $this->db->get('companies');

			$this->response(array("status"=>"false", "message"=>"company id is needed.", "results"=>$query->result()), 200);
		}
	}

	function index_post() {
		$jsonData = json_decode($this->post('models'));
		$date = new DateTime();
		foreach($jsonData as $row) {
			
			$this->db->insert('bill_payments', array(
				"bill_id"			=> $row->bill_id,
				"account_id" 		=> $row->account_id,
				"payment_method" 	=> $row->payment_method,
				"payment_note" 		=> $row->payment_note,
				"company_id" 		=> $row->company_id,
				"contact_id"		=> $row->contact_id,
				"user_id" 			=> $row->user_id,
				"taxed"				=> $row->taxed,
				"created_at" => strtotime('Y-m-d', $date->getTimestamp()),
				"updated_at" => strtotime('Y-m-d', $date->getTimestamp())
			));
			$id = $this->db->insert_id();
			$inserted[] = $id;
		}
		$this->db->select('*');
		$this->db->from('bill_payments');
		$this->db->where_in('id', $inserted);
		$query = $this->db->get();
		foreach($query->result() as $r) {
			$data[] = array(
				"id" 				=> $r->id,
				"bill_id"			=> $r->bill_id,
				"account_id" 		=> $r->account_id,
				"payment_method" 	=> $r->payment_method,
				"payment_note" 		=> $r->payment_note,
				"company_id" 		=> $r->company_id,
				"contact_id"		=> $r->contact_id,
				"user_id" 			=> $r->user_id,
				"taxed"				=> $r->taxed,
				"created_at"		=> $r->created_at,
				"updated_at" 		=> $r->updated_at
			);
		}
		$this->response(array('status'=>'OK', 'results'=>$data), 201);	
	}
	
	function index_put() {
		$data = $this->put('models');
		$jsonData = json_decode($data);
		$date = new DateTime();
		$this->benchmark->mark('benchmark_start');
		foreach($jsonData as $row) {
			$this->db->where('id', $row->id);
			$this->db->update('bill_payments', array(
				"amount_paid"=> $row->amount_paid,
				"taxed"=>$row->taxed,
				"updated_at" => strtotime('Y-m-d', $date->getTimestamp())
			));
			$inserted = $row->id;
		}
		$this->db->select('*')
				 ->from('bill_payments')
				 ->where('id', $inserted);
		$query = $this->db->get();
		if($query->num_rows() > 0) {
			foreach($query->result() as $row) {
				$data = $row;
			}
			$this->benchmark->mark('benchmark_end');			
			$this->response(array('status'=>'OK', 'msg'=>'result found.', 'results'=>$data, 'generatedIn'=>$this->benchmark->elapsed_time('benchmark_start', 'benchmark_end')), 200);	
		} else {
			$this->benchmark->mark('benchmark_end');
			$this->response(array('status'=>'Error', 'msg'=>'result not found.','results'=>array(), 'generatedIn'=>$this->benchmark->elapsed_time('benchmark_start', 'benchmark_end')), 200);	
		}
	}
	
	function index_delete() {
		$data = $this->delete('models');
		$jsonData = json_decode($data);
		$count = 0;
		foreach($jsonData as $r) {
			$this->db->where('id', $r->id);
			$this->db->update('bill_payments', array('deleted'=>1));
			$count++;
		}
		$this->response(array('status'=>'OK', 'results'=>array(), 'count'=>$count), 301);
	}
	
	//GET 
	function payment_get() {
		$filters = $this->get("filter")["filters"];
		//$logic = $this->get("filter")["logic"];
		$limit = $this->get("pageSize");
		$offset = $this->get('skip');
		$sorter = $this->get("sort");
		$data["results"] = array();
		$data["total"] = 0;

		// //Limit
		if(!empty($limit) && isset($limit)){
			$this->payment->limit($limit, $offset);
		}

		//Sort
		if(!empty($sorter) && isset($sorter)){			
			$sort = array();
			foreach ($sorter as $row) {
				$sort += array($row["field"] => $row["dir"]);
			}			
			$this->payment->order_by($sort);
		}

		if(!empty($filters) && isset($filters)){
			$filter = array();			
			foreach ($filters as $row) {										
				$filter += array($row["field"] => $row["value"]);								
			}

			$data["results"] = $this->payment->get_many_by($filter);
			$data["total"] = $this->payment->count_by($filter);
		}
		$this->response($data, 200);		
	}
	
	//POST
	function payment_post() {
		$post = array(
			"invoice_id" 		=> $this->post("invoice_id"),
			"amount_paid" 		=> $this->post("amount_paid"),
			"rate" 				=> $this->post("rate"),
			"fine" 				=> $this->post("fine"),
			"sub_code" 			=> $this->post("sub_code"),
			"payment_date" 		=> date("Y-m-d", strtotime($this->post("payment_date"))),			
			"payment_method_id" => $this->post("payment_method_id"),
			"check_no" 			=> $this->post("check_no"),
			"cash_account_id" 	=> $this->post("cash_account_id"),
			"payment_note" 		=> $this->post("payment_note"),
			"cashier" 			=> $this->post("cashier"),
			"customer_id" 		=> $this->post("customer_id"),
			"class_id" 			=> $this->post("class_id")						
		);

		$id = $this->payment->insert($post);
		$data["results"] = $this->payment->get($id);

		$this->response($data, 201);					
	}
	
	//PUT
	function payment_put() {
		$put = array(
			"invoice_id" 		=> $this->put("invoice_id"),
			"amount_paid" 		=> $this->put("amount_paid"),
			"rate" 				=> $this->put("rate"),
			"fine" 				=> $this->put("fine"),
			"sub_code" 			=> $this->put("sub_code"),
			"payment_date" 		=> date("Y-m-d", strtotime($this->post("payment_date"))),			
			"payment_method_id" => $this->put("payment_method_id"),
			"check_no" 			=> $this->put("check_no"),
			"cash_account_id" 	=> $this->put("cash_account_id"),
			"payment_note" 		=> $this->put("payment_note"),
			"cashier" 			=> $this->put("cashier"),
			"customer_id" 		=> $this->put("customer_id"),
			"class_id" 			=> $this->put("class_id")						
		);
		$data["status"] = $this->payment->update($this->put('id'), $put);		
		$data["results"] = $this->payment->get($this->put('id'));
				
		$this->response($data, 200);
	}
	
	//DELETE
	function payment_delete() {		
		$data["results"] = $this->payment->get($this->delete("id"));		
		$data["status"] = $this->payment->delete($this->delete("id"));
				
		$this->response($data, 200);
	}

	//GET PAYMENT FOR CASHIER 
	function payment_for_cashier_get() {
		$cashier = $this->get("cashier");
		$payment_date = $this->get("payment_date");

		$data = array('total_customer'	=> $this->payment->count_customer($cashier, $payment_date),					
					'total_payment' 		=> $this->payment->sum_payment($cashier, $payment_date)									 
		);
		$this->response($data, 200);
	}

	//POST BATCH	
	function payment_batch_post() {
		$post = $this->post();

		//Remove model
		foreach($post as $key => $value) {			
			$data[] = $value;									
		}
				
		$ids = $this->payment->insert_many($data);		 
		$this->response($ids, 200);			
	}

	//PAYMENT FOR EDIT
	function payment_for_edit_get(){
		$filter = $this->get("filter");		
		if(!empty($filter) && isset($filter)){			
			$para = array();				
			for ($i = 0; $i < count($filter['filters']); ++$i) {				
				$para += array($filter['filters'][$i]['field'] => $filter['filters'][$i]['value']);
			}			
			$data = $this->payment->get_many_by($para);
			$this->response($data, 200);
		}
	}

	function daily_payment_get() {
		$start_date = $this->get("start_date");		
		$end_date = $this->get("end_date");
		$cashier = $this->get("cashier");

		$data["results"] = array();
		$data["total"] = 0;

		$strQuery = "SELECT payments.*, 
					people.number AS peopleNumber, people.surname, people.name, people.people_type_id,
					invoices.number AS invoiceNumber, invoices.amount
					FROM payments
					INNER JOIN people ON people.id = payments.customer_id 
					INNER JOIN invoices ON invoices.id = payments.invoice_id
					";

		//Execute query
		$query = $this->db->query($strQuery);		

		$data["results"] = $query->result();		
		$data["total"] = count($data["results"]);
		$this->response($data, 200);		
	}
	
}//End Of Class