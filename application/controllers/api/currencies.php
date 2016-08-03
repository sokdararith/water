<?php defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH.'/libraries/REST_Controller.php';

class Currencies extends REST_Controller {
	public $_database;
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
	
	//GET 
	function index_get() {		
		$filters 	= $this->get("filter")["filters"];		
		$page 		= $this->get('page') !== false ? $this->get('page') : 1;		
		$limit 		= $this->get('limit') !== false ? $this->get('limit') : 100;								
		$sort 	 	= $this->get("sort");		
		$data["results"] = array();
		$data["count"] = 0;

		$obj = new Currency(null, $this->_database);		

		//Sort
		if(!empty($sort) && isset($sort)){					
			foreach ($sort as $value) {
				$obj->order_by($value["field"], $value["dir"]);
			}
		}
		
		//Filter		
		if(!empty($filters) && isset($filters)){			
	    	foreach ($filters as $value) {
	    		if(!empty($value["operator"]) && isset($value["operator"])){
		    		if($value["operator"]=="where_in"){
		    			$obj->where_in($value["field"], $value["value"]);
		    		}else if($value["operator"]=="or_where_in"){
		    			$obj->or_where_in($value["field"], $value["value"]);
		    		}else if($value["operator"]=="where_not_in"){
		    			$obj->where_not_in($value["field"], $value["value"]);
		    		}else if($value["operator"]=="or_where_not_in"){
		    			$obj->or_where_not_in($value["field"], $value["value"]);
		    		}else if($value["operator"]=="like"){
		    			$obj->like($value["field"], $value["value"]);
		    		}else if($value["operator"]=="or_like"){
		    			$obj->or_like($value["field"], $value["value"]);
		    		}else if($value["operator"]=="not_like"){
		    			$obj->not_like($value["field"], $value["value"]);
		    		}else if($value["operator"]=="or_not_like"){
		    			$obj->or_not_like($value["field"], $value["value"]);
		    		}else if($value["operator"]=="startswith"){
		    			$obj->like($value["field"], $value["value"], "after");
		    		}else if($value["operator"]=="endswith"){
		    			$obj->like($value["field"], $value["value"], "before");
		    		}else if($value["operator"]=="contains"){
		    			$obj->like($value["field"], $value["value"], "both");
		    		}else if($value["operator"]=="or_where"){
		    			$obj->or_where($value["field"], $value["value"]);
		    		}else{
		    			$obj->where($value["field"].' '.$value["operator"], $value["value"]);
		    		}
	    		}else{
	    			$obj->where($value["field"], $value["value"]);
	    		}
			}									 			
		}
		
		$obj->get_paged_iterated($page, $limit);
		$data["count"] = $obj->paged->total_rows;		

		if($obj->result_count()>0){			
			foreach ($obj as $value) {				
				//Results				
				$data["results"][] = array(
					"id" 		=> $value->id,					
					"code" 		=> $value->code,
					"country" 	=> $value->country,
					"locale" 	=> $value->locale,
					"group" 	=> $value->group,					
					"status" 	=> $value->status
				);
			}
		}

		//Response Data		
		$this->response($data, 200);		
	}
	
	//POST
	function index_post() {
		$models = json_decode($this->post('models'));

		foreach ($models as $value) {
			$obj = new Currency(null, $this->_database);			
			$obj->code 		= $value->code;
			$obj->country 	= $value->country;
			$obj->locale 	= $value->locale;
			$obj->group 	= $value->group;
			$obj->status 	= $value->status;
									
			if($obj->save()){
				$data["results"][] = array(
					"id" 		=> $value->id,					
					"code" 		=> $value->code,
					"country" 	=> $value->country,
					"locale" 	=> $value->locale,
					"group" 	=> $value->group,					
					"status" 	=> $value->status
				);
			}
		}
		$data["count"] = count($data["results"]);
		
		$this->response($data, 201);						
	}

