<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); //disallow direct access to this file

require APPPATH.'/libraries/REST_Controller.php';

class Permissions extends REST_Controller {
	
	function __construct() {
		parent::__construct();
	}

	/*
	* get permission(s) based on filter, limit and offset
	* param filter, limit, offset
	*/
	function index_get() {
		$filter = $this->get('filter')?$this->get('filter'): null;
		$limit = $this->get('limit');
		$offset = $this->get('offset')?$this->get('offset'):0;
		//
	}

	/* 
	* create new permission
	*/
	function index_post() {
		// get permission data from post method
		$perm = $this->post('models');

		//init permission model
		$permission = new Permission();
	}

	/*
	* update existing permission
	* param: role Id and name
	*/
	function index_put() {
		// get permission
		$perm = $this->put('models');

		//init permission model
		$permission = new Permission();
	}

	function index_delete() {
		// get permission
		$perm = $this->delete('models');
	}
}

/* End of file auth.php */
/* Location: ./application/controller/api/permissions.php */