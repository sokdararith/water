<?php defined('BASEPATH') OR exit('No direct script access allowed');


require APPPATH.'/libraries/REST_Controller.php';

class Inventory_api extends REST_Controller {
	
	//CONSTRUCTOR
	function __construct() {
		parent::__construct();
		$this->load->model('inventories/item_model', 'item');		
		$this->load->model('inventories/item_type_model', 'item_type');
		$this->load->model('inventories/meter_model', 'meter');
		$this->load->model('inventories/breaker_model', 'breaker');
		$this->load->model('inventories/meter_record_model', 'meter_record');
		$this->load->model('inventories/unit_measure_model', 'unit_measure');
		$this->load->model('inventories/electricity_pole_model', 'electricity_pole');
		$this->load->model('inventories/electricity_box_model', 'electricity_box');

		$this->load->model('inventory/item_record_model', 'item_record');
		$this->load->model('accounting/account_model', 'account');
		$this->load->model('inventory/item_receipt_model', 'item_receipt');
		$this->load->model("customers/people_model", "people");
		$this->load->model('accounting/payment_term_model', 'payment_term');
		$this->load->model('accounting/journal_model', 'journal');
		$this->load->library('session');
	}
	
	
	
	/* --- ITEM --- */
	
	//GET 
	function item_get() {
		$item_type_id = $this->get('item_type_id');		
		if(!empty($item_type_id) && isset($item_type_id)){
			$data = $this->item->get_many_by('item_type_id', $item_type_id);			
		}else{
			$data = $this->item->get_all();	
		}					
		$this->response($data, 200);		
	}
	
	//POST
	function item_post() {		
		$this->item->insert($this->post());
		//$this->response($this->post(), 200);				
	}
	
	//PUT
	function item_put() {
		$this->item->update($this->put('id'), $this->put());
	}
	
	//DELETE
	function item_delete() {
		//$this->response(array("status"=>$this->delete('id')), 200);
		$this->item->delete($this->delete('id'));
	}
	
	
	
	/* --- ITEM RECORD --- */
	
	//GET 
	function item_record_get() {
		$filter = $this->get("filter");		
		if(!empty($filter) && isset($filter)){
			$data = $this->item_record->get_many_by(array('item_id'	=>$filter['filters'][0]['value'],
		  											   	  'status'	=>1));	
		}else{
			$data = $this->item_record->get_all();	
		}					
		$this->response($data, 200);		
	}
	
	//POST
	function item_record_post() {		
		$this->item->insert($this->post());
		//$this->response($this->post(), 200);				
	}
	
	//PUT
	function item_record_put() {
		$this->item->update($this->put('id'), $this->put());
	}
	
	//DELETE
	function item_record_delete() {
		//$this->response(array("status"=>$this->delete('id')), 200);
		$this->item_record->delete($this->delete('id'));
	}	
	
		
		
	/* --- ITEM TYPE --- */
	
	//GET 
	function item_type_get() {
		$data = $this->item_type->get_all();		
		$this->response($data, 200);
	}
	
	//POST
	function item_type_post() {			
		$this->item_type->insert($this->post());
		//$this->response($this->post(), 200);		
	}
	
	//PUT
	function item_type_put() {
 		 $this->item_type->update($this->put('id'), $this->put());
	}
	
	//DELETE
	function item_type_delete() {
		//$this->response(array("status"=>$this->delete('id')), 200);
		$this->item_type->delete($this->delete('id'));
	}
	
	
	
	/* --- METER --- */
	
	//GET 
	function meter_get() {
		$filter = $this->get("filter");		
		if(!empty($filter) && isset($filter)){			
			$arr = $this->meter->get_customer_meter_with_type($filter['filters'][0]['value'])->get_all();
			$counter = count($arr);
			if($counter >0){
				foreach($arr as $row) {				  
					$data[] = array('id' 				=> $row->id,
								   'status' 			=> $row->status,
								   'ear_sealed' 		=> $row->ear_sealed,
								   'cover_sealed'		=> $row->cover_sealed,
								   'customer_id' 		=> $row->customer_id,
								   'item_id' 			=> $row->item_id,
								   'item_record_id'		=> $row->item_record_id,
								   'electricity_box_id'	=> $row->electricity_box_id,
								   'date_used' 			=> $row->date_used,
								   'company_id'			=> $row->company_id,
								   'typeName'			=> $row->typeName,
								   'itemName'			=> $row->itemName,
								   'box_no'				=> $row->box_no,
								   'electricity_pole_id'=> $row->electricity_pole_id,
								   'area_id'			=> $row->area_id,
								   'meter_records'		=> $this->meter_record->order_by("id", "desc")->limit(1)->get_by('meter_id', $row->id),
								   'avg'				=> $this->meter_record->get_avg($row->id)
							  );	
				}
				$this->response($data, 200);		
			}else{
				$this->response(FALSE, 200);
			}
		}else{
			$data = $this->meter->get_all();
			$this->response($data, 200);
		}	
	}
	
	//POST
	function meter_post() {
		$arr = array('status' 				=> $this->post('status'),
					 'ear_sealed' 			=> $this->post('ear_sealed'),
					 'cover_sealed'			=> $this->post('cover_sealed'),
					 'customer_id' 			=> $this->post('customer_id'),
					 'item_id' 				=> $this->post('item_id'),
					 'item_record_id'		=> $this->post('item_record_id'),
					 'electricity_box_id'	=> $this->post('electricity_box_id'),
					 'date_used' 			=> $this->post('date_used'),
					 'company_id'			=> $this->post('company_id')
		);			
		$this->meter->insert($arr);
		//$this->response($this->post(), 200);	
		
		//Update item
		$witdrawItem = $this->item->get_by('id', $this->post('item_id'));
		$qty = $witdrawItem->quantity;
		$qty -= 1;
		$this->item->update($this->post('item_id'), array('quantity'=>$qty) );
		
		//Update item record
		$this->item_record->update($this->post('item_record_id'), array('status'=>0) );			
	}
	