	//PUT
	function index_put() {
		$models = json_decode($this->put('models'));
		$data["results"] = array();
		$data["count"] = 0;

		foreach ($models as $value) {			
			$obj = new Currency(null, $this->_database);
			$obj->get_by_id($value->id);

			$obj->code 		= $value->code;
			$obj->country 	= $value->country;
			$obj->locale 	= $value->locale;
			$obj->group 	= $value->group;
			$obj->status 	= $value->status;			

			if($obj->save()){				
				$data["results"][] = array(
					"id" 		=> $value->id,					
					"code" 		=> $value->code,
					"country" 	=> $value->country,
					"locale" 	=> $value->locale,
					"group" 	=> $value->group,					
					"status" 	=> $value->status	
				);		
			}
		}
		$data["count"] = count($data["results"]);

		$this->response($data, 200);
	}
	
	//DELETE
	function index_delete() {
		$models = json_decode($this->delete('models'));

		foreach ($models as $key => $value) {
			$obj = new Currency(null, $this->_database);
			$obj->where("id", $value->id)->get();
			
			$data["results"][] = array(
				"data"   => $value,
				"status" => $obj->delete()
			);							
		}

		//Response data
		$this->response($data, 200);
	}


	//GET RATE
	function rate_get() {		
		$filters 	= $this->get("filter")["filters"];		
		$page 		= $this->get('page') !== false ? $this->get('page') : 1;		
		$limit 		= $this->get('limit') !== false ? $this->get('limit') : 100;								
		$sort 	 	= $this->get("sort");		
		$data["results"] = array();
		$data["count"] = 0;

		$obj = new Currency_rate(null, $this->_database);		

		//Sort
		if(!empty($sort) && isset($sort)){					
			foreach ($sort as $value) {
				$obj->order_by($value["field"], $value["dir"]);
			}
		}
		
		//Filter		
		if(!empty($filters) && isset($filters)){			
	    	foreach ($filters as $value) {
	    		if(!empty($value["operator"]) && isset($value["operator"])){
		    		if($value["operator"]=="where_in"){
		    			$obj->where_in($value["field"], $value["value"]);
		    		}else if($value["operator"]=="or_where_in"){
		    			$obj->or_where_in($value["field"], $value["value"]);
		    		}else if($value["operator"]=="where_not_in"){
		    			$obj->where_not_in($value["field"], $value["value"]);
		    		}else if($value["operator"]=="or_where_not_in"){
		    			$obj->or_where_not_in($value["field"], $value["value"]);
		    		}else if($value["operator"]=="like"){
		    			$obj->like($value["field"], $value["value"]);
		    		}else if($value["operator"]=="or_like"){
		    			$obj->or_like($value["field"], $value["value"]);
		    		}else if($value["operator"]=="not_like"){
		    			$obj->not_like($value["field"], $value["value"]);
		    		}else if($value["operator"]=="or_not_like"){
		    			$obj->or_not_like($value["field"], $value["value"]);
		    		}else if($value["operator"]=="startswith"){
		    			$obj->like($value["field"], $value["value"], "after");
		    		}else if($value["operator"]=="endswith"){
		    			$obj->like($value["field"], $value["value"], "before");
		    		}else if($value["operator"]=="contains"){
		    			$obj->like($value["field"], $value["value"], "both");
		    		}else if($value["operator"]=="or_where"){
		    			$obj->or_where($value["field"], $value["value"]);
		    		}else{
		    			$obj->where($value["field"].' '.$value["operator"], $value["value"]);
		    		}
	    		}else{
	    			$obj->where($value["field"], $value["value"]);
	    		}
			}									 			
		}
		
		$obj->get_paged_iterated($page, $limit);
		$data["count"] = $obj->paged->total_rows;		

		if($obj->result_count()>0){			
			foreach ($obj as $value) {				
				//Results				
				$data["results"][] = array(
					"id" 			=> $value->id,					
					"currency_id" 	=> $value->currency_id,
					"user_id" 		=> $value->user_id,
					"rate" 			=> floatval($value->rate),
					"source" 	 	=> $value->source,
					"method" 		=> $value->method,
					"date" 			=> $value->date,

					"currency" 		=> $value->currency->get_raw()->result()	
				);
			}
		}

		//Response Data		
		$this->response($data, 200);		
	}
	
