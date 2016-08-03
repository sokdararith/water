<?php defined('BASEPATH') OR exit('No direct script access allowed');


require APPPATH.'/libraries/REST_Controller.php';

class Accounts extends REST_Controller {
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
		 
	public function index_get() {
		$requested_data = $this->get('filter');
		$filters = $requested_data['filters'];
		$limit = $this->get('limit') !== false ? $this->get('limit') : 1000;
		$page = $this->get('page') !== false ? $this->get('page') : 1;
		$data = array();
		$accounts = new Account(null, $this->_database);

		if(isset($filters)) {
			foreach($filters as $f) {
				if(!empty($f["operator"]) && isset($f["operator"])){
					if($f['operator'] === '') {
						$accounts->where($f['field'], $f['value']);
					} else if($f['operator'] === 'where_in') {
						$accounts->where_in($f['field'], $f['value']);
					} else if($f['operator'] === 'or') {
						$accounts->or_where($f['field'], $f['value']);
					} else if($f['operator'] === 'like') {
						$accounts->like($f['field'], $f['value'], 'both');
					} else if($f['operator'] === 'or_like') {
						$accounts->like($f['field'], $f['value'], 'both');
					}	
				} else {
					$accounts->where($f['field'], $f['value']);
				}
			}
		}
		$accounts->order_by('code', 'asc');
		$accounts->get_paged($page, $limit);
		
		if($accounts->result_count() > 0) {
			foreach($accounts as $ac) {
				$parent = $ac->parent->get();
				$ac->account_type->get();
				$data[] = array(
					'id' => intval($ac->id),
					'code' => $ac->code,
					'name' => $ac->name,
					'name_en' => $ac->name_en,
					'description' => $ac->description,
					'parentAccount'=> array(
							'id' => intval($parent->id),
							'code' => $parent->code,
							'name' => $parent->name,
							'name_en' => $parent->name_en
					),
					'type' => array(
							'id' 	=> $ac->account_type->id,
							'name' 	=> $ac->account_type->name,
							'name_en' 	=> $ac->account_type->name_en,
							'nature' 	=> $ac->account_type->nature,
							'cash_flow_source' 	=> $ac->account_type->cash_flow_source
					),
					'created_at' => $ac->created_at,
					'updated_at' => $ac->updated_at
				);
			}
			$this->response(array('results'=>$data, 'count' => $accounts->paged->total_rows), 200);
		} else {
			$this->response(array('error'=>'no result found.'), 400);
		}
	}

	public function index_post() {
		$requested_data = json_decode($this->post('models'));
		$data = array();
		foreach($requested_data as $r) {
			$type = new Account_type(null, $this->_database);
			$type->where('id', $r->type->id);
			$type->get();

			$account = new Account(null, $this->_database);
			$account->where('code', $r->code);
			$account->or_where('name', $r->name);
			$account->get();
			if($account->exists()) {
				$this->response(array('results'=>$data, 'msg'=>'account existed', 'count' => 0), 201);
			} else {
				$account->code = $r->code;
				$account->name = $r->name;
				$account->name_en = $r->name_en;
				$account->description = $r->description !== null ? $account->description : '';
				$account->parent_id = $r->parentAccount !== null ? $r->parentAccount->id: 0;
				if($account->save($type)) {
					$data[] = array(
						'id' => intval($account->id),
						'code' => $account->code,
						'name' => $account->name,
						'name_en' => $account->name_en,
						'description' => $account->description,
						'parentAccount' => $r->parentAccount,
						'type' => array(
								'id' 	=> $type->id,
								'name' 	=> $type->name,
								'name_en' 	=> $type->name_en,
								'nature' 	=> $type->nature,
								'cash_flow_source' 	=> $type->cash_flow_source
						),
						'created_at' => $account->created_at,
						'updated_at' => $account->updated_at
					);
				}
			}
		}
		if(count($data) > 0) {
			$this->response(array('results'=>$data, 'count' => count($requested_data)), 201);
		} else {
			$this->response(array('results'=>$data, 'count' => 0), 201);
		}		
	}

