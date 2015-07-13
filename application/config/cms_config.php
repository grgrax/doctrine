<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

const HOME_PAGE_PARTNER='partners';
const HOME_PAGE_COURSE='courses';
const HOME_PAGE_SLIDER='slider';

const NEWS_EVENTS='news-events';

const FOOTER_ADDRESS='address';
const FOOTER_LINKS='useful-links';


function is_default($slug){
	if(in_array($slug,
		array(
			HOME_PAGE_SLIDER,
			HOME_PAGE_PARTNER,
			HOME_PAGE_COURSE,
			FOOTER_ADDRESS,
			FOOTER_LINKS
			))) {
		return true;
}
else 
	return false;
}

function show_pre($arry = Null)
{
	if ($arry) {
		echo "<pre>";
		print_r($arry);
		echo "</pre>";
	}
}


// admin templating
function get_admin_template($key){
	$admin_templates=array(
		'nifty'=>array('path'=>'nifty/v2.2'),
		'metis'=>array('path'=>'metis'),
		);
	return (array)$admin_templates[$key];
}

$config['admin_template']='metis';
$config['admin_template']='nifty';


$config['site_name']="Our library";
$config['site_url']="http://ourlibrary.com";
$config['developer']="celosia designs";

function admin_template_asset_path(){
	$admin_template=get_admin_template(config_item('admin_template'));
	$path=base_url()."templates/admin/".$admin_template['path'];
	return $path;
}
// admin templating

function front_template_path(){
	$path="templates/front/";
	return base_url().$path;
}

function front_assets_path(){
	$path="templates/assets/";
	return base_url().$path;
}

function template_path($folder){
	$path="templates/$folder";
	return base_url().$path;
}




// for mailng
//old
// $config['smtp_host']  = 'smtp.gmail.com';
// $config['smtp_port']  = 465;
// $config['smtp_username'] = 'celosiadesigns4u@gmail.com';
// $config['smtp_password'] = 'setedeep';
// $config['smtp_type'] = 'ssl';

// $config['smtp_host']  = 'ssl://smtp.googlemail.com';
$config['smtp_host']  = 'smtp.gmail.com';
$config['smtp_port']  = 465;
$config['smtp_username'] = 'celosiadesigns4u@gmail.com';
$config['smtp_password'] = 'setedeep';
$config['smtp_type'] = 'ssl';

// $config['smtp_host']  = 'smtp.gmail.com';
// $config['smtp_port']  = 465;
// $config['smtp_username'] = 'asdf1soft@gmail.com';
// $config['smtp_password'] = 'nepal12345';
// $config['smtp_type'] = 'ssl';


//enable or disable some settings
$config['enabe_jq_validation'] = 1;
$config['enabe_jq_validation_backend'] = 0;
$config['enabe_profiler'] = 0;

//facebook signup and signin
$config['fb_key']='53edd6990376d7b5f512d2b5556613ca2567f04c';
$config['APPID']='415752498606532';
$config['SECRET']='056f3da72d450f80fe1b24f8e0b4efed';


// http://cprojects.me/ourlibrary/library/53edd6990376d7b5f512d2b5556613ca2567f04c
//get cms_config
//sud be last section of the file
function get_cms_config($key=null){
	$ci=& get_instance();
	try {
		if(!$key) return false;
		if(array_key_exists($key, $ci->config)){
			echo $ci->config[$key];
			return $ci->config->item($key);
		}
		else
			return false;
	} catch (Exception $e) {
		redirect();
	}
}

//deny user to add keyword defined as routes
function is_route($value){
	try {
		$CI =& get_instance();
		return array_key_exists($value,$CI->router->routes)?1:0;
	} catch (Exception $e) {
		$e->getMessage();
	}
}





/* End of file cms_config.php */
/* Location: ./application/config/cms_config.php */