<?php defined('BASEPATH') OR exit('No direct script access allowed');


require APPPATH.'/libraries/REST_Controller.php';

class Invoice_items extends REST_Controller {
	
	//CONSTRUCTOR
	function __construct() {
		parent::__construct();		
		$this->load->model('accounting/invoice_item_model', 'invoice_item');

		$this->load->model('inventory/item_model', 'item');
		$this->load->model('inventory/meter_model', 'meter');		
	}
	
	
	//GET 
	function invoice_item_get() {
		$filters = $this->get("filter")["filters"];
		$logic = $this->get("filter")["logic"];
		$limit = $this->get("pageSize");
		$offset = $this->get('skip');
		$sorter = $this->get("sort");		
		$data["results"] = array();
		$data["total"] = 0;

		//Limit
		if(!empty($limit) && isset($limit)){
			$this->invoice_item->limit($limit, $offset);
		}

		//Sort
		if(!empty($sorter) && isset($sorter)){			
			$sort = array();
			foreach ($sorter as $row) {
				$sort += array($row["field"] => $row["dir"]);
			}			
			$this->invoice_item->order_by($sort);
		}

		if(!empty($filters) && isset($filters)){			
			$filter = array();			
			foreach ($filters as $row) {										
				$filter += array($row["field"] => $row["value"]);								
			}

			$data["results"] = $this->invoice_item->get_many_by($filter);
			$data["total"] = $this->invoice_item->count_by($filter);

			//Modify field
			foreach($data["results"] as $key => $row) {
				$row->vat = $row->vat === 'true'? true: false;
			}					
		}
		$this->response($data, 200);		
	}
	
	//POST
	function invoice_item_post() {		
		$post = json_decode($this->post('models'));

		foreach($post as $key => $value) {
			if($value->vat){
				$value->vat = 'true';
			}else{
				$value->vat = 'false';
			}			
		}

		$ids = $this->invoice_item->insert_many($post);
		$data["results"] = $this->invoice_item->get_many($ids);		

		$this->response($data, 201);						
	}
	
	//PUT
	function invoice_item_put() {		
		$put = json_decode($this->put('models'));

		$this->db->trans_start();
		foreach ($put as $key => $value) {
			if($value->vat){
				$value->vat = 'true';
			}else{
				$value->vat = 'false';
			}
			
			$this->invoice_item->update($value->id, $value);
		}
		$this->db->trans_complete();

		$data["status"] = $this->db->trans_status();
		$data["results"] = $put;
		
		$this->response($data, 200);
	}
	
	//DELETE
	function invoice_item_delete() {
		$del = json_decode($this->delete('models'));

		$this->db->trans_start();
		foreach ($del as $key => $value) {
			$this->invoice_item->delete($value->id);
		}
		$this->db->trans_complete();

		$data["status"] = $this->db->trans_status();		
		$data["results"] = $del;	

		$this->response($data, 200);
	}	

	//POST BATCH	
	function invoice_item_batch_post() {
		$post = json_decode($this->post('models'));							  
		$data = $this->invoice_item->insert_many($post);

		$this->response($data, 201);			
	}

	//DELETE BY
	function invoice_item_by_delete(){		
		$result = $this->invoice_item->delete_by('invoice_id',$this->delete('id'));
		$this->response($result, 200);
	}

	//POST MANY	
	function invoice_item_many_post() {
		$post = json_decode($this->post("data"));
		foreach($post as $key => $value) {			
				$data[] = $value;			
		}				  
		$ids = $this->invoice_item->insert_many($data);		 
		$this->response($ids, 201);			
	}	

	//DELETE BY INVOICE ID
	function invoice_item_by_invoice_id_delete() {		
		$result = $this->invoice_item->delete_by('invoice_id', $this->delete('id'));
		$this->response($result, 200);
	}

	//GET TOTAL AMOUNT INVOICE ITEM
	function total_amount_invoice_item_get(){
		$invoice_id = $this->get("invoice_id");
		if(!empty($invoice_id) && isset($invoice_id)){
			$data = $this->invoice_item->get_total_amount($invoice_id);
			$this->response($data, 200);
		}else{
			$this->response(FALSE, 200);
		}		
	}

	//GET INVOICE ITEM BY METER ID AND MONTH OF
	function by_meter_id_month_of_get(){
		$meterId = $this->get("meter_id");
		$monthOf = $this->get("month_of");

		$data = $this->invoice_item->by_meter_id_month_of($meterId, $monthOf);
		$this->response($data, 200);
	}

	
}//End Of Class