	//POST RATE
	function rate_post() {
		$models = json_decode($this->post('models'));

		foreach ($models as $value) {
			$obj = new Currency_rate(null, $this->_database);			
			$obj->currency_id 	= $value->currency_id;
			$obj->user_id 		= $value->user_id;
			$obj->rate 			= $value->rate;
			$obj->source 		= $value->source;
			$obj->method 		= $value->method;
			$obj->date 			= $value->date;			
						
			if($obj->save()){
				$data["results"][] = array(
					"id" 			=> $obj->id,					
					"currency_id" 	=> $obj->currency_id,
					"user_id" 		=> $obj->user_id,
					"rate" 			=> floatval($obj->rate),
					"source" 	 	=> $obj->source,
					"method" 		=> $obj->method,
					"date" 			=> $obj->date,

					"currency" 		=> $obj->currency->get_raw()->result()
				);
			}
		}
		$data["count"] = count($data["results"]);
		
		$this->response($data, 201);						
	}

	//PUT RATE
	function rate_put() {
		$models = json_decode($this->put('models'));
		$data["results"] = array();
		$data["count"] = 0;

		foreach ($models as $value) {			
			$obj = new Currency_rate(null, $this->_database);
			$obj->get_by_id($value->id);

			$obj->currency_id 	= $value->currency_id;
			$obj->user_id 		= $value->user_id;
			$obj->rate 			= $value->rate;
			$obj->source 		= $value->source;
			$obj->method 		= $value->method;
			$obj->date 			= $value->date;			

			if($obj->save()){				
				$data["results"][] = array(
					"id" 			=> $obj->id,					
					"currency_id" 	=> $obj->currency_id,
					"user_id" 		=> $obj->user_id,
					"rate" 			=> floatval($obj->rate),
					"source" 	 	=> $obj->source,
					"method" 		=> $obj->method,
					"date" 			=> $obj->date,

					"currency" 		=> $obj->currency->get_raw()->result()	
				);		
			}
		}
		$data["count"] = count($data["results"]);

		$this->response($data, 200);
	}
	
	//DELETE RATE
	function rate_delete() {
		$models = json_decode($this->delete('models'));

		foreach ($models as $key => $value) {
			$obj = new Currency_rate(null, $this->_database);
			$obj->where("id", $value->id)->get();
			
			$data["results"][] = array(
				"data"   => $value,
				"status" => $obj->delete()
			);							
		}

		//Response data
		$this->response($data, 200);
	}


	// //GET	 
	// public function index_get() {
	// 	$requested_data = $this->get('filter');
	// 	$filters = $requested_data['filters'];
	// 	$limit = $this->get('limit') !== false ? $this->get('limit') : 100;
	// 	$page = $this->get('page') !== false ? $this->get('page') : 1;
	// 	$data = array();
		
	// 	$currencies = new Currency(null, $this->_database);
	// 	if(isset($filters)) {
	// 		foreach($filters as $f) {
	// 			if($f['operator'] === 'or') {
	// 				$currencies->or_where($f['field'], $f['value']);
	// 			} elseif($f['operator'] === 'and') {
	// 				$currencies->where($f['field'], $f['value']);
	// 			} else {
	// 				$currencies->where($f['field'], $f['value']);
	// 			}
				
