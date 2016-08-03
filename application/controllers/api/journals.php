<?php defined('BASEPATH') OR exit('No direct script access allowed');


require APPPATH.'/libraries/REST_Controller.php';

class Journals extends REST_Controller {
	public $entity;
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
			$this->entity = $conn->inst_database;
		}
	}
	
	// get journal based on filter
	function index_get() {
		$requested_data = $this->get('filter');
		$filters = $requested_data['filters'];
		$limit = $this->get('limit');
		$page= $this->get('page');

		$journals = new Journal(null, $this->entity);
		// check if filter is set
		if(isset($filters)) {
			foreach($filters as $f) {
				$journals->where($f['field'], $f['value']);
			}
			$journals->get_paged($page, $limit);
			if($journals->exists()) {
				$entries = $journals->entry->get_raw();
				foreach($journals as $j) {					
					$data[] = array(
						'id' => $j->id,
						'reference' => $j->reference,
						'type'		=> $j->type,
						'memo'		=> $j->memo,
						'created_at' => $j->created_at,
						'updated_at' => $j->updated_at,
						'entries'	=> $entries->result()
					);
				}
				$this->response(array('results'=>$data, 'msg' => 'result found', 'count'=>$journals->paged->total_rows), 200);
			} else {
				$this->response(array('error'=>'no criteria.', 'msg' => 'no result found'), 200);
			}
		} else {
			$this->response(array('error'=>'no criteria.', 'msg' => 'result found'), 200);
		}	
	}

	function index_post() {
		$requested_data = json_decode($this->post('models'));
		$data = array();
		foreach($requested_data as $j) {
			$journal = new Journal();
			$journal->reference = $j->reference;
			$journal->type = $j->type;
			$journal->memo = $j->memo;
			if($journal->save()) {
				$data[] = array(
					'id' => $journal->id,
					'reference' => $journal->reference,
					'type' => $journal->type,
					'memo' => $journal->memo,
				);
			}	
		}
		if(count($data)>0) {
			$this->response(array('results'=>$data, 'count'=>count($data)), 200);
		} else {
			$this->response(array('error'=>array('code'=>400, 'msg'=>'can not create.'), 'count'=>count($data)), 200);
		}
	}

	function index_put() {
		$requested_data = json_decode($this->put('models'));
		$ids = array();
		foreach($requested_data as $r) {
			$journal = new Journal(null, $this->entity);
			$journal->where('id', $r->id)->get();
			if($journal->reference !== $r->reference) {
				$journal->reference = $r->reference;
			}
			if($journal->reference !== $r->reference) {
				$journal->reference = $r->reference;
			}
			if($journal->memo !== $r->memo) {
				$journal->memo = $r->memo;
			}
			if($journal->save()){
				$ids[] = $journal->id;
			}
		}
		
		$journals = new Journal(null, $this->entity);
		$journals->where_in('id', $ids)->get();
		if($journals->exists() > 0) {
			foreach($journals as $j) {
				$data[] = array(
					'id' => $journal->id,
					'reference' => $journal->reference,
					'type' => $journal->type,
					'memo' => $journal->memo
				);
			}
			$this->response(array('results'=>$data, 'msg' => 'result found', 'count'=>count($data)), 200);
		} else {
			$this->response(array('error'=>'no data', 'msg' => 'no result found'), 200);
		}
	}

	function index_delete(){
		$requested_data = json_decode($this->delete('models'));
		$data = array();
		// loop through journal in case there are multiple data
		foreach($requested_data as $j) {
			$journal = new Journal(null, $this->entity);
			$journal->where('id', $j->id)->get();
			$entries = $journal->entry->get();
			$journal->deleted = true;
			if($journal->save()){
				$data[] = array(
					'id' => $journal->id,
					'reference' => $journal->reference,
					'type' => $journal->type,
					'memo' => $journal->memo
				);
			}
		}
		if(count($data) > 0) {
			$this->response(array('results'=>$data, 'msg' => 'deleted', 'count'=>count($data)), 200);
		} else {
			$this->response(array('error'=>'no data', 'msg' => 'no data deleted'), 200);
		}
	}

	function entries_get() {
		$requested_data = $this->get('filter');
		$filters = $requested_data['filters'];
		$limit = $this->get('limit');
		$page = $this->get('page');

		$entries = new Entry(null, $this->entity);
		// check if filter is set
		if(isset($filters)) {
			foreach($filters as $f) {
				$entries->where($f['field'], $f['value']);
			}
			$entries->get_paged($page, $limit);
			if($entries->exists()) {
				// $entries = $journals->entry->order_by('is_debit', 'asc')->get();
				foreach($entries as $entry) {
					$account = $entry->account->get();
					$journal = $entry->journal->get();
					// $splitAcct= $journal->account->get();
					$segment = $entry->segmentlist->get();
					$segItem = array();
					if($segment->exists()) {
						foreach($segment as $seg) {
							$segItem[] = array(
								'code' => $seg->code
							);
						}
					} else {
						$segItem = array();
					}
									
					$data[] = array(
						'id' 		 => $entry->id,
						'journal' => array('id' =>$journal->id, 'reference'=>$journal->reference,'type'=>$journal->type),
						// 'account'	 => array('id' => $account->id, 'name'=> $account->name),
						'amount' 	 => $entry->amount,
						'memo'		 => $entry->memo,
						'is_debit' 	 => $entry->is_debit,
						'locale' 	 => $entry->locale,
						'rate' 		 => $entry->rate,
						'balance' 	 => $entry->balance,
						'segment'	 => $segItem,	
						'created_at' => $entry->created_at,
						'updated_at' => $entry->updated_at
					);
				}
				$this->response(array('results'=>$data, 'msg' => 'result found', 'count'=>$entries->paged->total_rows), 200);
			} else {
				$this->response(array('error'=>'no criteria.', 'msg' => 'no result found'), 200);
			}
		} else {
			$this->response(array('error'=>'no criteria.', 'msg' => 'result found'), 200);
		}	
	}
	// get all conctat base on journal id
	function contacts_get() {
		$requested_data = $this->get('filter');
		$filters = $requested_data['filters'];
		$limit = $this->get('limit');
		$page= $this->get('page');

		$journal = new Journal(null, $this->entity);
		if(isset($filters)) {
			foreach($filters as $f) {
				$journal->where($f['field'], $f['value']);
			}
			$journal->get();
			if($journals->exists()) {
				$contacts = $journal->contact->get_raw();
				foreach($contacts->result() as $j) {					
					$data[] = $j;
				}
				$this->response(array('results'=>$data, 'msg' => 'result found', 'count'=>count($journal)), 200);
			} else {
				$this->response(array('error'=>'no criteria.', 'msg' => 'no result found'), 200);
			}
		} else {
			$this->response(array('error'=>'no criteria.', 'msg' => 'result found'), 200);
		}
	}

	/* add contacts to journal entry
	* @param: contact and journal data
	*/
	function contacts_post() {
		$requested_data = json_decode($this->post('models'));
		$contactIDs = array();
		foreach($requested_data as $model) {
			$journal = new Journal(null, $this->entity); 
			$journal->where('id', $model->journal)->get();
			$contactIDs[] = $model->journal;
			if($model->contacts) {
				foreach($model->contacts as $c) {
					$contact = new Contact(null, $this->entity);
					$contact->where('id', $c->id)->get();
					$contact->save($journal);
					$contact->set_join_field($journal, 'action', $c->action);
					$contact->save();
				}
			}
		}
		if(count($contactIDs) > 0){
			$contacts = new Contact(null, $this->entity);
			$contacts->where_in('id', $contactIDs)->get_iterated();
			foreach($contacts as $contact) {
				$data[] = array(
					'id' => $contact->id,
					'name' => $contact->name,
					'surname' => $contact->surname,
					'memo' => $contact->memo,
					'status' => $contact->status
				);
			}
			$this->response(array('results'=>$data, 'count'=>count($contactIDs)), 201);
		} else {
			$this->response(array('error'=>array('code'=>2341,'msg'=>'not contact added to journal.'), 'count'=>0), 201);
		}
	}

	public function v4($trim = false) {        
        $format = ($trim == false) ? '%04x%04x-%04x-%04x-%04x-%04x%04x%04x' : '%04x%04x%04x%04x%04x%04x%04x%04x';
    
        return sprintf($format,

                // 32 bits for "time_low"
                mt_rand(0, 0xffff), mt_rand(0, 0xffff),

                // 16 bits for "time_mid"
                mt_rand(0, 0xffff),

                // 16 bits for "time_hi_and_version",
                // four most significant bits holds version number 4
                mt_rand(0, 0x0fff) | 0x4000,

                // 16 bits, 8 bits for "clk_seq_hi_res",
                // 8 bits for "clk_seq_low",
                // two most significant bits holds zero and one for variant DCE1.1
                mt_rand(0, 0x3fff) | 0x8000,

                // 48 bits for "node"
                mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
        );
    }
}