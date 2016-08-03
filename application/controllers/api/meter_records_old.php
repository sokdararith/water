<?php defined('BASEPATH') OR exit('No direct script access allowed');


require APPPATH.'/libraries/REST_Controller.php';

class Meter_records extends REST_Controller {
		
	//CONSTRUCTOR
	function __construct() {
		parent::__construct();		
		$this->load->model('inventory/meter_record_model', 'meter_record');
		$this->load->model('inventory/meter_model', 'meter');
		$this->load->model('inventory/electricity_box_model', 'electricity_box');
		$this->load->model("people/people_model", "people");

		$this->load->model('tariffs/Tariff_model', 'tariff');
		$this->load->model('tariffs/Tariff_item_model', 'tariff_item');			
	}	
	
	
	//GET 
	function meter_record_get() {
		$filters = $this->get("filter")["filters"];
		$logic = $this->get("filter")["logic"];
		$limit = $this->get("pageSize");
		$offset = $this->get('skip');
		$sorter = $this->get("sort");		
		$data["results"] = array();
		$data["total"] = 0;

		//Limit
		if(!empty($limit) && isset($limit)){
			$this->meter_record->limit($limit, $offset);
		}

		//Sort
		if(!empty($sorter) && isset($sorter)){			
			$sort = array();
			foreach ($sorter as $row) {
				$sort += array($row["field"] => $row["dir"]);
			}			
			$this->meter_record->order_by($sort);
		}		

		//Filter
		if(!empty($filters) && isset($filters)){
			$filter = array();			
			foreach ($filters as $row) {										
				$filter += array($row["field"] => $row["value"]);								
			}

			$data["results"] = $this->meter_record->get_many_by($filter);			
			$data["total"] = $this->meter_record->count_by($filter);				
								
			//Modify field			
			foreach($data["results"] as $key => $value) {				
				$value->new_round = $value->new_round === 'true'? true : false;
				$value->reactive_new_round = $value->reactive_new_round === 'true'? true : false;					  				 
			}										
		}		
		$this->response($data, 200);				
	}
	
	//POST
	function meter_record_post() {		
		$models = json_decode($this->post("models"));		
		
		if(!empty($models) && isset($models)){			
			foreach ($models as $key => $value) {				
				$id = $this->meter_record->insert($value);
				$data["results"][] = $this->meter_record->get($id);
			}			
		}else{
			$post = array(				
				'meter_id'				=> $this->post('meter_id'),
				'customer_id'			=> $this->post('customer_id'),
				'transformer_id'		=> $this->post('transformer_id'),
				'multiplier'			=> $this->post('multiplier'),
			   	'prev_reading'			=> $this->post('prev_reading'),
			   	'new_reading' 			=> $this->post('new_reading'),
			   	'quantity' 				=> $this->post('quantity'),
			   	'add_up'				=> $this->post('add_up'),
			   	'new_round' 			=> $this->post('new_round'),
			   	'reactive_prev_reading'	=> $this->post('reactive_prev_reading'),								   
			   	'reactive_new_reading'	=> $this->post('reactive_new_reading'),
			   	'reactive_quantity'		=> $this->post('reactive_quantity'),
			   	'reactive_add_up'		=> $this->post('reactive_add_up'),
			   	'reactive_new_round'	=> $this->post('reactive_new_round'),			   
			   	'is_backup_reading' 	=> $this->post('is_backup_reading'),
			   	'month_of' 				=> date("Y-m-d", strtotime($this->post("month_of"))),
			   	'date_read_from'		=> date("Y-m-d", strtotime($this->post("date_read_from"))),								   
			   	'date_read_to'			=> date("Y-m-d", strtotime($this->post("date_read_to"))),
			   	'reader' 				=> $this->post('reader'),
			   	'invoice_id'			=> $this->post('invoice_id')					
			);
			$id = $this->meter_record->insert($post);		
			$data["results"] = $this->meter_record->get($id);
		}

		$this->response($data, 201);				
	}
	
