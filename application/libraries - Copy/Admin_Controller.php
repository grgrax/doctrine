<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin_Controller extends MX_Controller {

	public $template_data='';
	public $em=null;

	public function __construct()
	{
		parent::__construct();
		$this->em=$this->doctrine->em;
		
		if(ENVIRONMENT=='development' or $this->config->item('enabe_profiler')==1){
			$this->output->enable_profiler('config');
		}		

		$this->template_data='';

		// show_pre($this->session->all_userdata());
		// die;
		$logged_in_user=get_session('logged_in_user');
		// $logged_in_user=get_session('admin');
		
		// show_pre($logged_in_user);

		if(!$logged_in_user){
			redirect('auth/login');
		}
		else{
			$this->template_data['site_name']=config_item('site_name');
			$this->template_data['powered_by']=config_item('powered_by');
			$this->template_data['errors']='';
			$this->load->helper(array('form','text','my_text','my_date','my_table','my_dashboard','my_file','my_ui','user/user'));
			file_helper_init();
			$this->breadcrumb->append_crumb('Dashboard',base_url('dashboard').'');			
			// die("y");
			// refresh permission
			$group_permsissions=$this->load->model('group/group_permission_m')->read_row($logged_in_user['group_id']);
			$gps=array();
			foreach ($group_permsissions as $k=>$v) {
				$gps[]=$v['slug'];
			}
			unset($logged_in_user['group_permsissions']);
			$logged_in_user['group_permsissions']=$gps;
			$this->session->set_userdata('logged_in_user',$logged_in_user);
			// refresh permission
			
		}
	}	

	public function index()
	{
		echo "inside ".__FUNCTION__." of class:".get_class();
	}


}

/* End of file Admin_Controller.php */
/* Location: ./application/libraries/Admin_Controller.php */