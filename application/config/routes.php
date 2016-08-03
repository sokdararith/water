<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(dirname(dirname(__FILE__)).'/libraries/pigeon.php');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

$route['default_controller'] 	= "home";
$route['404_override'] 			= '';
Pigeon::map(function($r){
	$r->get('test', 'map/getAll');

	// contact section
	$r->get('contacts', 'api/contacts/index');
	$r->get('contacts/(:num)', 'api/contacts/getById/$1');
	$r->post('contacts/(:num)', 'api/contacts/index/$1');
	$r->put('contacts/(:num)', 'api/contacts/index/$1');
	$r->delete('contacts/(:num)', 'api/contacts/index/$1');
	$r->get('contacts/(:num)/invoices', 'api/contacts/getAllInvoicesByContactId/$1');
	$r->get('contacts/(:num)/bills', 'api/contacts/getAllBillsByContactId/$1');
	$r->get('contacts/(:num)/activities', 'api/contacts/getAllActivitiesByContactId/$1');
	$r->get('contacts/types', 'api/contacts/types');
});

// $route = Pigeon::draw();
/* End of file routes.php */
/* Location: ./application/config/routes.php */