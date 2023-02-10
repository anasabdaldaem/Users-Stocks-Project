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
$route['default_controller'] = 'Login';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['main'] = 'main/index';
$route['main/admin'] = 'admin/index';
$route['main/customer'] = 'customer/index';
$route['main/customer/customerbalance'] = 'customer/customerbalance';
$route['get_balances'] = 'customer/get_balances';
$route['get_userbalance/(:any)/(:any)'] = 'admin/get_userbalance/$1/$2';
$route['get_customerbalance'] = 'customer/get_customerbalance';

$route['login']='login/index';
$route['login/login_submit']='login/login_submit_fun';
$route['register']='register/index';
$route['register/reg_submit']='register/reg_submit_fun';
$route['settings']='users/user_settings';
$route['users/update']='users/update';
$route['main/admin/users'] = "users/index";
$route['main/admin/users/new'] = "users/new";
$route['main/admin/users/create'] = "users/create";
$route['main/admin/users/edit/(:any)'] = "users/edit/$1";
$route['main/admin/users/store/(:any)'] = "users/store/$1";
$route['main/admin/users/delete/(:any)'] = "users/delete/$1";
$route['get_users'] = "users/get_users";

$route['main/admin/stocks'] = "stocks/index";
$route['main/admin/stocks/new'] = "stocks/new";
$route['main/admin/stocks/create'] = "stocks/create";
$route['main/admin/stocks/edit/(:any)'] = "stocks/edit/$1";
$route['main/admin/stocks/store/(:any)'] = "stocks/store/$1";
$route['main/admin/stocks/delete/(:any)'] = "stocks/delete/$1";
$route['get_stocks'] = "stocks/get_stocks";

$route['main/admin/currencies'] = "currencies/index";
$route['main/admin/currencies/new'] = "currencies/new";
$route['main/admin/currencies/create'] = "currencies/create";
$route['main/admin/currencies/edit/(:any)'] = "currencies/edit/$1";
$route['main/admin/currencies/store/(:any)'] = "currencies/store/$1";
$route['main/admin/currencies/delete/(:any)'] = "currencies/delete/$1";
$route['get_currencies'] = "currencies/get_currencies";

$route['main/admin/usrstocks'] = "usrstocks/index";
$route['main/admin/usrstocks/new'] = "usrstocks/new";
$route['main/admin/usrstocks/create'] = "usrstocks/create";
$route['main/admin/usrstocks/edit/(:any)'] = "usrstocks/edit/$1";
$route['main/admin/usrstocks/store/(:any)'] = "usrstocks/store/$1";
$route['main/admin/usrstocks/delete/(:any)'] = "usrstocks/delete/$1";
$route['get_usrstocks'] = "usrstocks/get_usrstocks";

$route['main/admin/stkprices'] = "stkprices/index";
$route['main/admin/stkprices/new'] = "stkprices/new";
$route['main/admin/stkprices/create'] = "stkprices/create";
$route['main/admin/stkprices/edit/(:any)'] = "stkprices/edit/$1";
$route['main/admin/stkprices/store/(:any)'] = "stkprices/store/$1";
$route['main/admin/stkprices/delete/(:any)'] = "stkprices/delete/$1";
$route['get_stkprices'] = "stkprices/get_stkprices";


$route['admin/balances/delete/(:any)'] = "admin/balance_delete/$1";
$route['admin/stockprice/delete/(:any)'] = "admin/stockprice_delete/$1";
$route['admin/settings'] = "admin/settings";


$route['main/admin/userbalance'] = "admin/userbalance";
$route['main/admin/newsell'] = "admin/newsell";
$route['main/admin/createsell'] = "admin/createsell";
$route['main/customer/newsell'] = "customer/newsell";
$route['main/customer/createsell'] = "customer/createsell";
$route['admin/stockprice/new'] = "admin/create_stockprice";
$route['main/admin/profits'] = "admin/profits";
$route['get_userprofit/(:any)/(:any)'] = "admin/get_userprofit/$1/$2";