	public function index_put() {
		$requested_data = json_decode($this->put('models'));
		$data = array();
		foreach($requested_data as $r) {
			$type = new Account_type(null, $this->_database);
			$type->where('id', $r->type->id);
			$type->get();

			$account = new Account(null, $this->_database);
			$account->where('code', $r->code);
			$account->or_where('name', $r->name);
			$account->or_where('name_en', $r->name_en);
			$account->get();
			if($account->exists()) {
				$this->response(array('error'=>TRUE, 'results'=>$r, 'msg'=>'account with code or name already existed', 'count' => count($data)), 200);
			} else {
				$account->clear();
				$account->where('id', $r->id);
				$account->get();
				$account->code = $r->code;
				$account->name = $r->name;
				$account->name_en = $r->name_en;
				if($account->save()) {
					$data[] = array(
						'id' => intval($account->id),
						'code' => $account->code,
						'name' => $account->name,
						'name_en' => $account->name_en,
						'status' => boolval($account->status),
						'description' => $account->description,
						'type' => array(
								'id' 	=> $type->id,
								'name' 	=> $type->name,
								'name_en' 	=> $type->name_en,
								'nature' 	=> $type->nature,
								'cash_flow_source' 	=> $type->cash_flow_source
						),
						'created_at' => $account->created_at,
						'updated_at' => $account->updated_at
					);
				}
			}					
		}
		$this->response(array('error' => FALSE, 'results'=>$data, 'count' => count($data)), 201);
	}

	public function index_delete() {
		$requested_data = json_decode($this->delete('models'));
		$data = array();
		foreach($requested_data as $r) {
			$type = new Account_type(null, $this->_database);
			$type->where('id', $r->type->id);
			$type->get();

			$account = new Account(null, $this->_database);
			$account->where('id', $r->id);
			$account->get();
			if($account->exist()) {
				$entries = $account->entry->limit(1)->get();
				if($entries->exist()) {
					$account->active = 'false';
					if($account->save()) {
						$data[] = array(
							'id' => intval($account->id),
							'code' => $account->code,
							'name' => $account->name,
							'name_en' => $account->name_en,
							'description' => $account->description,
							'status' => boolval($account->status),
							'type' => array(
									'id' 	=> $type->id,
									'name' 	=> $type->name,
									'name_en' 	=> $type->name_en,
									'nature' 	=> $type->nature,
									'cash_flow_source' 	=> $type->cash_flow_source
							),
							'created_at' => $account->created_at,
							'updated_at' => $account->updated_at
						);
					}
				} else {
					$account->delete();
				}
			}	
		}
		$this->response(array('results'=>$data, 'count' => count($data)), 201);
	}
		
