<?php defined('BASEPATH') OR exit('No direct script access allowed');


require APPPATH.'/libraries/REST_Controller.php';

class Average_records extends REST_Controller {
	
	
	//CONSTRUCTOR
	function __construct() {
		parent::__construct();		
		$this->load->model('inventory/average_record_model', 'average_record');
		$this->load->model('inventory/meter_record_model', 'meter_record');		
	}
	
	
	
	//GET 
	function average_record_get() {		
		$filter = $this->get("filter");		
		if(!empty($filter) && isset($filter)){			
			$para = array();				
			for ($i = 0; $i < count($filter['filters']); ++$i) {				
				$para += array($filter['filters'][$i]['field'] => $filter['filters'][$i]['value']);
			}			
			$arr = $this->average_record->get_many_by($para);
		
			if(count($arr) >0){				
				foreach($arr as $row) {
					$meterRecord = $this->meter_record->get($row->meter_record_id);

					//Active usage
					$newRound = 0;
					if($meterRecord->new_round==1){
						$newRound = 10000;
					}
					$activeUsage = ($meterRecord->new_reading + $newRound) - $meterRecord->prev_reading;

					//Reactive usage
					$reactiveNewRound = 0;
					if($meterRecord->new_round==1){
						$reactiveNewRound = 10000;
					}
					$reactiveUsage = ($meterRecord->reactive_new_reading + $reactiveNewRound) - $meterRecord->reactive_prev_reading;

				   	//Add extra fields
					$extra = array( 'meter_records'	=> $meterRecord,
									'active_usage' 		=> $activeUsage,
								   	'reactive_usage'	=> $reactiveUsage								   	
							  );

					//Cast object to array
					$original = (array) $row;

					//Merge arrays
					$data[] = array_merge($original, $extra);	
				}
				$this->response($data, 200);		
			}else{
				$this->response(FALSE, 200);
			}
		}else{
			$data = $this->average_record->get_all();
			$this->response($data, 200);
		}		
	}
	
	//POST
	function average_record_post() {
		$data = $this->post();
		$id = $this->average_record->insert($data);		
		$this->response($id, 200);						
	}
	
	//PUT
	function average_record_put() {
		$data = $this->put();
		$this->average_record->update($this->put('id'), $data);
	}
	
	//DELETE
	function average_record_delete() {
		//$this->response(array("status"=>$this->delete('id')), 200);
		$this->average_record->delete($this->delete('id'));
	}


}//End Of Class