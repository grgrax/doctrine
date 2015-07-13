<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function get_settings($param){
	$ci=& get_instance();
	return $data=$ci->load->model('setting/setting_m')->read_rows_by($param); 
}



/* End of file user_helper.php */
