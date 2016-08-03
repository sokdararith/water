<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); //disallow direct access to this file

require APPPATH.'/libraries/REST_Controller.php';

class Sales extends REST_Controller {	
	// public $entity;
	// public $user;
	public $_database;
	// public $pwd;
	//CONSTRUCTOR
	function __construct() {
		parent::__construct();
		// $this->input->get_request_header('Entity');
		// $this->input->get_request_header('User');
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

	//GET 
	function index_get() {		
		$filters 	= $this->get("filter")["filters"];		
		$page 		= $this->get('page') !== false ? $this->get('page') : 1;		
		$limit 		= $this->get('limit') !== false ? $this->get('limit') : 100;								
		$sort 	 	= $this->get("sort");		
		$data["results"] = array();
		$data["count"] = 0;

		$obj = new Invoice(null, $this->_database);		

		if(!empty($sort) && isset($sort)){					
			foreach ($sort as $value) {
				$obj->order_by($value["field"], $value["dir"]);
			}
		}
				
		// if(!empty($filters) && isset($filters)){			
	 //    	foreach ($filters as $value) {
	 //    		if(!empty($value["operator"]) && isset($value["operator"])){
		//     		if($value["operator"]=="where_in"){
		//     			$obj->where_in($value["field"], $value["value"]);
		//     		}else if($value["operator"]=="or_where_in"){
		//     			$obj->or_where_in($value["field"], $value["value"]);
		//     		}else if($value["operator"]=="where_not_in"){
		//     			$obj->where_not_in($value["field"], $value["value"]);
		//     		}else if($value["operator"]=="or_where_not_in"){
		//     			$obj->or_where_not_in($value["field"], $value["value"]);
		//     		}else if($value["operator"]=="like"){
		//     			$obj->like($value["field"], $value["value"]);
		//     		}else if($value["operator"]=="or_like"){
		//     			$obj->or_like($value["field"], $value["value"]);
		//     		}else if($value["operator"]=="not_like"){
		//     			$obj->not_like($value["field"], $value["value"]);
		//     		}else if($value["operator"]=="or_not_like"){
		//     			$obj->or_not_like($value["field"], $value["value"]);
		//     		}else if($value["operator"]=="startswith"){
		//     			$obj->like($value["field"], $value["value"], "after");
		//     		}else if($value["operator"]=="endswith"){
		//     			$obj->like($value["field"], $value["value"], "before");
		//     		}else if($value["operator"]=="contains"){
		//     			$obj->like($value["field"], $value["value"], "both");
		//     		}else if($value["operator"]=="or_where"){
		//     			$obj->or_where($value["field"], $value["value"]);
		//     		}else if($value["operator"]=="where_related"){
		//     			$obj->include_related($value["table"], "id");		    					    			
		//     			$obj->where_related($value["table"], $value["field"], $value["value"]);		    		
		//     		}else{
		//     			$obj->where($value["field"].' '.$value["operator"], $value["value"]);
		//     		}
	 //    		}else{	    			
	 //    			$obj->where($value["field"], $value["value"]);	    				    			
	 //    		}
		// 	}									 			
		// }
		$start = '01-01-'. date('Y');	
		$obj->where('issued_date >=', $start)->where('type', 'Invoice')->or_where('type', 'Receipt')->or_where('type', 'eInvoice')->or_where('type', 'wInvoice')->where('deleted', 0);
		$obj->get_paged_iterated($page, $limit);
		$data["count"] = $obj->paged->total_rows;							

		if($obj->result_count()>0){
			foreach ($obj as $value) {	
				$month = strtotime($value->created_at);						
				$data["results"][] = array(				   	
				   	"amount" 			=> floatval($value->amount),
				   	"month"				=> date('F', $month)
				);
			}
		}		
	
		$this->response($data, 200);	
	}
	function top_get() {
		$data = array();
		$customer = array();
		$top = array();
		$tmp = array();
		$temp= array();
		$invoices = new Invoice(null, $this->_database);
		$invoices->get_iterated();
		foreach($invoices as $invoice) {
			$tmp[$invoice->contact_id][] = array('contact_id' => $invoice->contact_id, 'amount' => $invoice->amount);			
		}
		// sum amount by contact
		foreach($tmp as $key => $value) {
			foreach($value as $v) {
				if(isset($customer[$key]['amount'])){
					$customer[$key]['amount'] += $v['amount'];
				} else {
					$customer[$key]['amount'] = $v['amount'];
				}
			}
		}

		foreach($customer as $key =>$cust) {			
			$top[] = array('amount' => (float)$cust['amount']);
		}
		rsort($top);

		foreach($customer as $key =>$cust) {		
			$temp[] = array("contact_id" =>$key, "amount" => (float)$cust['amount']);
		}
		
		for($x = 0; $x < 5; $x++) {	
			foreach($temp as $value) {
				if($value['amount'] === $top[$x]['amount']) {
					$data[] = array('contact_id' => $value['contact_id'], 'amount' =>$top[$x]['amount']);
				}
			}
		}

		$this->response(array('results' =>$data, 'count' => 4), 200);
	}

	function expense_get() {
		$pmt = new Payment(null, $this->_database);
		$start = date('Y').'-01-01';
		$end = date('Y-m-d');
		$expenseAmt = 0;
		$pmt->where('type', 'bill')->where('deleted', 'false')->group_start()->where('created_at >=', $start)->where('created_at <=', $end)->group_end();
		$pmt->get_iterated();
		foreach($pmt as $p) {
			$expenseAmt = $expenseAmt + floatval($p->amount);
		}
		$data[] = array('amount' => $expenseAmt);
		$this->response(array('results' =>$data, 'count' => 1), 200);
	}

	function income_get() {
		$tmp = array();		    				    				
		
		$start = date('Y').'-01-01';
		$end = date('Y-m-d');
		$pmt = new Payment(null, $this->_database);
		$pmt->where_in('type', array('bill', 'invoice'))->group_start()->where('deleted', 'false')->where('created_at >= ', $start)->group_end();
		$pmt->get_iterated();		
		if($pmt->exists()) {
			foreach($pmt as $p) {
				$tAmount = 0;
				$iAmount = 0;
				$p->type === 'bill' ? $tAmount = floatval($p->amount) * -1: $tAmount = floatval($p->amount);
				$p->type === 'bill' ? $iAmount = floatval($p->amount) : $iAmount = 0; 
				$month = strtotime($p->created_at);
				$m = date('F', $month);
				if(isset($tmp[$m])) {
					$tmp[$m]['amount'] += $tAmount;
					$tmp[$m]['expense'] += $iAmount; 
				} else {
					$tmp[$m]['amount'] = $tAmount;
					$tmp[$m]['expense'] = $iAmount;
				}
			}
			foreach($tmp as $key => $value) {
				$income[] = array('month' =>$key, 'income' => $value['amount'], 'expense' => $value['expense']);
			}
		} else {
			$income[] = array();
		}
	
		$tmp2 = array();

		$obj = new Invoice(null, $this->_database);	
		$obj->where_in('type', array('Invoice', 'Receipt', 'eInvoice', 'wInvoice'))->where('deleted', 0)->where('issued_date >=', $start);
		$obj->get_iterated();
		if($obj->exists()) {
			foreach ($obj as $value) {	
				$month = strtotime($value->issued_date);

				$m = date('F', $month);
				if(isset($tmp2[$m])) {
					$tmp2[$m]['amount'] += floatval($value->amount);
				} else {
					$tmp2[$m]['amount'] = floatval($value->amount);
				}
			}
			foreach($tmp2 as $key => $value) {
				$sale[] = array('month' =>$key, 'amount' => $value['amount']);
			}
		} else {
			$sale[] = array();
		}
		if(count($income) > 0 || count($sale) > 0) {
			$this->response(array(
				'results' =>array(array('income'=>$income, 'sale'=> $sale)), 
				'count' => 3), 
			200);
		} else {
			$this->response(array(
				'results' =>array(array('income'=>array(), 'sale' => array())), 
				'count' => 0), 
			200);
		}			
	}

	function equation_get() {
		$types = array();
		$acctTypes = new Account_type(null, $this->_database);
		$acctTypes->where_in('parent_id', array(1,2,3));
		$acctTypes->get_iterated();
		foreach($acctTypes as $t) {
			$account = $t->account->get();
			foreach($account  as $a) {
				$types[] = array('type' => $t->parent_id, 'id' => $a->id);
				$accts[] = $a->id;
			}
		}

		$start = date('Y').'-01-01';
		$end = date('Y-m-d');
		$entries = new Entry(null, $this->_database);
		$entries->where_in('account_id', $accts)->where('created_at >=', $start)->or_where('created_at <=', $end);
		$entries->get_iterated();
		if($entries->exists()) {
			foreach($entries as $entry) {
				foreach($types as $t) {
					if($t['id'] == $entry->account_id) {
						$amount = 0;
						if($t['type'] === '1') {
							$entry->is_debit === 'true' ? $amount = $entry->amount : $amount = $entry->amount * -1;
						} else {
							$entry->is_debit === 'true' ? $amount = $entry->amount * -1: $amount = $entry->amount;
						}
						if(isset($accountData[$t['type']])) {
							$accountData[$t['type']]['amount'] += $amount;
						} else {
							$accountData[$t['type']]['amount'] = $amount;
						}				
					}
				}
			}
		} else {
			$accountData = array();
		}


		if(isset($accountData)) {
			foreach($accountData as $key => $value) {
				$d[] = array('type'=> $key, 'amount' => $value['amount']);
			}
		} else {
			$d[] = array('type'=> 1, 'amount' => 20);
			$d[] = array('type'=> 2, 'amount' => 15);
			$d[] = array('type'=> 3, 'amount' => 5);
		}

		// should be only three account type id returned with the result
		$this->response(array('results' =>$d), 200);
	}

	function cash_get() {
		$types = array();
		$start = date('Y').'-01-01';
		$end = date('Y-m-d');
		$acctTypes = new Account_type(null, $this->_database);
		$acctTypes->where('id', 6);
		$acctTypes->get_iterated();
		foreach($acctTypes as $t) {
			$account = $t->account->get();
			foreach($account  as $a) {
				$types[] = array('type' => $t->parent_id, 'id' => $a->id);
				$accts[] = $a->id;
			}
		}

		$entries = new Entry(null, $this->_database);
		$entries->group_start()->where_in('account_id', $accts)->where('created_at >=', $start)->group_end();
		$entries->get_iterated();
		if($entries->exists()) {
			foreach($entries as $entry) {
				foreach($types as $t) {
					if($t['id'] == $entry->account_id) {
						$amount = 0;
						
						$entry->is_debit === 'true' ? $amount = $entry->amount : $amount = $entry->amount * -1;
						
						if(isset($accountData[$t['type']])) {
							$accountData[$t['type']]['amount'] += $amount;
						} else {
							$accountData[$t['type']]['amount'] = $amount;
						}				
					}
				}
			}
		} else {
			$accountData = array();
		}

		if(isset($accountData) && count($accountData) > 0) {
			foreach($accountData as $key => $value) {
				$d[] = array('type'=> $key, 'amount' => $value['amount']);
			}	
		} else {
			$d[] = array('type' => 0, 'amount'=> 0);
		}

		// should be only three account type id returned with the result
		$this->response(array('results' =>$d, 'count'=>count($d)), 200);
	}
	
}
/* End of file invoices.php */
/* Location: ./application/controllers/api/invoices.php */