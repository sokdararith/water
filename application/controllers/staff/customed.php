<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); //disallow direct access to this file

class Customed extends CI_Controller {
	
	function __contruct() {
		parent::__constuct();
		
	}
	
	function addDept() {
		$data['main_content'] = 'staff/department_view';
		$this->load->view('template/customed', $data);
	}
	
	function addJob() {
		$data['main_content'] = 'staff/job_view';
		$this->load->view('template/customed', $data);
		
	}
	
	function addNationality() {
		$data['main_content'] = 'staff/nationality_view';
		$this->load->view('template/customed', $data);
		
	}
}