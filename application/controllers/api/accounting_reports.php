<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); //disallow direct access to this file

require APPPATH.'/libraries/REST_Controller.php';

class Accounting_reports extends REST_Controller {	
	// public $entity;
	// public $user;
	public $_database;
	// public $pwd;
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
		} else {
			$this->response(array('error' => true, 'msg' => 'no db selected', 'results'=>array(), 'count' => 0), 200);
		}
	}

	public function journal_get() {
		$requested_data = $this->get('filter');
		$filters = $requested_data['filters'];
		$limit = $this->get('limit') !== false ? $this->get('limit') : 100;
		$page = $this->get('page') !== false ? $this->get('page') : 1;
		$journal = new Journal(null, $this->_database);
		if(isset($filters)) {
			foreach($filters as $filter) {
				if($filter['operator']) {
					if($filter['operator'] === "in") {
						$journal->where_in($filter['field'], $filter['value']);
					} else if($filter['operator'] === "or_where") {
						$journal->or_where($filter['field'], $filter['value']);
					} else if($filter['operator'] === "like") {
						$journal->like($filter['field'], $filter['value']);
					} else if($filter['operator'] === 'or_like') {
						$journal->or_like($filter['field'], $filter['value']);
					} else if($filter['operator'] === 'group_by') {
						$journal->group_by($filter['field']);
					} else if($filter['operator'] === 'order_by') {
						$orderof = 'asc';
						isset($filter['value']) ? $orderof = $filter['value'] : $orderof;
						$journal->order_by($filter['field'], $orderof);
					}
				} else {
					$journal->where($filter['field'], $filter['value']);
				}
			}
		}
		$journal->get_paged($page, $limit);
		if($journal->exists()) {
			foreach($journal as $j) {
				$entries = $j->entry->order_by('is_debit')->get();
				$temp = array();
				foreach($entries as $entry) {
					$acct = new Account(null, $this->_database);
					$acct->where('id', $entry->account_id)->get();
					// $seg  = $entry->segmentlist->get();
					$temp[] = array(
						'account' => array('code' => $acct->code, 'name' => $acct->name),
						'amount' => $entry->amount,
						'is_debit' => $entry->is_debit,
						'memo' => $entry->memo
						// 'seg'  => array('code' => $seg->code, 'name' => $seg->name)
					);
				}
				$contact = $j->contact->get();
				$data[] = array(
					'id'  		=> $j->id,
					'voucher' 	=> $j->voucher,
					'type' 		=> $j->type,
					'memo' 		=> $j->memo,
					'contact'	=> array(
						'name' 	=> $contact->name,
						'surname'=>$contact->surname
					),
					'entries' 	=> $temp,
					'date' 		=> $j->created_at	
				);
			}
		}

		if(isset($data) && count($data) > 0) {
			$this->response(array('error' => false, 'msg' => 'result found', 'results'=>$data, 'count' => $journal->paged->total_rows), 200);
		} else {
			$this->response(array('error' => true, 'msg' => 'no result found', 'results'=>array(), 'count' => 0), 200);
		}
	}

	public function generalledger_get() {
		$requested_data = $this->get('filter');
		$filters = $requested_data['filters'];
		$limit = $this->get('limit') !== false ? $this->get('limit') : 100;
		$page = $this->get('page') !== false ? $this->get('page') : 1;
		$debitArr = array(1,5,6,7,8,9,10,12,21,22,24,25,26,27);
		$entries = new Entry(null, $this->_database);
		$temp = [];
		if(isset($filters)) {
			foreach($filters as $filter) {
				if($filter['operator']) {
					if($filter['operator'] === "in") {
						$entries->where_in($filter['field'], $filter['value']);
					} else if($filter['operator'] === "or_where") {
						$entries->or_where($filter['field'], $filter['value']);
					} else if($filter['operator'] === "like") {
						$entries->like($filter['field'], $filter['value']);
					} else if($filter['operator'] === 'or_like') {
						$entries->or_like($filter['field'], $filter['value']);
					} else if($filter['operator'] === 'group_by') {
						$entries->group_by($filter['field']);
					} else if($filter['operator'] === 'order_by') {
						$orderof = 'asc';
						isset($filter['value']) ? $orderof = $filter['value'] : $orderof;
						$entries->order_by($filter['field'], $orderof);
					}
				} else {
					$entries->where($filter['field'], $filter['value']);
				}
			}
		}
		$entries->get();
		if($entries->exists()) {
			foreach($entries as $e) {
				$j = array();
				$journal = $e->journal->get();
				$amount = 0;
				$balance = 0;
				$account = $e->account->get();
				if(in_array($account->account_type_id, $debitArr)) {
					if($e->is_debit === 'true') {
						$amount = $e->amount;  
					} else {
						$amount = $e->amount * -1;
					}
				} else {
					if($e->is_debit === 'true') {
						$amount = $e->amount * -1;
					} else {
						$amount = $e->amount;
					}
				}
				if($journal->exists()) {
					$contact = $journal->contact->get();
					$j = array(
						'type' => $journal->type,
						'voucher' => $journal->voucher,
						'contact' => array(
							'name' => $contact->name,
							'surname' => $contact->surname
						)
					);
				}
				
				if(isset($temp[$e->account_id])) {
					$temp[$e->account_id][] = array(
						'type' => $journal->type,
						'voucher' => $journal->voucher,
						'contact' => array(
							'name' => $contact->name,
							'surname' => $contact->surname
						),
						'dr' 	=> $e->is_debit === 'true' ? $e->amount: '',
						'cr' 	=> $e->is_debit === 'true' ? '' : $e->amount,
						'memo' => $e->memo,
						'amount' => $amount,
						'dateTime' => $e->created_at
					);
				} else {
					$temp[$e->account_id][] = array(
						'type' => $journal->type,
						'voucher' => $journal->voucher,
						'contact' => array(
							'name' => $contact->name,
							'surname' => $contact->surname
						),
						'dr' 	=> $e->is_debit === 'true' ? $e->amount: '',
						'cr' 	=> $e->is_debit === 'true' ? '' : $e->amount,
						'memo' => $e->memo,
						'amount' => $amount,
						'dateTime' => $e->created_at
					);
					$temp[$e->account_id]['account'] = array('code' => $account->code, 'name' => $account->name);
					$temp[$e->account_id]['balance'] = $amount;
				}
			}
		}

		foreach($temp as $value) {
			$entries = array();
			foreach($value as $k => $v) {
				if(isset($v['type'])) {
					$entries[] = $v;
				}
			}
			
			$data[] = array(
				'code' => $value['account']['code'],
				'name' => $value['account']['name'],
				'balance' => $value['balance'],
				'entries'=> $entries
			);
		}

		if(isset($data) && count($data) > 0) {
			$this->response(array('error' => false, 'msg' => 'result found', 'results'=>$data, 'count' => 0), 200);
		} else {
			$this->response(array('error' => true, 'msg' => 'no result found', 'results'=>array(), 'count' => 0), 200);
		}
	}

	public function trialbalance_get() {}

	public function balancesheet_get() {}

	public function cashflow_get() {}

	public function profitandloss_get() {}
	
}
/* End of file invoices.php */
/* Location: ./application/controllers/api/invoices.php */