	public function types_get() {
		$requested_data = $this->get('filter');
		$filters = $requested_data['filters'];
		$limit = $this->get('limit') !== false ? $this->get('limit') : 1000;
		$page = $this->get('page') !== false ? $this->get('page') : 1;
		$data = array();
		$types = new Account_type(null, $this->_database);
		if(isset($filters)) {
			foreach($filters as $f) {
				if($f['operator'] === '') {
					$types->where($f['field'], $f['value']);
				} else if($f['operator'] === 'where_in') {
					$types->where_in($f['field'], $f['value']);
				} else if($f['operator'] === 'or') {
					$types->or_where($f['field'], $f['value']);
				} else if($f['operator'] === 'like') {
					$types->like($f['field'], $f['value'], 'both');
				} else if($f['operator'] === 'or_like') {
					$types->like($f['field'], $f['value'], 'both');
				} else {
					$types->where($f['field'], $f['value']);
				}
			}
		}
		$types->where('id >', 5);
		$types->get_paged($page, $limit);
		if($types->result_count() > 0) {
			foreach($types as $ac) {
				$data[] = array(
					'id' => intval($ac->id),
					'name' => $ac->name,
					'name_en' => $ac->name_en,
					'name_en' => $ac->name_en,
					'nature' => $ac->nature,
					'cash_flow_source'=> $ac->cash_flow_source,
					'financial_statement' => $ac->financial_statement,
					'created_at' => $ac->created_at,
					'updated_at' => $ac->updated_at
				);
			}
			$this->response(array('results'=>$data, 'count' => $types->paged->total_rows), 200);
		} else {
			$this->response(array('error'=>'no result found.'), 400);
		}
	}
	public function coa_get() {
		$requested_data = $this->get('filter');
		$filters = $requested_data['filters'];
		$limit = $this->get('limit') !== false ? $this->get('limit') : 1000;
		$page = $this->get('page') !== false ? $this->get('page') : 1;
		$data = array();
		$accounts = new Account(null, $this->_database);

		if(isset($filters)) {
			foreach($filters as $f) {
				if($f['operator'] === '') {
					$accounts->where($f['field'], $f['value']);
				} else if($f['operator'] === 'where_in') {
					$accounts->where_in($f['field'], $f['value']);
				} else if($f['operator'] === 'or') {
					$accounts->or_where($f['field'], $f['value']);
				} else if($f['operator'] === 'like') {
					$accounts->like($f['field'], $f['value'], 'both');
				} else if($f['operator'] === 'or_like') {
					$accounts->like($f['field'], $f['value'], 'both');
				} else {
					$accounts->where($f['field'], $f['value']);
				}
			}
		}
		$accounts->order_by('account_type_id', 'asc');
		$accounts->order_by('code', 'asc');
		$accounts->get_paged($page, $limit);
		
		if($accounts->result_count() > 0) {
			foreach($accounts as $ac) {
				$parent = $ac->parent->get();
				$ac->account_type->get();
				$data[] = array(
					'id' => intval($ac->id),
					'code' => $ac->code,
					'name' => $ac->name,
					'name_en' => $ac->name_en,
					'description' => $ac->description
				);
			}
			$this->response(array('results'=>$data, 'count' => $accounts->paged->total_rows), 200);
		} else {
			$this->response(array('error'=>'no result found.'), 400);
		}
	}
	public function coa_post() {
		$requested_data = json_decode($this->post('models'));
		$this->response(array('results'=>$requested_data, 'count' => 1), 201);
	}
	public function types_post() {}

	public function types_put() {}

	public function types_delete() {}

	// get entries based on account
	public function entries_get() {
		$requested_data = $this->get('filter');
		$filters = $requested_data['filters'];
		$limit = $this->get('limit') !== null ? $this->get('limit') : 100;
		$page = $this->get('page') !== null ? $this->get('page') : 1;

		$account = new Entry(null, $this->_database);
		// check if filter is set
		if(isset($filters)) {
			foreach($filters as $f) {
				$account->where($f['field'], $f['value']);
			}
			$account->get_paged($page, $limit);
			
			if($account->exists()) {
				foreach($account as $row) {
					$entries = $row->where_related('entry', 'deleted', 'false')->get();
					$journal = $row->entry->include_related('journal', array('id'))->get();
					foreach($entries as $entry){
						$data[] = array(
								'id' 		=> $entry->id,
								'amount' 	=> floatval($entry->amount),
								'memo'		=> $entry->memo,
								'is_debit' 	=> boolval($entry->is_debit),
								'journal'	=> $journal->id
						);
					}	
				}
				$this->response(array('results'=>$data, 'msg' => 'result found', 'count'=>$entries->paged->total_rows), 200);
			} else {
				$this->response(array('error'=>'no criteria.', 'msg' => 'no result found'), 200);
			}			
		} else {
			$entries->where('deleted', 'false');
			$entries->get_paged($page, $limit);
			if($entries->exists()) {
				foreach($entries as $entry) {
					$account = $entry->account->get_raw();
					$journal = $entry->journal->get_raw();
					$data[] = array(
							'id' 		=> $entry->id,
							'amount' 	=> floatval($entry->amount),
							'memo'		=> $entry->memo,
							'is_debit' 	=> boolval($entry->is_debit),
							'account'	=> $account->result(),
							'journal'	=> $journal->result()
					);
				}
				$this->response(array('results'=>$data, 'msg' => 'result found', 'count'=>$entries->paged->total_rows), 200);
			}	
		}	
	}

