<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class frontend extends Frontend_Controller {

	public $data;
	const MODULE='frontend/';

	function __construct()
	{
		parent::__construct();


		// $this->load->library(array('form_validation','session','breadcrumb'));
		$this->data['link']=base_url().self::MODULE;

		$this->load->model(array('campaign/campaign_m','user/user_m'));
		$this->load->model('donation/donation_m');
		$this->load->model('fund_category/fund_category_m');

		$this->load->helper(array('fund_category/fund_category'));
		// $this->load->model('signup/signup_m');
		$this->data['all_campaign'] = $this->campaign_m->filter_rows_by(array('c.status '=>campaign_m::ACTIVE),3);


		// show_pre($this->data['all_campaign']); 
		// $this->data['all_campaign'] = $this->campaign_m->read_all_campaign('3');
		$this->data['donations'] = $this->donation_m->popular_campaign();
		$this->data['fund_categories'] = $this->fund_category_m->read_all(25);
	}

	public function index($url=null)
	{
		// die('index with url');
		if($url){
			if($url!='signup'){
				// $this->data['campaign']=$this->campaign_m->read_row_by(array('key' => 'url_link', 'value' => $url));
				$this->data['campaign']=$this->campaign_m->read_row_by(array('key' => 'url_link', 'value' => "/".$url));
				if(!$this->data['campaign']){
					$this->data['campaign']=$this->campaign_m->read_row_by(array('key' => 'slug', 'value' => $url));
				}
				if(!$this->data['campaign']) {
					redirect('frontend/not_found');
				}
				// show_pre($this->data['campaign']);
				if($this->data['campaign'][0]['status']!=campaign_m::ACTIVE) {
					redirect('frontend/not_found');
				}
				$this->data['donations'] = $this->donation_m->read_all_by(array('key' => 'campaign_id', 'value' => $this->data['campaign']['0']['id']));

				// show_pre($this->data['donations']);
				$this->data['subview']='campaign/public/single';			
			}
		}
		else{
			$this->data['subview']=self::MODULE.'list';			
		}
		$this->load->view('front/main_layout',$this->data);		
	}

	public function campaign_acc_cat() {
		//echo $cat;
		$slug = $this->uri->segment(2);
		$fund_category = $this->load->model('fund_category/fund_category_m')->read_rows_by(array('slug'=>$slug));
		$this->data['category_name'] = $fund_category[0]['name']; 
		
		$rows=$this->campaign_m->fetch_rows(array('fund_category_id' => $fund_category[0]['id']),'','0','6');

		foreach ($rows as $campaign) {
			if($campaign['status']!=campaign_m::ACTIVE) continue;
			$campaigns[]=$campaign;
		}

		$this->data['campaigns']=$campaigns;

		$this->data['subview']='campaign/public/campaign-acc-category';	
		$this->load->view('front/main_layout',$this->data);	
		// show_pre($this->data['campaign']);
	}

	public function search() {
		$param['c.campaign_title like']=$this->input->post('campaign_title')."%";

		if($this->input->post()){
			// echo "not impt";
			$this->data['search_campaigns']=$this->campaign_m->filter_rows_by($param);
			// show_pre($this->data['campaigns']);
		// 'campaign_title'=>$this->input->post('campaign_title');
		}else echo 'hunger stomach but not hunger mind';
		$this->data['subview']=self::MODULE.'search_result';
		// die('die');
		$this->load->view('front/main_layout',$this->data);		

	}
	public function not_found(){
		$this->data['subview']='front/templates/404';
		$this->load->view('front/main_layout',$this->data);		
	}
}

/* End of file sample.php */
/* Location: ./application/modules/sample/controllers/sample.php */