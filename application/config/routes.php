<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
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
$route['default_controller'] = 'user/index';
$route['404_override'] = '';

/*admin*/
$route['create_member'] = 'user/create_member';
$route['login'] = 'user/index';
$route['logout'] = 'user/logout';
$route['login/validate_credentials'] = 'user/validate_credentials';

$route['products'] = 'products/index';
$route['products/add'] = 'products/add';
$route['products/update'] = 'products/update';
$route['products/update/(:any)'] = 'products/update/$1';
$route['products/delete/(:any)'] = 'products/delete/$1';
$route['products/(:any)'] = 'products/index/$1'; //$1 = page number

$route['manufacturers'] = 'manufacturers/index';
$route['manufacturers/add'] = 'manufacturers/add';
$route['manufacturers/update'] = 'manufacturers/update';
$route['manufacturers/update/(:any)'] = 'manufacturers/update/$1';
$route['manufacturers/delete/(:any)'] = 'manufacturers/delete/$1';
$route['manufacturers/(:any)'] = 'manufacturers/index/$1'; //$1 = page number



/* End of file routes.php */
/* Location: ./application/config/routes.php */
