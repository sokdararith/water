<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); //disallow direct access to this file

class Dashboard extends MY_Controller {
	
	function __contruct() {
		parent::__constuct();
		
	}
	
	function index() {
		
		echo "Staff Page";
	}
}