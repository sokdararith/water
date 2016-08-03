<?php defined('BASEPATH') OR exit('No direct script access allowed');


require APPPATH.'/libraries/REST_Controller.php';

class Entries extends REST_Controller {
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
	
	function index_get() {
		$requested_data = $this->get('filter');
		$filters = $requested_data['filters'];
		$limit = $this->get('limit') !== null ? $this->get('limit') : 100;
		$page = $this->get('page') !== null ? $this->get('page') : 1;
		$logic = $requested_data['logic'];
		$journal = new Journal(null, $this->_database);
		$query = null;
		$data = array();
		if(isset($filters)) {
			foreach($filters as $f) {
				if($f['operator'] === 'or') {
					$journal->or_where($f['field'], $f['value']);
				} elseif ($f['operator'] === 'and' || $f['operator'] === '') {
					$journal->where($f['field'], $f['value']);
				} elseif ($f['operator'] === 'like') {
					$journal->like($f['field'], $f['value']);
				} elseif ($f['operator'] === 'or_like') {
					$journal->or_like($f['field'], $f['value']);
				} else {
					$journal->where($f['field'], $f['value']);
				}
			}
		}
		$journal->get_paged($page, $limit);
		if($journal->exists()) {
			foreach($journal as $j) {
				$entry = $j->entry->get();
				$entries = array();
				foreach($entry as $e) {
					$account = $e->account->get();
					$segment = $e->segmentlist->get();
					$dr = 0;
					$cr = 0;
					if($e->is_debit === 'false') {
						$cr += floatval($e->amount);
					} else {
						$dr += floatval($e->amount);
					}
					
					if($segment->exists()) {
						foreach($segment as $seg) {
							$segments[] = array(
								'id' => $seg->id,
								'code' => $seg->code,
								'name' => $seg->name
							);
						}
					} else {
						$segments = array();
					}	
					
					$entries[] = array(
						'id' 	=> intval($e->id),
						'memo'	=> $e->memo,
						'debit'  	=> $dr,
						'credit'	=> $cr,
						'rate' => $e->rate,
						'locale' => $e->locale,
						'segment'=> $segments,
						'account'=> array(
							'id' 	=> $account->id,
							'code' 	=> $account->code,
							'name' 	=> $account->name
						)
					);
				}
				$data[] = array(
					'id' 		=> $j->id,
					'type' 		=> $j->type,
					'voucher' 	=> $j->voucher,
					'memo'	  	=> $j->memo,
					'reference' => $j->reference,
					'issuedDate'=> $j->issued_date,
					'entries' 	=> $entries
				);
			}
		}	
		if(count($data) > 0) {
			$this->response(array('results'=>$data, 'msg' => 'result found', 'count'=>$journal->paged->total_rows), 200);
		} else {
			$this->response(array('error'=>'no criteria.', 'msg' => 'no result found'), 200);
		}	
	}

