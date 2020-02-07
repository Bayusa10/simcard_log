<?php
defined('BASEPATH') OR exit('No direct script access allowed');

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
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/


$route['main_page']					= 'UserPageController/index';
$route['master_data_page/(:any)']	= 'UserPageController/masterDataPage/$1';
$route['log_data_page']				= 'UserPageController/logDataPage';

/*Logout - Login route*/
$route['doLogin']					= 'main/doLogin';
$route['doLogout']					= 'main/doLogout';
/*Logout - Login route*/


/* Upload File Route */
$route['uploadFile']				= 'filehandler/uploadFile/$1';
/* Upload File Route */


/* User Transaction Route */
$route['addRegionBatch']			= 'UserTransactionController/addRegionalBatch';
$route['addRegion']					= 'UserTransactionController/addRegion';
$route['addCityBatch']				= 'UserTransactionController/addCityBatch';
$route['getListRegion']				= 'UserTransactionController/getListRegion';
$route['addCity']					= 'UserTransactionController/addCity';
$route['addSCardBatch']				= 'UserTransactionController/addSIMCardBatch';
$route['emptyLogSCard']				= 'UserTransactionController/cleanLogSCard';
$route['uploadLogData']				= 'UserTransactionController/insertLogSIMCard';
$route['exportExcel']				= 'UserTransactionController/exportExcel';
/* User Transaction Route */

$route['default_controller'] = 'main';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
