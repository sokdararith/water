<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dawine extends MY_Controller {
	
	function __construct() {
		parent::__construct();
		
	}
	
	public function index() {	
		
		/*
		 *set up title and keywords (if not the default in custom.php config file will be set) 
		 */
		$this->_render("app/dawine_view");
		
	}	
}

/* End of file app.php */
/* Location: ./application/controllers/app.php */