	/*
	* adding new entries based on journal id
	* @param: models: [
	*					{amount: 0.00, memo: '', is_debit: true, account: {}, journal: {}},
	*					{amount: 0.00, memo: '', is_debit: false, account:{}, journal: {}}
	*					]
	*/
	function index_post() {
		$requested_data = json_decode($this->post('models'));
		$data = array();
		$entries = array();
		foreach($requested_data as $row) {
			$journal = new Journal(null, $this->_database);
			$journal->reference = isset($row->reference->id) ? $row->reference->id : null;
			$journal->voucher = isset($row->voucher) ? $row->voucher : null;
			$journal->memo = $row->memo;
			$journal->type = $row->type;
			$journal->issued_date = $row->issuedDate;
			
			// create entries based on journal created
			if($journal->save()) {
				foreach($row->entries as $e) {
					// get current balance of the account
					$entry = new Entry(null, $this->_database);
					$en = new Entry(null, $this->_database);
					$en->where('account_id', $e->account->id)->order_by('id', 'DESC')->limit(1)->get();
					if($en->exists()) {
						$account = new Account(null, $this->_database);
						$account->where('id', $e->account->id)->limit(1);
						$account->include_related('account_type', array('id', 'nature'));
						$account->get();
						$nature = $e->is_debit === false ? 'Cr': 'Dr';
						if($nature == $account->type_nature) {
							$entry->balance = floatval($en->balance) + floatval($e->amount);
						} else {
							$entry->balance = floatval($en->balance) - floatval($e->amount);
						}						
					}
					$entry->account_id = $e->account->id;
					$entry->journal_id = $journal->id;
 					$entry->amount = $e->amount;
					$entry->memo = $e->memo;
					$entry->is_debit = $e->is_debit === false ? 'false': 'true';
					$entry->locale = $e->locale;
					$entry->rate = $e->rate;
					$entry->issued_date = $e->issuedDate;
					
					if($entry->save()) {
						$contact = new Contact(null, $this->_database);
						if(isset($e->contact)) {
							$contact->where('id', $e->contact->id)->get();
							$contact->save($entry);
						}
						if(isset($e->segment)) {
							foreach($e->segment as $seg) {
								$class = new Segmentlist(null, $this->_database);
								$class->where('id', $seg->id)->get();
								$class->save($entry);
							}
						}

						$account = $entry->account->get();
						$contact = $entry->contact->get();
						$entries[] = array(
							'id' 	=> intval($entry->id),
							'amount'=> floatval($entry->amount),
							'memo'	=> $entry->memo,
							'is_debit' => $entry->is_debit === 'false' ? false: true,
							'rate' => $entry->rate,
							'locale' => $entry->locale,
							'contact' => array(
								'id' => $contact->id,
								'company' => $contact->company,
								'company_en' => $contact->company_en,
								'name' => $contact->surname . ' ' . $contact->name, 
								'created_at' => $contact->created_at
							),
							// 'segment'=> array()
							'account'=> array(
								'id' 	=> $account->id,
								'code' 	=> $account->code,
								'name' 	=> $account->name
							)
						);
					}
				}
				$data[] = array(
					'id' 		=> $journal->id,
					'type' 		=> $journal->type,
					'voucher' 	=> $journal->voucher,
					'memo'	  	=> $journal->memo,
					'reference' => $journal->reference,
					'issuedDate'=> $journal->issued_date,
					'entries' 	=> $entries
				);
			}
		}
		if(count($data)>0) {
			$this->response(array('results'=>$data, 'count'=>count($data)), 201);
		} else {
			$this->response(array('error'=>'no data recorded.', 'count'=>count($data)), 200);
		}
	}
	function index_put() {
		$requested_data = json_decode($this->post('models'));
		$data = array();
		$entries = array();
		foreach($requested_data as $row) {
			// create journal first
			// $c = new Contact(null, $this->entity);
			// $c->where('id', $row->contact->id)->get();
			$journal = new Journal(null, $this->_database);
			$journal->reference = isset($row->reference->id) ? $row->reference->id : null;
			$journal->voucher = isset($row->voucher) ? $row->voucher : null;
			$journal->memo = $row->memo;
			$journal->type = $row->type;
			$journal->issued_date = $row->issuedDate;
			
			// create entries based on journal created
			if($journal->save()) {
				foreach($row->entries as $e) {
					$entry = new Entry(null, $this->_database);
					$entry->account_id = $e->account->id;
					$entry->amount = $e->amount;
					$entry->memo = $e->memo;
					$entry->is_debit = $e->is_debit === false ? 'false': 'true';
					$entry->locale = $e->locale;
					$entry->rate = $e->rate;
					$entry->issued_date = $e->issuedDate;
					
					if($entry->save(array($journal))) {
						$contact = new Contact(null, $this->_database);
						if(isset($e->contact)) {
							$contact->where('id', $e->contact->id)->get();
							$contact->save($entry);
						}
						if(isset($e->segment)) {
							foreach($e->segment as $seg) {
								$class = new Segmentlist(null, $this->_database);
								$class->where('id', $seg->id)->get();
								$class->save($entry);
							}
						}

						$account = $entry->account->get();
						$entries[] = array(
							'id' 	=> intval($entry->id),
							'amount'=> floatval($entry->amount),
							'memo'	=> $entry->memo,
							'is_debit' => $entry->is_debit === 'false' ? false: true,
							'rate' => $entry->rate,
							'locale' => $entry->locale,
							'account'=> array(
								'id' 	=> $account->id,
								'code' 	=> $account->code,
								'name' 	=> $account->name
							)
						);
					}
				}
				$data[] = array(
					'id' 		=> $journal->id,
					'type' 		=> $journal->type,
					'voucher' 	=> $journal->voucher,
					'memo'	  	=> $journal->memo,
					'reference' => $journal->reference,
					'issuedDate'=> $journal->issued_date,
					'entries' 	=> $entries
				);
			}
		}
		if(count($data)>0) {
			$this->response(array('results'=>$data, 'count'=>count($data)), 201);
		} else {
			$this->response(array('error'=>'no data recorded.', 'count'=>count($data)), 200);
		}
	}

	function index_delete(){
		$requested_data = json_decode($this->delete('models'));
		$data = array();
		// loop through journal in case there are multiple data
		foreach($requested_data as $row) {
			$entry = new Entry(null, $this->_database);
			$entry->where('id', $row->id)->get();
			$entry->deleted = true;
			if($entry->save()){
				$data[] = array(
					'id' => $entry->id,
					'amount'=> $entry->amount,
					'is_debit'=> $entry->is_debit	
				);
			}
		}
		if(count($data)>0) {
			$this->response(array('results'=>$data, 'count'=>count($data)), 201);
		} else {
			$this->response(array('error'=>'no data recorded.', 'count'=>count($data)), 200);
		}
	}


