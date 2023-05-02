// Customers Module

$route['customerListing'] = 'customers/customerListing';
$route['customerListing/(:num)'] = "customers/CustomerListing/$1";
$route['addNewCustomer'] = "customers/addNewCustomer";
$route['modifyCustomer'] = "customers/modifyCustomer";
$route['viewCustomer/(:num)'] = "customers/viewCustomer/$1";
$route['modifyCustomer/(:num)'] = "customers/modifyCustomer/$1";
$route['editCustomer'] = "customers/editCustomer";
$route['deleteCustomer'] = "customers/deleteCustomer";
$route['addNewCust'] = "customers/addNewCust";

// User Module
$route['userListing'] = 'user/userListing';
$route['userListing/(:num)'] = "user/userListing/$1";