	// 		}
	// 		$this->benchmark->mark('benchmark_start');
	// 		$currencies->get_paged($page, $limit);
	// 		foreach($currencies as $row) {
	// 			$data[] = array(
	// 				'id' => $row->id,
	// 				'code' => $row->code,
	// 				'country'=> $row->country,
	// 				'locale' => $row->locale,
	// 				'rate' => $row->rate,
	// 				'updated_method' => $row->update_method
	// 			);
	// 		}
	// 		if(count($data) > 0) {
	// 			$this->benchmark->mark('benchmark_end');
	// 			$this->response(array('results'=>$data, 'msg' => 'result found', 'count'=>$currencies->paged->total_rows, 'generatedIn'=>$this->benchmark->elapsed_time('benchmark_start', 'benchmark_end')), 200);
	// 		} else {
	// 			$this->response(array('error'=>'no criteria.', 'msg' => 'no result found'), 200);
	// 		}
	// 	} else {
	// 		$this->benchmark->mark('benchmark_start');
	// 		$currencies->get_paged($page, $limit);
	// 		// $cur = $currencies->get_raw();
	// 		// foreach($cur->result() as $row) {
	// 		// 	$data[] = $row;
	// 		// }
	// 		foreach($currencies as $row) {
	// 			$data[] = array(
	// 				'id' => $row->id,
	// 				'code' => $row->code,
	// 				'country'=> $row->country,
	// 				'locale' => $row->locale,
	// 				'rate' => $row->rate,
	// 				'update_method' => $row->update_method,
	// 				'enabled'	=> $row->enabled === 'true' ? TRUE:FALSE,
	// 				'updated_at' => $row->updated_at
	// 			);
	// 		}
	// 		// $currencies->paged->total_rows
	// 		if(count($data) > 0) {
	// 			$this->benchmark->mark('benchmark_end');
	// 			$this->response(array('results'=>$data, 'msg' => 'result found', 'count'=>count($data), 'generatedIn'=>$this->benchmark->elapsed_time('benchmark_start', 'benchmark_end')), 200);
	// 		} else {
	// 			$this->response(array('error'=>'no result.', 'msg' => 'no result found'), 200);
	// 		}
	// 	}
	// }

	// //POST
	// public function index_post() {
	// 	$requested_data = json_decode($this->post('models'));
	// 	$data = array();
	// 	$this->benchmark->mark('benchmark_start');
	// 	foreach($requested_data as $res) {
	// 		$currency = new Currency(null, $this->_database);
	// 		$currency->code = $res->code;
	// 		$currency->country= $res->country;
	// 		$currency->locale = $res->locale;
	// 		$currency->rate= $res->rate;
	// 		$currency->enabled = 'true';

	// 		if($currency->save()) {
	// 			$data[] = array(
	// 				'id' => $currency->id,
	// 				'code' => $currency->code,
	// 				'country'=> $currency->country,
	// 				'locale' => $currency->locale,
	// 				'rate' => $currency->rate,
	// 				'update_method' => $currency->update_method
	// 			);
	// 		}
	// 	}
	// 	$this->benchmark->mark('benchmark_end');
	// 	if(count($data) > 0) {
	// 		$this->response(array('results'=>$data, 'msg' => 'result found', 'count'=>count($data), 'generatedIn'=>$this->benchmark->elapsed_time('benchmark_start', 'benchmark_end')), 201);
	// 	} else {
	// 		$this->response(array('error'=>'no result.', 'msg' => 'no result found', 'generatedIn'=>$this->benchmark->elapsed_time('benchmark_start', 'benchmark_end')), 200);
	// 	}
	// }

	// //PUT
	// public function index_put() {
	// 	$requested_data = json_decode($this->put('models'));
	// 	$data = array();
	// 	$this->benchmark->mark('benchmark_start');
	// 	foreach($requested_data as $res) {
	// 		$currency = new Currency(null, $this->_database);
	// 		$currency->where('id', $res->id)->get();
	// 		$currency->code = $res->code;
	// 		$currency->country= $res->country;
	// 		$currency->locale = $res->locale;
	// 		$currency->rate= $res->rate;
	// 		$currency->update_method = $res->update_method;
	// 		$currency->enabled = $res->enabled;
			
	// 		if($currency->save()) {
	// 			$data[] = array(
	// 				'id' => $currency->id,
	// 				'code' => $currency->code,
	// 				'country'=> $currency->country,
	// 				'locale' => $currency->locale,
	// 				'rate' => $currency->rate,
	// 				'update_method' => $currency->update_method
	// 			);
	// 		}
	// 	}
	// 	$this->benchmark->mark('benchmark_end');
	// 	if(count($data) > 0) {
	// 		$this->response(array('results'=>$data, 'msg' => 'result found', 'count'=>count($data), 'generatedIn'=>$this->benchmark->elapsed_time('benchmark_start', 'benchmark_end')), 201);
	// 	} else {
	// 		$this->response(array('error'=>'no result.', 'msg' => 'no result found', 'generatedIn'=>$this->benchmark->elapsed_time('benchmark_start', 'benchmark_end')), 200);
	// 	}
	// }

}