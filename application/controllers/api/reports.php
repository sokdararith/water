<?php defined('BASEPATH') OR exit('No direct script access allowed');


require APPPATH.'/libraries/REST_Controller.php';

class Reports extends REST_Controller {
	
	public $_database;
	//CONSTRUCTOR
	function __construct() {
		parent::__construct();
		$institute = new Institute();
		$institute->where('name', $this->input->get_request_header('Entity'))->get();
		if($institute->exists()) {
			$conn = $institute->connection->get();
			// $this->entity = $conn->server_name;
			// $this->user = $conn->user;
			// $this->pwd = $conn->password;	
			$this->_database = $conn->inst_database;
		}
	}

	public function ap_get() {}

	public function ar_get() {}

	public function billAging_get() {}

	// public function vendor_aging_summaries_get() {
	// 	$Date = strtotime($this->get("as_of"));
	// 	$class = $this->get("class_id");
	// 	$as_of = date("Y-m-d", $Date);
	// 	$vendors;

	// 	$this->benchmark->mark('bench_start');
	// 	$vendors = $this->people->vendor('active')->get_all();
	// 	if(count($vendors) > 0) {
	// 		foreach($vendors as $vendor) {
	// 			$data['vendors'][] = array(
	// 					"vendor_id" 	=> $vendor->id,
	// 					"vendor_name" 	=> $vendor->name,
	// 					"vendor_surname"=> $vendor->surname,
	// 					"vendor_company"=> $vendor->company,
	// 					"aging_report" 	=> $this->people->vendor_aging_report($vendor->id, $as_of, $class)
	// 				);
	// 		}
	// 	}
	// 	$this->benchmark->mark('bench_end');
	// 	$data['count'] = count($vendors);
	// 	$data['generated_in'] = $this->benchmark->elapsed_time('bench_start', 'bench_end');
	// 	$this->response($data, 200);
	// }

	// public function profit_loss_get() {
	// 	$filter = $this->get("filter");
	// 	$pl = array();
		
	// 	$income = $this->journal_entry->get_accounts('income', $filter['filters'][0]['value'], $filter['filters'][1]['value'], $filter['filters'][2]['value']);
		
	// 	$expense = $this->journal_entry->get_accounts('expense', $filter['filters'][0]['value'], $filter['filters'][1]['value'], $filter['filters'][2]['value']);

		
	// 	$this->response(array($income,$expense), 200);
	// }

	// public function balance_sheet_get() {

	// 	//$asset_accounts = $this->journal_entry->get_accounts(1);
	// 	$filter = $this->get('filter');

	// 	$asset = $this->journal_entry->get_accounts('asset', $filter['filters'][0]['value'], $filter['filters'][1]['value']);
	// 	$liability = $this->journal_entry->get_accounts('liability', $filter['filters'][0]['value'], $filter['filters'][1]['value']);
	// 	$equity = $this->journal_entry->get_accounts('equity', $filter['filters'][0]['value'], $filter['filters'][1]['value']);


	// 	$this->response(array($asset, $liability, $equity), 200);
	// }

	// public function index_get() {
	// 	// $this->benchmark->mark('bench_start');
	// 	// $query['data'] = $this->journal->get_accounts(1);
	// 	// $this->benchmark->mark('bench_end');
	// 	// $query['query_generated'] = $this->benchmark->elapsed_time('bench_start', 'bench_end');
	// 	// $this->response($query, 200);
	// }
	
}