	//PUT
	function meter_record_put() {
		$put = array(
					'meter_id'				=> $this->put('meter_id'),
					'customer_id'			=> $this->put('customer_id'),
					'transformer_id'		=> $this->put('transformer_id'),
					'multiplier'			=> $this->put('multiplier'),
				   	'prev_reading'			=> $this->put('prev_reading'),
				   	'new_reading' 			=> $this->put('new_reading'),
				   	'quantity' 				=> $this->put('quantity'),
				   	'add_up'				=> $this->put('add_up'),
				   	'new_round' 			=> $this->put('new_round'),
				   	'reactive_prev_reading'	=> $this->put('reactive_prev_reading'),								   
				   	'reactive_new_reading'	=> $this->put('reactive_new_reading'),
				   	'reactive_quantity'		=> $this->put('reactive_quantity'),
				   	'reactive_add_up'		=> $this->put('reactive_add_up'),
				   	'reactive_new_round'	=> $this->put('reactive_new_round'),			   
				   	'is_backup_reading' 	=> $this->put('is_backup_reading'),
				   	'month_of' 				=> date("Y-m-d", strtotime($this->put("month_of"))),
				   	'date_read_from'		=> date("Y-m-d", strtotime($this->put("date_read_from"))),								   
				   	'date_read_to'			=> date("Y-m-d", strtotime($this->put("date_read_to"))),
				   	'reader' 				=> $this->put('reader'),
				   	'invoice_id'			=> $this->put('invoice_id')					
		);		
		$data["status"] = $this->meter_record->update($this->put('id'), $put);		
		$data["results"] = $this->meter_record->get($this->put('id'));
		
		$this->response($data, 200);
	}
	
	//DELETE
	function meter_record_delete() {
		$data["results"] = $this->meter_record->get($this->delete("id"));		
		$data["status"] = $this->meter_record->delete($this->delete("id"));

		$this->response($data, 200);
	}

	//POST BATCH
	function meter_record_batch_post() {
		$post = json_decode($this->post('models'));
		foreach($post as $key => $value) {			
				$arr[] = $value;			
		}
		$ids = $this->meter_record->insert_many($arr);
		$data["results"] = $this->meter_record->get_many($ids);
		$this->response($data, 200);				
	}

	//UPDATE BATCH
	function meter_record_batch_put(){
		$put = json_decode($this->put("data"));
	   	
		foreach ($put as $key => $value) {
			$ids[] = $value->id;
			$this->meter_record->update($value->id, array("invoice_id"=>$value->invoice_id));
		}

		$data["results"] = $this->meter_record->get_many($ids);
		$this->response($data, 200);	  				
	}	

	//UPDATE READING
	function meter_record_reading_put(){
		$id = $this->put("id");
		$put = json_decode($this->put("data"));
	   		  		  	
		foreach($put as $key => $value) {			
			$data = $value;												
		}

	  	$result = $this->meter_record->update($id, $data);
		$this->response($result, 200);		
	}
		
	//GET METER RECORD BY CUSTOMER ID
	function meter_record_by_customer_get(){
		$filter = $this->get("filter");
		$empty_array = Array();		
		if(!empty($filter) && isset($filter)){
			$arr = $this->meter_record->get_many_by(array($filter['filters'][0]['field']=>$filter['filters'][0]['value'], 'invoice_id'=>0, 'is_backup_reading'=>0));			
			if(count($arr) >0){
				foreach($arr as $row) {					
					$active_usage += ($row->new_reading+$row->new_round)-$row->prev_reading;	
					$reactive_usage += ($row->reactive_new_reading+$row->reactive_new_round)-$row->reactive_prev_reading;							
					
					//Add extra fields
					$extra = array('active_usage'			=> $active_usage,
								   	'reactive_usage'		=> $reactive_usage,
								   	'meters'				=> $this->meter->get($row->meter_id)								   								   							   
							  );

					//Cast object to array
					$original =  (array) $row;

					//Merge arrays
					$data[] = array_merge($original, $extra);	
				}				
				$this->response($data, 200);		
			}else{				
				$this->response($empty_array, 200);
			}
		}else{			
			$this->response($empty_array, 200);	
		}		
	}

