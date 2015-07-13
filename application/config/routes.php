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

$route['default_controller'] = "frontend";
$route['404_override'] = '';

//predefined admin routes
$predined_admin_routes=array('dashboard','auth','donation','fund_category','campaign','user','group','permission','setting','prfile','article','student','product','customer');
foreach ($predined_admin_routes as $admin_route) {
	$route[$admin_route] = $admin_route;
	$route["$admin_route/(:any)"] = "$admin_route/$1";
}


//predefined donee routes
$predined_donee_routes=array('donee');
foreach ($predined_donee_routes as $donee_route) {
	$route[$donee_route] = $donee_route;
	$route["$donee_route/(:any)"] = "$donee_route/$1";
}

// //predefined search routes
// $predined_donee_routes=array('search');
// foreach ($predined_donee_routes as $search_route) {
// 	// $route[$search_route] = $search_route;
// 	$route['(search)'] = 'frontend/search';
// }


//predefined frontend routes
$predined_frontend_routes=array('campaign_acc_cat','signup','signin','test','frontend','search');
foreach ($predined_frontend_routes as $frontend_route) {
	if($frontend_route=='campaign_acc_cat'){
		$route[$frontend_route] = 'frontend/'.$frontend_route;
		$route["$frontend_route/(:any)"] = 'frontend/'."$frontend_route/$1";		
	}elseif($frontend_route=='search'){
		$route[$frontend_route] = 'frontend/search';
	}else{
		$route[$frontend_route] = $frontend_route;
		$route["$frontend_route/(:any)"] = "$frontend_route/$1";		
	}
}

// echo "<pre>";
// print_r($route);

//frontend dynamic routes for campiang url
$route['(:any)'] = 'frontend/$1';




/* End of file routes.php */
/* Location: ./application/config/routes.php */