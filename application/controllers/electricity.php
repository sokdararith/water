<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Electricity extends MY_Controller {

	function __construct() {
		parent::__construct();
		if(!$this->session->userdata('logged_in')) {
			redirect('auth');
		}
	}

	public function index()
	{
		$this->title = "អគ្គីសនី";
		$this->_render("electricity/home_view");		
	}

	public function section($section) {
		if($section === 'licensees') {
			//
			$this->title = "អតិថិជនកាន់អាជ្ញាប័ណ្ណ";
			$this->load->view("electricity/licensee_view");
		} elseif ($section === 'distribution') {
			//
			echo ("distribution");
		} elseif ($section === 'power_consumption') {
			//
			echo ("power consumption");
		} else {
			//
			echo ("transformer consumption");
		}
	}

	public function power_consumption() {
		$this->title = "អគ្គីសនី";		
		$this->_render("electricity/power_view");
	}

	public function transformers() {
		$this->title = "អគ្គីសនី";
		$this->_render("electricity/transformer_view");
	}

	public function transformerType() {
		$this->title = "អគ្គីសនី";
		$this->_render("electricity/transformer_type_view");
	}

	public function licensees() {
		$this->title = "អតិថិជនកាន់អាជ្ញាប័ណ្ណ";
		$this->_render("electricity/licensee_view");
	}

	public function transfered_line() {
		$this->title = "មធ្យោបាយចែកចាយ";
		$this->_render("electricity/transfered_line_view");
	}

	public function transformer_list() {
		$this->title = "ត្រង់ស្វូ";
		$this->_render("electricity/transformer_2_view");
	}

}

/* End of file electricity.php */
/* Location: ./application/controllers/electricity.php */