	//GET CUSTOMER TOTAL USAGE BY AREA
	function customer_total_usage_by_area_get(){
		$filter = $this->get("filter");
		$empty_array = Array();		
		if(!empty($filter) && isset($filter)){
			$tariffPlanID = 0;
			$tariffID = 0;						
			$pp = $this->people->people_by_type(1)->get_many_by(array($filter['filters'][0]['field']=>$filter['filters'][0]['value'],
																	'status'=>1));
			$data = array();
			if(count($pp)>0){
				foreach($pp as $row) {					
					$totalActiveUsage = 0;
					$totalReactiveUsage = 0;
					$dateReadFrom = date("0000-00-00");
					$dateReadTo = date("0000-00-00");
					$monthOfReading = date("0000-00-00");
					$meters = array();
					$meterRecordIDs = array();

					//Meter list
					$meterList = $this->meter->get_many_by(array('customer_id'=>$row->id, 'status'=>1, 'parent_id'=>0));
					if(count($meterList)>0){
						$hasReading = false;
						foreach($meterList as $m){
							
							$activeMinReading = 0;
							$reactiveMinReading = 0;
							$activeMaxReading = 0;
							$reactiveMaxReading = 0;
							$activeUsage = 0;
							$reactiveUsage = 0;

							//Loop through meter record list
							$meterRecordList = $this->meter_record->get_many_by(array('meter_id'=>$m->id, 'is_backup_reading'=>0, 'invoice_id'=>0));
							if(count($meterRecordList)>0){

								$hasReading = true;
								$nCounter = 0;

								foreach($meterRecordList as $n){
									$meterRecordIDs[] = $n->id;

									//First row
									if($nCounter==0){
										$activeMinReading = $n->prev_reading;
										$reactiveMinReading = $n->reactive_prev_reading;
										$dateReadFrom = $n->date_read_from;
										$monthOfReading = $n->month_of;									
									}

									//Last row
									if($nCounter==count($meterRecordList)-1){
										$activeMaxReading = $n->new_reading;
										$reactiveMaxReading = $n->reactive_new_reading;
										$dateReadTo = $n->date_read_to;
									}

									$activeUsage += $n->new_reading + $n->new_round - $n->prev_reading;
									$reactiveUsage += $n->reactive_new_reading + $n->reactive_new_round - $n->reactive_prev_reading;
									$nCounter++;								
								}//End for($n=0; $i<count($meterRecordList); $n++)
							}//End if(count($meterRecordList)>0)							

							//Add up total usage both active and reactive
							$totalActiveUsage += $activeUsage;
							$totalReactiveUsage += $reactiveUsage;

							//Add array to meter
							$meters[] = array('id' 			=> $m->id,
								    'meter_no'				=> $m->meter_no,
								    'multiplier'			=> $m->multiplier,
								    'status' 				=> $m->status,
								    'ear_sealed' 			=> $m->ear_sealed,
								    'cover_sealed'			=> $m->cover_sealed,								   
								    'tariff_id'				=> $m->tariff_id,
								    'memo'					=> $m->memo,			   
								    'customer_id' 			=> $m->customer_id,
								    'item_id' 				=> $m->item_id,								   
								    'electricity_box_id'	=> $m->electricity_box_id,
								    'date_used' 			=> $m->date_used,
								    'parent_id'				=> $m->parent_id,

								    'tariff_items'			=> $this->tariff_item->order_by('usage', 'desc')
								    								->get_many_by('tariff_id', $m->tariff_id),
								    
								    'active_min_reading'	=> $activeMinReading,
									'active_max_reading'	=> $activeMaxReading,
									'reactive_min_reading'	=> $reactiveMinReading,
									'reactive_max_reading'	=> $reactiveMaxReading,
								    'active_usage'			=> $activeUsage,
								    'reactive_usage'		=> $reactiveUsage								    							   						   
							);
						}

						if($hasReading){						
							//Get tariff items						
							if($tariffPlanID!==$row->tariff_plan_id){
								$tariffPlanID = $row->tariff_plan_id;					
								$planItemArr = $this->plan_item->order_by('start_date', 'desc')
													->get_many_by('tariff_plan_id', $tariffPlanID);

								//Loop through plan item to get tariff id					
								foreach($planItemArr as $p){
									$startDate = $p->start_date;
									if($monthOfReading>=$startDate){
										$tariffID = $p->tariff_id;
										break;
									}
								}
							}//End if($tariffPlanID!==$row->tariff_plan_id)					

							//List of customer						
							$data[] = array('id' 					=> $row->id,									
											'number'				=> $row->number,								   
										   	'fullname'				=> $row->surname.' '.$row->name,
										   	'people_type_id'		=> $row->people_type_id,
										   	'address'				=> $row->house_no.' '.$row->street_no,
										   	'balance'				=> $row->balance,

										   	'maintenance_id'		=> $row->maintenance_id,
										   	'exemption_id'			=> $row->exemption_id,
										   	'tariff_id'				=> $tariffID,
										   	'tariff_items'			=> $this->tariff_item->order_by('usage', 'desc')
																			->get_many_by('tariff_id', $tariffID),

											'meters'				=> $meters,
											'meter_record_ids'		=> $meterRecordIDs,								
											'date_read_from' 		=> $dateReadFrom,
											'date_read_to'			=> $dateReadTo,								   									   	 
											'total_active_usage'	=> $totalActiveUsage,							
											'total_reactive_usage' 	=> $totalReactiveUsage										
							);
						}//End 
						
					}//End if(count($meterList)>0)		
					
			  	
				}//End foreach($pp as $row)		
				$this->response($data, 200);		
			}else{
				$this->response($empty_array, 200);
			}
		}else{
			$this->response($empty_array, 200);	
		}	
	}

