<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Timesheet extends My_Controller {

	function __construct() {
		parent::__construct();
	}

	public function index()
	{
		$this->_render("/timesheet/home_view");
	}

}

/* End of file contact.php */
/* Location: ./application/controllers/contact.php */