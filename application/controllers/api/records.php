<?php defined('BASEPATH') OR exit('No direct script access allowed');


require APPPATH.'/libraries/REST_Controller.php';

class Records extends REST_Controller {
	
	//CONSTRUCTOR
	function __construct() {
		parent::__construct();
		$this->entity = $this->input->get_request_header('Entity');
	}

	// get all records based on item id
	public function index_get() {}

	// models = {id: null, amount: 0.00, unit: 1, is_in: true, item:{id: 1, sku: 'ewew', name: 'dfsfds'}}
	public function index_post() {
		$requested_data = json_decode($this->post('models'));
		// weighted average cost formula
		// (cost beginning + cost purchase) / (inventory unit beginning + inventory purchase)
		// cost begining = cost before purchase; inventory unit beginning = inventory before purchase
		$data = array();
		foreach($requested_data as $res) {
			$entry = new Itemrecord(null, $this->entity);
			$entry->item_id = $res->item->id;
			$entry->amount = floatval($res->amount);
			$entry->unit = intval($res->unit);
			$entry->is_in = $res->is_in;
				
			if($entry->save()){
				$item = new Item(null, $this->entity);
				$item->where('id', $res->item->id)->get();
				if($entry->is_in === "true") {
					// buy item in
					$cost = floatval($item->cost) * intval($item->on_hand);
					$wac = ($cost + ($res->amount * $res->unit)) / ($item->on_hand + $res->unit);
					$item->cost = $cost;
					// $item->on_hand = $item->on_hand + $res->unit;
					 $item->on_hand = 200;
				} else {
					// sell out
					$item->on_hand = $item->on_hand + $res->unit;
				}
				$item->save();
				$data[] = array(
					'id' => $entry->id,
					'amount' => floatval($entry->amount),
					'is_in' => (bool )$entiry->is_in,
					'unit' => intval($entry->unit),
					'item' => $item
				);
			}
		}
		if(count($data) > 0) {
			$this->response(array('results'=>$data, 'count'=>count($data)), 201);
		} else {
			$this->response(array('error'=>array('msg'=>'no data was saved'), 'count'=>count($data)), 200);
		}
	}

	// item adjust
	// models = {id: null, amount: 0.00, unit: 1, is_in: true, item:{id: 1, sku: 'ewew', name: 'dfsfds'}}
	public function index_put() {
		// take wac as base
		$requested_data = json_decode($this->put('models'));
		$data = array();
		foreach($requested_data as $res) {
			$record = new Itemrecord(null, $this->entity);
			$record->where('id', $res->id)->get();

			$item = new Item(null, $this->entity);
			$item->where('id', $res->item->id)->get();
			if($res->is_in) {
				if($res->unit > $record->unit) {
					// add to on hand
					$temp = intval($res->unit) - intval($record->unit);
					$tUnit= intval($item->unit);
					$item->unit = $tUnit + $temp;
					$item->save();
				} else {
					// deduct from on hand
					$temp = intval($record->unit) - intval($res->unit);
					$tUnit= intval($item->unit);
					$item->unit = $tUnit - $temp;
					$item->save();
				}
			}
		}
	}

	public function index_delete() {

	}
}