	//PUT
	function meter_put() {
		$arr = array('status' 				=> $this->put('status'),
					 'ear_sealed' 			=> $this->put('ear_sealed'),
					 'cover_sealed'			=> $this->put('cover_sealed'),
					 'customer_id' 			=> $this->put('customer_id'),
					 'item_id' 				=> $this->put('item_id'),
					 'item_record_id'		=> $this->put('item_record_id'),
					 'electricity_box_id'	=> $this->put('electricity_box_id'),
					 'date_used' 			=> $this->put('date_used'),
					 'company_id'			=> $this->put('company_id')
		);		
		$this->meter->update($this->put('id'), $arr);
	}
	
	//DELETE
	function meter_delete() {
		//$this->response(array("status"=>$this->delete('id')), 200);
		$this->meter->delete($this->delete('id'));
	}
	
	
	
	/* --- BREAKER --- */
	
	//GET 
	function breaker_get() {
		$filter = $this->get("filter");		
		if(!empty($filter) && isset($filter)){
			//$data = $this->breaker->get_many_by('customer_id', $filter['filters'][0]['value']);	
			$data = $this->breaker->get_customer_breaker_with_type($filter['filters'][0]['value']);	
		}else{
			$data = $this->breaker->get_all();
		}							
		$this->response($data, 200);		
	}
	
	//POST
	function breaker_post() {
		$arr = array('status' 			=> $this->post('status'),
					 'customer_id' 		=> $this->post('customer_id'),
					 'item_id' 			=> $this->post('item_id'),
					 'item_record_id'	=> $this->post('item_record_id'),
					 'date_used' 		=> $this->post('date_used'),
					 'company_id'		=> $this->post('company_id')
		);		
		$this->breaker->insert($arr);		
		//$this->response($this->post(), 200);
		
		//Update item
		$witdrawItem = $this->item->get_by('id', $this->post('item_id'));
		$qty = $witdrawItem->quantity;
		$qty -= 1;
		$this->item->update($this->post('item_id'), array('quantity'=>$qty) );
		
		//Update item record
		$this->item_record->update($this->post('item_record_id'), array('status'=>0) );				
	}
	
	//PUT
	function breaker_put() {
		$arr = array('status' 			=> $this->put('status'),
					 'customer_id' 		=> $this->put('customer_id'),
					 'item_id' 			=> $this->put('item_id'),
					 'item_record_id'	=> $this->put('item_record_id'),
					 'date_used' 		=> $this->put('date_used'),
					 'company_id'		=> $this->put('company_id')
		);	
		$this->breaker->update($this->put('id'), $arr);
	}
	
	//DELETE
	function breaker_delete() {
		//$this->response(array("status"=>$this->delete('id')), 200);
		$this->breaker->delete($this->delete('id'));
	}
	
	
	
	/* --- UNIT MEASURE --- */
	
	//GET 
	function unit_measure_get() {
		$data = $this->unit_measure->get_all();		
		$this->response($data, 200);
	}
	
	//POST
	function unit_measure_post() {			
		$this->unit_measure->insert($this->post());
		//$this->response($this->post(), 200);		
	}
	
	//PUT
	function unit_measure_put() {
 		 $this->unit_measure->update($this->put('id'), $this->put());
	}
	
	//DELETE
	function unit_measure_delete() {
		//$this->response(array("status"=>$this->delete('id')), 200);
		$this->unit_measure->delete($this->delete('id'));
	}
	
	
	
	/* --- ELECTRICITY POLE --- */
	
	//GET 
	function electricity_pole_get() {
		$filter = $this->get("filter");		
		if(!empty($filter) && isset($filter)){
			$data = $this->electricity_pole->get_many_by('area_id', $filter['filters'][0]['value']);	
		}else{
			$data = $this->electricity_pole->get_all();	
		}					
		$this->response($data, 200);		
	}
	
	//POST
	function electricity_pole_post() {		
		$this->electricity_pole->insert($this->post());
		//$this->response($this->post(), 200);				
	}
	
	//PUT
	function electricity_pole_put() {
		$this->electricity_pole->update($this->put('id'), $this->put());
	}
	
	//DELETE
	function electricity_pole_delete() {
		//$this->response(array("status"=>$this->delete('id')), 200);
		$this->electricity_pole->delete($this->delete('id'));
	}	
	
	
	
	/* --- ELECTRICITY BOX --- */
	
	//GET 
	function electricity_box_get() {
		$filter = $this->get("filter");		
		if(!empty($filter) && isset($filter)){
			$data = $this->electricity_box->get_many_by('electricity_pole_id', $filter['filters'][0]['value']);	
		}else{
			$data = $this->electricity_box->get_all();	
		}					
		$this->response($data, 200);		
	}
	
	//POST
	function electricity_box_post() {		
		$this->electricity_box->insert($this->post());
		//$this->response($this->post(), 200);				
	}
	
	//PUT
	function electricity_box_put() {
		$this->electricity_box->update($this->put('id'), $this->put());
	}
	
	//DELETE
	function electricity_box_delete() {
		//$this->response(array("status"=>$this->delete('id')), 200);
		$this->electricity_box->delete($this->delete('id'));
	}	
	
	
	
} //End Class