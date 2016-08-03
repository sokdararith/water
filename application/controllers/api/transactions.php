<?php defined('BASEPATH') OR exit('No direct script access allowed');


require APPPATH.'/libraries/REST_Controller.php';

class Transactions extends REST_Controller {
	
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
		 
	public function index_get() {}
	
	/* param
	* journal and items
	*/

	public function index_post() {
		$posted = json_decode($this->post('models'));
		foreach($posted as $row) {
			$trnx = new Transaction();
			$trnx->reference = $row->reference;
			$trnx->type = $row->type;
			$trnx->memo = $row->memo;
			$trnx->company_id = $row->company_id;
			$trnx->structure_id = $row->structure_id;
			$trnx->created_by = $row->created_by;
			$trnx->updated_by = $row->updated_by;
			$trnx->save();
			foreach($row->items as $item) {
				$jEntry = new Journal_entry();
				$jEntry->amount = $item->amount;
				$jEntry->memo = $item->memo;
				$jEntry->is_debit = $item->is_debit;
				$jEntry->deleted = 'false';
				$jEntry->save($trnx);
			}
		}
		$trnx->Journal_entry->where('deleted', 'false')->get();
		foreach($trnx->Journal_entry as $entry) {
			$entries[] = array(
							'amount' => $entry->amount,
							'memo' => $entry->memo,
							'is_debit' => $entry->is_debit
						 );
		}
		$data[] = array(
			'id' => $trnx->id,
			'type'=> $trnx->type,
			'memo'=> $trnx->memo,
			'entries'=> $entries
			);
		$this->response(array('results'=>$data), 200);
	}
	
	/* param
	* journal and items
	*/
	public function index_put() {}
	
	/* param
	* journal and items
	*/
	public function index_delete() {}
	
}//End Of Class