	//GET METER RECORD FOR INVOICE
	function meter_record_for_invoice_get(){
		$filters = $this->get("filter")["filters"];		
		$data["results"] = array();
		$data["total"] = 0;

		$strQuery = "
				SELECT meter_records.id AS id, meter_records.*,				
				meters.meter_no,
				electricity_boxes.box_no,
				people.*,
				transformers.transformer_number				
				FROM meter_records				
				INNER JOIN meters ON meters.id = meter_records.meter_id
				INNER JOIN electricity_boxes ON electricity_boxes.id = meters.electricity_box_id
				INNER JOIN people ON people.id = meters.customer_id
				INNER JOIN transformers ON transformers.id = people.transformer_id				
				WHERE meters.status = 1  								
				AND transformers.id = " . $filters[0]["value"] . " 
				AND meter_records.month_of = '" . $filters[1]["value"] . "'";
		
		$query = $this->db->query($strQuery);

		//Add extra fields
		foreach($query->result() as $key => $value) {
			$fullname = $value->number .' '. $value->surname .' '. $value->name;
			if($value->people_type_id==="5" || $value->people_type_id==="6" || $value->people_type_id==="7"){
				$fullname = $value->number .' '. $value->company;
			}

			$extra = array(
				"fullname" 	=> $fullname,
				"isCheck"	=> false
			);
			//Cast object to array
			$original =  (array) $value;

			//Merge arrays
			$data["results"][$key] = array_merge($original, $extra);
		}		
		
		$data["total"] = count($data["results"]);			

		$this->response($data, 200);				
	}

