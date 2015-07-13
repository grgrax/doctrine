<?php


function site_name(){
	return get_site_option(array('slug'=>'site_name'));
}

function get_site_url(){
	return get_site_option(array('slug'=>'site_url'));
}

function get_site_option($param){
	$ci=& get_instance();
	$data=$ci->load->model('setting/setting_m')->read_rows_by($param); 
	return $data?$data['value']:'';
}

?>