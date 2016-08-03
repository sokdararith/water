<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Demo extends MY_Controller {
	
	function __construct() {
		parent::__construct();
		// if(!$this->session->userdata('logged_in')) {
		// 	redirect('home');
		// }
	}
	
	public function index() {	
		
		/*
		 *set up title and keywords (if not the default in custom.php config file will be set) 
		 */
		$data['author'] = "";
		$data['description'] = "";
		$data['keywords'] = "";
		$this->_render("app/demo_view", $data);
		
	}

	public function rith() {
		$this->_render("app/rith_view");
	}

	public function accountant() {
		$this->_render("app/test_view");
	}

	public function supplier() {
		$this->_render("app/test_view");
	}

	public function client() {
		$this->_render("app/test_view");
	}

	public function donor() {
		$this->_render("app/test_view");
	}

	public function dawine() {
		$this->_render("app/dawine_view");
	}

	public function heang() {
		$this->_render("app/heang_view");
	}

	public function check() {
		$this->_render("app/manage_view");
	}
}

/* End of file app.php */
/* Location: ./application/controllers/app.php */