	public function tb_get() {
		$requested_data = $this->get('filter');
		$filters = $requested_data['filters'];
		$limit = $this->get('limit') !== null ? $this->get('limit') : 100;
		$page = $this->get('page') !== null ? $this->get('page') : 1;

		$accounts = new Account(null, $this->_database);
		$accounts->order_by('account_type_id');
		$accounts->where_not_in('account_type_id', array(20, 21, 22, 23, 24, 25, 26, 27));
		$accounts->include_related('account_type');
		
		$accounts->get();     

		// only asset, liability and Equity
		foreach($accounts as $act) {
			$entry = null;
			if(isset($filters)) {
				foreach($filters as $f) {
					if($f['field'] === 'created_at') {
						$now = new DateTime($f['value']);
						$now->modify('-1 year');
						$aYearFromNow = $now->format('Y-m-d');
						$entry = $act->entry->where('created_at >=', $aYearFromNow)->where('created_at <=', $f['value'])->order_by('id', 'DESC')->limit(1)->get();
					}
				}
			} else {
				$entry = $act->entry->order_by('id', 'DESC')->limit(1)->get();
			}
			$balance = $entry->balance !== null ? $entry->balance : 0.00;
			$data[] = array(
				'id' => $act->id,
				'account' => $act->name,
				'code' => $act->code,
				'type_nature' => $act->account_type_nature,
				'type_name' => $act->account_type_name,
				'dr' => $act->account_type_nature === 'Dr' ? $balance : '',
				'cr' => $act->account_type_nature === 'Cr' ? $balance : ''
			);
		}


		// secton for income and expense
		$accts = new Account(null, $this->_database);
		$accts->order_by('account_type_id');
		$accts->where_in('account_type_id', array(20, 21, 22, 23, 24, 25, 26, 27));
		$accts->include_related('account_type');
		$accts->get();

		// only asset, liability and Equity
		foreach($accts as $act) {
			$entry = null;
			if(isset($filters)) {
				foreach($filters as $f) {
					if($f['field'] === 'created_at') {
						$now = new DateTime($f['value']);
						$beginingOfTheYear = $now->format('Y').'-01-01';
						$entry = $act->entry->where('created_at >=', $beginingOfTheYear)->where('created_at <=', $f['value'])->order_by('id', 'DESC')->limit(1)->get();
					}
				}
			} else {
				$entry = $act->entry->order_by('id', 'DESC')->limit(1)->get();
			}
			
			$balance = $entry->balance !== null ? $entry->balance : 0.00;
			$data[] = array(
				'id' => $act->id,
				'account' => $act->name,
				'code' => $act->code,
				'type_nature' => $act->account_type_nature,
				'type_name' => $act->account_type_name,
				'dr' => $act->account_type_nature === 'Dr' ? $balance : '',
				'cr' => $act->account_type_nature === 'Cr' ? $balance : ''
			);
		}
		$this->response(array('results'=> $data, 'count' => count($data)), 200);
	}

	public function asset_get() {
		$requested_data = $this->get('filter');
		$filters = $requested_data['filters'];
		$limit = $this->get('limit') !== null ? $this->get('limit') : 100;
		$page = $this->get('page') !== null ? $this->get('page') : 1;

		$account_types = new Account_type(null, $this->_database);
		$account_types->where('parent_id', 1);
		$account_types->get();

		foreach($account_types as $type) {
			$accounts = $type->account->get();
			$act = array();

			foreach($accounts as $account) {
				if(isset($filters)) {
					foreach($filters as $f) {
						if($f['field'] === 'created_at') {
							$now = new DateTime($f['value']);
							$beginingOfTheYear = $now->format('Y').'-01-01';
							$entry = $account->entry->where('created_at >=', $beginingOfTheYear)->where('created_at <=', $f['value'])->order_by('id', 'DESC')->limit(1)->get();
						}
					}
				} else {
					$now = new DateTime($f['value']);
					$beginingOfTheYear = $now->format('Y').'-01-01';
					$entry = $account->entry->where('created_at >=', $beginingOfTheYear)->where('created_at <=', $now->format('Y-m-d'))->order_by('id', 'DESC')->limit(1)->get();
					$entry = $account->entry->order_by('id', 'DESC')->limit(1)->get();
				}				
				$act[] = array(
					'account' => $account->name_en,
					'code' 	  => $account->code,
					'amount'  => $entry->balance !== NULL ? $entry->balance : 0.00	
				);
			}
		
			$data[] = array(
				'id' => $type->id,
				'type' => $type->name_en,
				'nature' => $type->nature,
				'accounts' => $act
			);
		}

		$this->response(array('results'=> $data, 'count' => count($data)), 200);
	}

