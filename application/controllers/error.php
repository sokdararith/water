<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Error extends MY_Controller {
		
	function __construct() {	
		parent::__construct();
	}
	
	function not_admin() {
		$this->title = "error";
		$this->_render('/error/not_authorized');
	}
	function index() {
		$data['test'] = $this->input->get('cmd');
		$this->load->view('test', $data);
	}
}	