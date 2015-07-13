<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class dashboard extends Admin_Controller {

	const MODULE='dashboard/';

	function __construct()
	{
		parent::__construct();
		$this->load->model('donation/donation_m');
		$this->load->model('campaign/campaign_m');
		$this->load->model('fund_category/fund_category_m');
		$this->load->model('user/user_m');
		$this->load->model('group/group_m');
	}

	public function index()
	{

		if($this->session->userdata('logged_in_user')){					
			
			$dash = new models\Entities\dashboard;
			// die(get_class($dash));
			// $this->doctrine->em->persist($dash);
			// show_pre($em);

			$this->load->helper(array('campaign/campaign','fund_category/fund_category','user/user','group/group','donation/donation','donor/donor'));			

			$param = array('c.id >'=>'0', 'c.created_at' => format(date('Y-m-d'),'Y-m-d'));
			$this->template_data['campaigns']=$this->campaign_m->filter_rows_by($param);
			
			$this->template_data['subview']=self::MODULE.'index';
			$this->load->view('admin/main_layout',$this->template_data);
		}
	}


}

/* End of file user.php */
/* Location: ./application/modules/user/controllers/user.php */