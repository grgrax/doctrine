<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function get_donors($param){
	$ci=& get_instance();
	return $data=$ci->load->model('donor/donor_m')->read_rows_by($param); 
}


function get_donor($param){
	$ci=& get_instance();
	return $data=$ci->load->model('donor/donor_m')->read_row_by($param); 	
}