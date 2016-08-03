<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Example
 *
 * This is an example of a few basic user interaction methods you could use
 * all done with a hardcoded array.
 *
 * @package		CodeIgniter
 * @subpackage	Rest Server
 * @category	Controller
 * @author		Phil Sturgeon
 * @link		http://philsturgeon.co.uk/code/
*/

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
require APPPATH.'/libraries/REST_Controller.php';

class Resources extends REST_Controller
{
	function __construct() {
		parent::__construct();
		$this->load->model('Accounting_model');
	}
	
	public function index_get() {
		$this->response(array("msg"=>"Test"), 200);
	}
	
	public function types_get() {
		$types = $this->Accounting_model->getType();
		
		$this->response($types, 200);
	}
	
	public function users_get() {
		
	}
	
	public function users_post() {
		
	}
	
	public function users_put() {
		
	}
	
	public function users_delete() {
		
	}
	
	public function jobs_get() {
		
	}
	
	public function jobs_post() {
		
	}
	
	public function jobs_put() {
		
	}
	
	public function jobs_delete() {
		
	}
	
	public function accounts_get() {
		$data = $this->Accounting_model->getAllAcct();
		
		$this->response($data, 200);
	}
	
	public function accounts_post() {
		$data = $this->post();
		
		foreach ( $data as $k => $v ) :
			if ( $this->Accounting_model->acctExist($data['code']) ) :
				$this->response(array("msg"=>"Existed."), 401);
			else :
				$account = $this->Accounting_model->createAcct($data);
		
				if($account) :
					$this->response(array("status"=>"Account successfully created."), 200);
				else :
					$this->response(array("status"=>"Account already existed."), 400);
				endif;
			endif;
		endforeach;
		//$this->response($this->post(), 200);
	}
	
	public function accounts_put() {
		$json = $this->put();
		$id = $json["id"];
  		
		$this->Accounting_model->updateAcct($id, array('name'=>$json["name"]));
	}
	
	public function accounts_delete() {
		$json = $this->delete();
		$id = $json["id"];
		
		if($this->Accounting_model->deleteAcct($id)) :
		  	$this->response(array("msg"=>"deleted $id"), 200);
		else :
			$this->response(array("msg"=>"cannot delete"), 500);	
		endif;
		
	}
	
	public function vouchers_get() {
		
	}
	
	public function vouchers_post() {
		
	}
	
	public function vouchers_put() {
		
	}
	
	public function vouchers_delete() {
		
	}
}