<?php
defined('BASEPATH') || exit('No direct script access allowed');

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
|   example.com/class/method/id/
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
|   $route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|   $route['404_override'] = 'errors/page_missing';
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

$route['default_controller'] = 'home';
$route['404_override'] = '';
$route['translate_uri_dashes'] = false;

// Authentication
Route::any(LOGIN_URL, 'users/login', array('as' => 'login'));
Route::any(REGISTER_URL, 'users/register', array('as' => 'register'));
Route::block('users/login');
Route::block('users/register');

Route::any('logout', 'users/logout');
Route::any('forgot_password', 'users/forgot_password');
Route::any('reset_password/(:any)/(:any)', 'users/reset_password/$1/$2');

// Activation
Route::any('activate', 'users/activate');
Route::any('activate/(:any)', 'users/activate/$1');
Route::any('resend_activation', 'users/resend_activation');

Route::prefix(SITE_AREA, function(){
	Route::context('dashboard');
    Route::context('content', array('home' => SITE_AREA .'/content/index'));
    Route::context('financial');
    Route::context('reports', array('home' => SITE_AREA .'/reports/index'));
    Route::context('developer');
    Route::context('settings');
    Route::context('help');
});

$route = Route::map($route);
$route['aboutus.php']			= 'common/about';
$route['register.php']			= 'common/register';
$route['login.php']				= 'common/login';
$route['contactus.php']			= 'common/contact';
$route['pages/(:any)']			= 'pages/detail/$1';
$route['contact']				= 'pages/contact';
$route['contactQuery']			= 'pages/contact_query';
$route['categories']			= 'listings/categories';
$route['locations']				= 'listings/locations';
$route['location/(:any)']		= 'listings/location/$1';
$route['category/(:any)']		= 'listings/category/$1';
$route['search/(:any)/(:any)']  = 'listings/search/$1/$2';
$route['detail/(:any)']			= 'listings/detail/$1';
$route['businessQuery']			= 'listings/business_query';
$route['clickToCall']			= 'listings/clickToCall';
$route['sendSMS']				= 'listings/sendSMS';
$route['sendEmail']				= 'listings/sendEmail';
$route['review']				= 'listings/review';
$route['claim']					= 'listings/claim_report';
$route['starRating']			= 'listings/star_rating';
$route['securimage']			= 'listings/securimage';
$route['createPDF/(:any)']		= 'listings/create_pdf/$1';
$route['loadSubCategories']		= 'listings/loadSubCategories';
$route['loadCities']			= 'listings/loadCities';
