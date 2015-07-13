<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class admin extends Admin_Controller {

	public $template_data;
	const MODULE='donation/admin/';

	function __construct()
	{
		parent::__construct();
		$this->template_data['link']=base_url().self::MODULE;
		$this->load->model('user/user_m');
		$this->load->model('campaign/campaign_m');
		$this->load->model('fund_category/fund_category_m');
		$this->load->helper(array('fund_category/fund_category','campaign/campaign','user/user','donor/donor','donation/donation'));
	}

	function index($offset=0)
	{
		try {
			//if(!permission_permit(['list-donation'])) redirect_to_dashboard();
			
			$per_page=20;
			$total_rows=count($this->user_m->read_rows_by(array('id >'=>'0')));
			$this->template_data['donations']=$this->user_m->read_rows_by(
				array('id >'=>'0'),
				$per_page,
				$offset
				);			
			if($total_rows>$per_page){
				$this->load->library('pagination');
				$config['base_url']=base_url().self::MODULE."index";
				$config['total_rows']=$total_rows;
				$config['per_page']=$per_page;
				$config['prev']='Previous';
				$config['next']='Next';
				$this->pagination->initialize($config);
				$this->template_data['pages']=$this->pagination->create_links();
			}
			$this->template_data['total']=$total_rows;
			$this->template_data['offset']=$offset;
			$this->template_data['subview']=self::MODULE.'index';
			$this->load->view('admin/main_layout',$this->template_data);
			$this->session->set_userdata('tab','tab-1');
		} catch (Exception $e) {
			$this->session->set_flashdata('error', 'Couldnt list donation, '.$e->getMessage());
			$this->controller_redirect();
		}
	}


	function controller_redirect($msg=false){
		if($msg) $this->session->set_flashdata('error', $msg);
		$this->data['link']=base_url().self::MODULE;
		redirect($this->data['link']);				
	}


}

/* End of file sample.php */
/* Location: ./application/modules/sample/controllers/sample.php */