	//LOW CONSUMPTION
	function low_consumption_get(){
		$filters = $this->get("filter")["filters"];		
		$data["results"] = array();
		$data["total"] = 0;

		$strQuery = "
				SELECT meter_records.id, meter_records.meter_id, meter_records.month_of, meter_records.quantity,				
				meters.meter_no,
				electricity_boxes.box_no,
				people.number, people.surname, people.name, people.company, people.people_type_id,
				transformers.transformer_number,
				electricity_units.name AS ampereName
				FROM meter_records				
				INNER JOIN meters ON meters.id = meter_records.meter_id
				INNER JOIN electricity_boxes ON electricity_boxes.id = meters.electricity_box_id
				INNER JOIN people ON people.id = meters.customer_id
				INNER JOIN transformers ON transformers.id = people.transformer_id
				INNER JOIN electricity_units ON electricity_units.id = people.ampere_id 
				WHERE people.company_id = " . $filters[0]["value"] . "
				AND transformers.type = " . $filters[1]["value"] . "
				AND meter_records.quantity <= " . $filters[2]["value"] . " 
				AND meter_records.month_of = '" . $filters[3]["value"] . "'";
		
		$query = $this->db->query($strQuery);

		//Modify field
		foreach($query->result() as $key => $value) {
			$fullname = $value->number .' '. $value->surname .' '. $value->name;
			if($value->people_type_id==="5" || $value->people_type_id==="6" || $value->people_type_id==="7"){
				$fullname = $value->number .' '. $value->company;
			}

			$preReadingList = $this->meter_record->limit(3)
												->order_by("month_of", "DESC")
												->get_many_by(array("meter_id"=>$value->meter_id, "month_of <"=>$value->month_of));
			$m1 = 0; $m2 = 0; $m3 = 0;
			foreach($preReadingList as $k => $v){
				if($k==0){
					$m1 = $v->quantity;
				}
				if($k==1){
					$m2 = $v->quantity;
				}
				if($k==2){
					$m3 = $v->quantity;
				}
			}
			
			$data["results"][] = array(
				"id" 		=> $value->id,				
				"area" 		=> $value->transformer_number, 
				"fullname" 	=> $fullname,								
				"ampere" 	=> $value->ampereName,
				"box_no"	=> $value->box_no,
				"meter_no"	=> $value->meter_no,
				"month3" 	=> $m3,
				"month2" 	=> $m2,
				"month1"	=> $m1,	
				"current" 	=> intval($value->quantity)	
		   	);				
		}			
		$data["total"] = count($data["results"]);			

		$this->response($data, 200);		
	}
	
	//USAGE
	function usage_get() {
		$filter = $this->get("filter");		
		if(!empty($filter) && isset($filter)){
			$para = array();				
			for ($i = 0; $i < count($filter['filters']); ++$i) {				
				$para += array($filter['filters'][$i]['field'] => $filter['filters'][$i]['value']);
			}			
						
			$arr = $this->meter_record->join_meter()->get_many_by($para);
			if(count($arr) >0){
				foreach($arr as $row) {					
					$activeUsage = ($row->new_reading + $row->new_round) - $row->prev_reading;					
					
					$strDate = date("m-y", strtotime($row->month_of));

					//Add extra fields
					$extra = array('active_usage' 	=> $activeUsage,
								   	'strDate'		=> $strDate								   									   					   
					);

					//Cast object to array
					$original =  (array) $row;

					//Merge arrays
					$data[] = array_merge($original, $extra);	
				}
				$this->response($data, 200);		
			}else{
				$empty_array = Array();
				$this->response($empty_array, 200);
			}						
		}else{
			$data = $this->meter_record->get_all();
			$this->response($data, 200);	
		}				
	}

