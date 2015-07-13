<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function get_donations($param){
	$ci=& get_instance();
	return $data=$ci->load->model('donation/donation_m')->read_rows_by($param); 
}

function get_donation_min_max_date($param){
	$ci=& get_instance();
	return $data=$ci->load->model('donation/donation_m')->get_max_min_date($param); 
}