	public function liability_get() {
		$requested_data = $this->get('filter');
		$filters = $requested_data['filters'];
		$limit = $this->get('limit') !== null ? $this->get('limit') : 100;
		$page = $this->get('page') !== null ? $this->get('page') : 1;

		$account_types = new Account_type(null, $this->_database);
		$account_types->where_in('parent_id', array(2, 3));
		$account_types->get();

		foreach($account_types as $type) {
			$accounts = $type->account->get();
			$act = array();

			foreach($accounts as $account) {
				if(isset($filters)) {
					foreach($filters as $f) {
						if($f['field'] === 'created_at') {
							$now = new DateTime($f['value']);
							$beginingOfTheYear = $now->format('Y').'-01-01';
							$entry = $account->entry->where('created_at >=', $beginingOfTheYear)->where('created_at <=', $f['value'])->order_by('id', 'DESC')->limit(1)->get();
						}
					}
				} else {
					$now = new DateTime($f['value']);
					$beginingOfTheYear = $now->format('Y').'-01-01';
					$entry = $account->entry->where('created_at >=', $beginingOfTheYear)->where('created_at <=', $now->format('Y-m-d'))->order_by('id', 'DESC')->limit(1)->get();
					$entry = $account->entry->order_by('id', 'DESC')->limit(1)->get();
				}	
				$act[] = array(
					'account' => $account->name_en,
					'code' 	  => $account->code,
					'amount'  => $entry->balance !== NULL ? $entry->balance : 0.00	
				);
			}
		
			$data[] = array(
				'id' => $type->id,
				'type' => $type->name_en,
				'nature' => $type->nature,
				'parent_id' => $type->parent_id,
				'accounts' => $act
			);
		}

		$this->response(array('results'=> $data, 'count' => count($data)), 200);
	}

	public function income_get() {
		$requested_data = $this->get('filter');
		$filters = $requested_data['filters'];
		$limit = $this->get('limit') !== null ? $this->get('limit') : 100;
		$page = $this->get('page') !== null ? $this->get('page') : 1;

		$account_types = new Account_type(null, $this->_database);
		$account_types->where('parent_id', 4);
		$account_types->get();

		foreach($account_types as $type) {
			$accounts = $type->account->get();
			$act = array();

			foreach($accounts as $account) {
				if(isset($filters)) {
					foreach($filters as $f) {
						$account->entry->where($f['field'], $f['value']);
					}
				}
				$account->entry->order_by('id', 'DESC')->limit(1);
				$entry = $account->entry->get();	
				$act[] = array(
					'account' => $account->name,
					'code' 	  => $account->code,
					'amount'  => $entry->balance !== NULL ? $entry->balance : 0.00	
				);
			}
		
			$data[] = array(
				'id' => $type->id,
				'type' => $type->name,
				'nature' => $type->nature,
				'accounts' => $act
			);
		}

		$this->response(array('results'=> $data, 'count' => count($data)), 200);
	}

