<?php

function get_donee($param){
	try {
		$ci=& get_instance();
		return $ci->load->model('user/user_m')->read_row_by_n($param);
	} catch (Exception $e) {
		echo $e->getMessage();
	}	
}

function is_facebook_user(){
	try {
		$ci=& get_instance();
		$id=$ci->session->userdata('donee_id');
		$donee=$ci->load->model('user/user_m')->read_row_by_n(array('id'=>$id));
		$fb_group=get_group(array('slug'=>group_m::FACEBOOK_USER));
		// echo $donee['group_id']."==".$fb_group['id'];
		if($donee['group_id']==$fb_group['id'])
			return true;
	} catch (Exception $e) {
		echo $e->getMessage();
	}
	return false;
}