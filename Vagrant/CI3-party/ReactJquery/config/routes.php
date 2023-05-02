<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'home';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

// React
$route['admin'] = 'Admin/index';
$route['dashboard'] = 'Admin/dashboard';

// SmartyaACL route
$route['importdatabase'] = 'welcome/importdatabase';
$route['admin/login'] = 'AuthAdmin/index';
$route['Admins/login'] = 'AuthAdmin/index';
$route['admin/logout'] = 'AuthAdmin/logout';
$route['Admins/logout'] = 'AuthAdmin/logout';

// Users
$route['Admins/users/create'] = 'Admins/user_create';
$route['Admins/users/edit/(:num)'] = 'Admins/user_edit/$1';

//Roles
$route['Admins/roles/create'] = 'Admins/role_create';
$route['Admins/roles/edit/(:num)'] = 'Admins/role_edit/$1';
$route['Admins/roles/delete/(:num)'] = 'Admins/role_delete/$1';

// Modules
#$route['admin/modules'] = 'Admin/modules';
$route['Admins/modules/create'] = 'Admins/module_create';
$route['Admins/modules/edit/(:num)'] = 'Admins/module_edit/$1';
$route['Admins/modules/delete/(:num)'] = 'Admins/module_delete/$1';

//Admins
$route['Admins/managers/create'] = 'Admins/manager_create';
$route['Admins/managers/edit/(:num)'] = 'Admins/manager_edit/$1';