	//READING	
	function reading_get() {		
		$filters = $this->get();		
		$data["results"] = array();
		$data["total"] = 0;
		$isIRreader = false;
		
		$strQuery = "
				SELECT r.id, r.meter_id, r.month_of, r.new_reading, r.reactive_new_reading,
				meters.meter_no, meters.multiplier, meters.max_digit, meters.transformer_id, meters.tariff_id, meters.parent_id,
				electricity_boxes.box_no,
				people.id AS people_id, people.surname, people.name, people.company, people.people_type_id";		
		
		//Filters
		if(!empty($filters) && isset($filters)){			
			if(!empty($filters["meter_no"]) && isset($filters["meter_no"])){
			//Reading by meter number	
				$strQuery .= "
					FROM meter_records AS r
					INNER JOIN meters ON meters.id = r.meter_id
					LEFT JOIN people ON people.id = meters.customer_id
					LEFT JOIN electricity_boxes ON electricity_boxes.id = meters.electricity_box_id";

				 					
				$strQuery .= " WHERE meters.meter_no = '". $filters["meter_no"] ."'";					
				$strQuery .= " ORDER BY r.month_of DESC LIMIT 1";				
			}elseif(!empty($filters["meter_id"]) && isset($filters["meter_id"])){
			//By meter_id
				$strQuery .= "
					FROM meter_records AS r
					INNER JOIN meters ON meters.id = r.meter_id
					LEFT JOIN people ON people.id = meters.customer_id
					LEFT JOIN electricity_boxes ON electricity_boxes.id = meters.electricity_box_id";
				 							
				$strQuery .= " WHERE meters.id = '". $filters["meter_id"] ."'";
				$strQuery .= " ORDER BY r.month_of DESC LIMIT 1";
			}elseif(!empty($filters["transformer_id"]) && isset($filters["transformer_id"])){
			//Normal reading
				$strQuery .= "
					FROM(
					SELECT id, meter_id, month_of, new_reading, reactive_new_reading
					FROM meter_records ";

				if(!empty($filters["month_of"]) && isset($filters["month_of"])){
					$monthOf = $filters["month_of"];
					$strQuery .= " WHERE month_of < '". $filters["month_of"] ."'";
				}

				$strQuery .= "
					ORDER BY month_of DESC
					) AS r INNER JOIN meters ON meters.id = r.meter_id
					LEFT JOIN people ON people.id = meters.customer_id
					LEFT JOIN electricity_boxes ON electricity_boxes.id = meters.electricity_box_id
				 	WHERE meters.status = 1";

				if(!empty($filters["transformer_id"]) && isset($filters["transformer_id"])){
					$transformerID = $filters["transformer_id"];
					$strQuery .= " AND meters.transformer_id = ". $transformerID;
				}				

				$readingList = $this->meter_record->get_many_by(array(
														"transformer_id"=>$transformerID,
														"month_of"=>$monthOf
													));		
				if(count($readingList)>0){			
					$meterIDList = array();
					foreach ($readingList as $row) {
						array_push($meterIDList, $row->meter_id);
					}

					$strMeterIDList = implode(",", $meterIDList);
					$strQuery .= " AND r.meter_id NOT IN (". $strMeterIDList .")";							
				}
				$strQuery .= " GROUP BY r.meter_id";
			}else{
			//IR reader
				$isIRreader = true;
				$strQuery .= "
					FROM(
					SELECT id, meter_id, month_of, new_reading, reactive_new_reading
					FROM meter_records 
					ORDER BY month_of DESC
					) AS r INNER JOIN meters ON meters.id = r.meter_id
					LEFT JOIN people ON people.id = meters.customer_id
					LEFT JOIN electricity_boxes ON electricity_boxes.id = meters.electricity_box_id ";

				$strMeterNoList = "null";						
				for ($i=1; $i < count($filters); $i++) {
					$d = explode(',', $filters[$i]);
					if(count($d)>1){						
						$sr = str_replace(array("\n","\r\n","\r"), '', $d);
						$strMeterNoList .= ','.$sr[0];						
					}									
				}								
				
				$strQuery .= " WHERE meters.meter_no IN (". $strMeterNoList .")";
				$strQuery .= " GROUP BY r.meter_id";							
			}
			
			//Execute query
			$query = $this->db->query($strQuery);							

			foreach ($query->result() as $key => $value) {
				$fullname = $value->surname .' '. $value->name;
				if($value->people_type_id==="5" || $value->people_type_id==="6" || $value->people_type_id==="7"){
					$fullname = $value->company;
				}
				
				$newRead = 0;				
				if($isIRreader){				
					for ($i=1; $i < count($filters); $i++) { 
						$d = explode(',', $filters[$i]);
						if(count($d)>1){
							$sr = str_replace(array("\n","\r\n","\r"), '', $d);							
							if($sr[0]===$value->meter_no){
								$newRead = $sr[1];
								break;
							}
						}
					}
				}				
				
				$data["results"][] = array( 
					"fullname" 				=> $fullname,
					"meter_no" 				=> $value->meter_no,
					"box_no"				=> $value->box_no,
					"max_digit"				=> $value->max_digit,
					"tariff_id" 			=> intval($value->tariff_id),				
					"meter_id"				=> $value->meter_id,
					"customer_id" 			=> $value->people_id,
					"transformer_id" 		=> $value->transformer_id,
					"multiplier" 			=> $value->multiplier,
				   	"prev_reading"			=> intval($value->new_reading),
				   	"new_reading" 			=> intval($newRead),
				   	"add_up"	 			=> 0,
				   	"new_round"				=> false,
				   	"reactive_prev_reading"	=> intval($value->reactive_new_reading),								   
				   	"reactive_new_reading"	=> "",
				   	"reactive_add_up" 		=> 0,
				   	"reactive_new_round"	=> false,		   
				   	"is_backup_reading" 	=> $value->parent_id,
				   	"month_of" 				=> $value->month_of,
				   	"reactive_qty"			=> 0,
				   	"active_qty" 			=> 0
			   	);
			}
			
			$data["total"] = count($data["results"]);								
		}		
		$this->response($data, 200);		
	}

