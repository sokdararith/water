<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {
	
	function __construct() {
		parent::__construct();
		// if(!$this->session->userdata('logged_in')) {
		// 	// redirect('/');
		// } else {
		// 	redirect('app');
		// }
	}
	
	public function index() {	
		
		/*
		 *set up title and keywords (if not the default in custom.php config file will be set) 
		 */

		$this->load->view("template");
		
		
	}
	
	public function dashboard() {
		echo $this->session->userdata('user_id');
	}
	
}

/* End of file home.php */
/* Location: ./application/controllers/home.php */