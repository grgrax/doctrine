<?php


function get_bank_details($param){
	$ci=& get_instance();
	return $data=$ci->load->model('bank_details_m')->read_rows_by($param,1); 
}



?>