	public function expense_get() {
		$requested_data = $this->get('filter');
		$filters = $requested_data['filters'];
		$limit = $this->get('limit') !== null ? $this->get('limit') : 100;
		$page = $this->get('page') !== null ? $this->get('page') : 1;

		$account_types = new Account_type(null, $this->_database);
		$account_types->where('parent_id', 5);
		$account_types->get();

		foreach($account_types as $type) {
			$accounts = $type->account->get();
			$act = array();

			foreach($accounts as $account) {
				if(isset($filters)) {
					foreach($filters as $f) {
						$account->entry->where($f['field'], $f['value']);
					}
				}
				$account->entry->order_by('id', 'DESC')->limit(1);
				$entry = $account->entry->get();	
				$act[] = array(
					'account' => $account->name,
					'code' 	  => $account->code,
					'amount'  => $entry->balance !== NULL ? $entry->balance : 0.00	
				);
			}
		
			$data[] = array(
				'id' => $type->id,
				'type' => $type->name,
				'nature' => $type->nature,
				'accounts' => $act
			);
		}

		$this->response(array('results'=> $data, 'count' => count($data)), 200);
	}

	public function creditSale_get() {
		$requested_data = $this->get('filter');
		$filters = $requested_data['filters'];
		$limit = $this->get('limit') !== null ? $this->get('limit') : 100;
		$page = $this->get('page') !== null ? $this->get('page') : 1;

		$invoices = new Invoice(null, $this->_database);
		if(isset($filters)) {
			foreach($filters as $filter) {
				$invoices->where($filter['field'], $filter['value']);
			}
		}
		$invoices->select_sum('amount');
		$invoices->get();
		if($invoices->exists()) {
			$data[] = array('amount' => $invoices->amount);
		}
		if(count($data) > 0) {
			$this->response(array('error' => FALSE, 'results'=> $data, 'count' => count($data)), 200);
		} else {
			$this->response(array('error' => TRUE,'results'=> array(), 'count' => 0), 200);
		}
	}
	public function netIncome_get() {
		$requested_data = $this->get('filter');
		$filters = $requested_data['filters'];
		$limit = $this->get('limit') !== null ? $this->get('limit') : 100;
		$page = $this->get('page') !== null ? $this->get('page') : 1;

		$account_types = new Account_type(null, $this->_database);
		$account_types->where_in('parent_id', array(4,5));
		$account_types->get();
		$data = array();
		$act = array();
		foreach($account_types as $type) {
			$accounts = $type->account->get();
			foreach($accounts as $account) {
				if(isset($filters)) {
					foreach($filters as $f) {
						$account->entry->where($f['field'], $f['value']);
					}
				}
				$account->entry->order_by('id', 'ASC');
				$entries = $account->entry->get();
				foreach($entries as $entry) {
					$month = strtotime($entry->issued_date);
					$m = date('F', $month);	
					$amount = $entry->amount;
					$nature = $entry->is_debit === 'true' ? 'Dr':'Cr';
					if($nature === $type->nature) {
						$amount = $amount *1;
					} else {
						$amount = $amount * -1;
					}
					if(isset($act[$type->parent_id])) {
						$act[$type->parent_id][] = array(
							'amount'  => $amount,
							'month'	  => $m	
						);
					} else {
						$act[$type->parent_id][] = array(
							'amount'  => $amount,
							'month'	  => $m	
						);
					}
				}	
			}	
		}
		$temp = array();
		if(count($act) > 0) {
			foreach($act as $key => $value) {
				foreach($value as $item) {
					$type = $key === 4 ? 'income':'expense';
					if(isset($temp[$item['month']][$type])) {	
						$temp[$item['month']][$type] += $item['amount'];	 
					} else {
						$temp[$item['month']][$type] = $item['amount']; 
					}
				}			
			}
			foreach($temp as $key => $value) {
				$income = 0.00;
				$expense= 0.00;
				if(isset($value['income'])){
					$income = $value['income'];
				}
				if(isset($value['expense'])) {
					$expense = abs($value['expense']);
				}

				$data[] = array(
					'month' => $key,
					'income'=> $income,
					'expense'=>$expense,
					'net' => $income - $expense
				);
			}	
		}
		if(count($data) > 0) {
			$this->response(array('results'=>$data, 'count' => 0), 200);
		} else {
			$this->response(array('results'=>$temp, 'count' => 0), 200);
		}
	}
}//End Of Class