	// get all contacts base on journal entry
	function contacts_get() {
		$requested_data = $this->get('filter');
		$filters = $requested_data['filters'];
		$limit = $this->get('limit') !== null ? $this->get('limit') : 100;
		$page = $this->get('page') !== null ? $this->get('page') : 1;

		$entries = new Entry(null, $this->_database);
		// check if filter is set
		if(isset($filters)) {
			foreach($filters as $f) {
				$entries->where($f['field'], $f['value']);
			}
			$entries->get();
			$contacts = $entries->contact->include_join_fields()->get();
			if($contacts->join_id) {
				$data = array();
				foreach($contacts as $contact) {
					$data[] = array(
						'id' 		=> intval($contact->join_id),
						'entry_id' 	=> $entries->id,
						'name' 		=> $contact->name,
						'surname' 	=> $contact->surname,
						'contact_id'=> $contact->id,
						'relation' 	=> $contact->join_relation 
					);
				}
				$this->response(array('results'=>$data, 'msg' => count($data) .' result found'), 200);
			} else {
				$this->response(array('error'=>$data, 'msg' => 'no result found'), 200);
			}	
		} else {
			$this->response(array('error'=>array(), 'msg' => 'no id provided'), 200);
		}
	}

	// add contacts to entry
	// post contact to existing entry
	function contacts_post() {
		$requested_data = json_decode($this->post('models'));
		foreach($requested_data as $e) {
			$entry = new Entry(null, $this->_database);
			$entry->where('id', $e->entry_id)->get();
			$contact = new Contact(null, $this->entity);
			$contact->where('id', $e->contact_id)->get();
			$contact->save($entry);
			$contact->set_join_field($entry, 'relation', $e->relation);
			$contact->save();

			$i = $contact->entry->include_join_fields()->get();
			$data[] = array(
				'id' 		=> $i->join_id,
				'entry_id' 	=> $entry->id,
				'contact_id'=> $contact->id,
				'name' 		=> $contact->name,
				'surname' 	=> $contact->surname,
				'relation' 	=> $i->join_relation
			);
		}
		$this->response(array('results'=>$data, 'msg' => 'no result found'), 200);
	}

	// update contacts to entry
	// update contacts to exiting enty
	function contacts_put() {
		$requested_data = json_decode($this->put('models'));
		foreach($requested_data as $e) {
			$entry = new Entry(null, $this->_database);
			$entry->where('id', $e->entry)->get();

			foreach($e->contacts as $c) {
				$contact = new Contact(null, $this->entity);
				$contact->where('id', $c->id)->get();
				$contact->save($entry);
			}
		}
	}

	// delete contacts from entry
	function contacts_delete() {
		$requested_data = json_decode($this->delete('models'));
		$people = array();
		foreach($requested_data as $e) {
			$entry = new Entry(null, $this->_database);
			$entry->where('id', $e->entry_id)->get();

			$contact = new Contact(null, $this->entity);
			$contact->where('id', $e->contact_id)->get();
			
			if($contact->delete($entry)){
				$people[] = $contact->id;
			}
			
		}
		if(count($people) > 0) {
			$this->response(array('results'=>$people, 'msg'=>count($people).' contact deleted'), 204);
		} else {
			$this->response(array('results'=>$people, 'msg'=>count($people).' contact deleted'), 200);
		}
	}

	// get all accounts base on journal entry
	function accounts_get() {

	}

	// add accounts to journal entry
	function accounts_post() {}

	// update accounts to journal entry
	function accounts_put() {}

	// delete accounts from journal entry
	function accounts_delete() {}

	// public function v4($trim = false) {        
 //        $format = ($trim == false) ? '%04x%04x-%04x-%04x-%04x-%04x%04x%04x' : '%04x%04x%04x%04x%04x%04x%04x%04x';
    
 //        return sprintf($format,

 //                // 32 bits for "time_low"
 //                mt_rand(0, 0xffff), mt_rand(0, 0xffff),

 //                // 16 bits for "time_mid"
 //                mt_rand(0, 0xffff),

 //                // 16 bits for "time_hi_and_version",
 //                // four most significant bits holds version number 4
 //                mt_rand(0, 0x0fff) | 0x4000,

 //                // 16 bits, 8 bits for "clk_seq_hi_res",
 //                // 8 bits for "clk_seq_low",
 //                // two most significant bits holds zero and one for variant DCE1.1
 //                mt_rand(0, 0x3fff) | 0x8000,

 //                // 48 bits for "node"
 //                mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
 //        );
 //    }
}