	//READING	
	function unread_get() {
		$filter = $this->get("filter");		
		$para = array();				
		for ($i = 0; $i < count($filter['filters']); ++$i) {				
			$para += array($filter['filters'][$i]['field'] => $filter['filters'][$i]['value']);
		}
		$transformer_id = $para["transformer_id"];
		$month_of = $para["month_of"];
		
		$arr = $this->meter->order_by("customer_id", "asc")
							->get_many_by(array(
								"transformer_id"=>$transformer_id,
								"status"=>1
							));

		$data = array();
		if(count($arr)>0){
		 	$meterIds = array();
			foreach ($arr as $row) {
				array_push($meterIds, $row->id);
			}
								
			$readingRecorded = $this->meter_record->where_in("meter_id", $meterIds)
											->distinct("meter_id")											
											->get_many_by("month_of",$month_of);
			//Unread meter ids
			$unreadMeterIds = array();
			if(count($readingRecorded)>0){
				$readIds = array();												
				foreach ($readingRecorded as $row) {
					array_push($readIds, $row->meter_id);					
				}

				$arrDiff = array_diff($meterIds, $readIds);
				foreach ($arrDiff as $row) {
					array_push($unreadMeterIds, $row);
				}				
			}else{
			 	$unreadMeterIds = $meterIds;
			}
			
			$meterList = $this->meter->where_in("id", $unreadMeterIds)
							->order_by("customer_id", "asc")
							->get_all();
			$meterRecord = $this->meter_record->where_in("meter_id", $unreadMeterIds)
											->distinct("meter_id")
											->order_by("month_of", "desc")
											->get_all();	
			
			$customer_id = 0;
			$people = null;
			foreach ($meterList as $row) {
				$month_of = "";
				$prev_reading = "";
				$reactive_prev_reading = "";
				if(count($meterRecord)>0){
					foreach ($meterRecord as $mr) {
						if($mr->meter_id===$row->id){
							$month_of = $mr->month_of;
							$prev_reading = $mr->new_reading;
							$reactive_prev_reading = $mr->reactive_new_reading;
							break;
						}
					}					
				}

				if($row->customer_id!==$customer_id){
					$people = $this->people->get($row->customer_id);
					$customer_id = $row->customer_id;
				}

			   	//Add extra fields
				$extra = array('people'				=> $people,						    
						    'electricity_boxes'		=> $this->electricity_box->get($row->electricity_box_id),						    
						    'month_of' 				=> $month_of,
						    'rcheckNewRound'		=> false,
						    'reactive_prev_reading'	=> $reactive_prev_reading,				  		
					  		'reactive_new_reading' 	=> "",
					  		'checkNewRound'			=> false,
					  		'prev_reading'			=> $prev_reading,					  		
					  		'new_reading'			=> ""						   	
						  );

				//Cast object to array
				$original = (array) $row;

				//Merge arrays
				$data[] = array_merge($original, $extra);	
			}
		}
		$this->response($data, 200);			
	}


}//End Of Class