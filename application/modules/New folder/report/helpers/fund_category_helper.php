<?php

function get_fund_category_($id){
	$ci=& get_instance();
	try {
		return $ci->load->model('fund_category/fund_category_m')->read_row($id);
	} catch (Exception $e) {
		redirect();
	}
}


?>