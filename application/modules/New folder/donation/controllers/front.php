<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class front extends Frontend_Controller {

	const MODULE='donation/';

	function __construct()
	{
		parent::__construct();
		$this->load->model('donation/donation_m');
	}

	function index($campaign_id=0,$offset=0)
	{
		$per_page=$this->data['per_page']=3;
		$param=array('campaign_id'=>$campaign_id);
		$total=$this->data['total']=count($this->donation_m->read_rows_by($param));
		$this->data['donations']=$this->donation_m->read_rows_by($param,$per_page,$offset);
		if($total>$per_page){
			$this->load->library('pagination');
			$config['base_url']=base_url().self::MODULE."front/index/$campaign_id";
			$config['total_rows']=$total;
			$config['per_page']=$per_page;

			$config['prev_link']='Previous';
			$config['next_link']='Next';
			$config['uri_segment'] =5;


			$config['display_pages'] = FALSE;
			$config['first_link'] = FALSE;
			$config['last_link'] = FALSE;
			
			$this->pagination->initialize($config);
			$this->data['pages']=$this->pagination->create_links();
		}
		$this->data['offset']=$offset;
		$view=self::MODULE.'index';
		$this->load->view($view,$this->data);
	}

}

/* End of file user.php */
/* Location: ./application/modules/user/controllers/user.php */