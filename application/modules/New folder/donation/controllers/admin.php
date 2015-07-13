<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class admin extends Admin_Controller {

	public $template_data;
	const MODULE='donation/admin/';

	function __construct()
	{
		parent::__construct();
		if(!permission_permit(['administrator-donation'])) redirect_to_dashboard();		
		$this->template_data['link']=base_url().self::MODULE;
		$this->load->model('donation_m');
		$this->load->model('campaign/campaign_m');
		$this->load->model('fund_category/fund_category_m');
		$this->load->helper(array('fund_category/fund_category','campaign/campaign','user/user','donor/donor','donation'));
	}

	function index($offset=0)
	{
		try {

			$per_page=25;
			$this->template_data['q_param']=array('id >'=>'0');					
			
			$param = '';
			if($this->input->get()){				
				unset($this->template_data['q_param']['id >']);								
				$filters = array();				
				// show_pre($this->input->get());				
				foreach($this->input->get() as $k=>$v){
					if($k == 'per_page' or $k == 'filter'){
					}
					elseif ($v !='' ){
						$filters[$k]=$v;
						$param .=  $k.'='.$v.'&'; 						
					} 
				}				
				$offset = $this->input->get('per_page');
				$param = substr($param,0,-1);
				$this->template_data['q_param']=$filters;
				// show_pre($this->template_data['q_param']);	
				


				$join_columns=array('user_id','fund_category_id');
				foreach ($filters as $key => $value) {
					if(in_array($key, $join_columns)){
						$this->template_data['q_param']['join'][$key]=$value;
					}else{
						$this->template_data['q_param'][$key]=$value;						
					}
				}				
				//amcount filter
				if(isset($filters['amount_option'])){
					switch ($filters['amount_option']) {
						case 1:{
							if(isset($filters['amount_equal_to'])){
								$this->template_data['q_param']['amount']['=']=$filters['amount_equal_to'];							
							}
							$this->unset_amount_filter();
							break;
						}
						case 2:{
							if(isset($filters['amount_above']) && $filters['amount_above'])
								$this->template_data['q_param']['amount']['>']=$filters['amount_above'];
							$this->unset_amount_filter();
							break;
						}
						case 3:{
							if(isset($filters['amount_below']) && $filters['amount_below'])
								$this->template_data['q_param']['amount']['<']=$filters['amount_below'];
							$this->unset_amount_filter();
							break;
						}
						case 4:{
							if(isset($filters['amount_start_from']) and isset($filters['amount_end_at'])){
								$this->template_data['q_param']['amount']['>=']=$filters['amount_start_from'];
								$this->template_data['q_param']['amount']['<=']=$filters['amount_end_at'];
							}
							$this->unset_amount_filter();							
							break;
						}
					}
					unset($this->template_data['q_param']['amount_option']);					
				}
				// show_pre($this->template_data['q_param']);	
			}
			//filter		

			$total_rows=count($this->donation_m->read_rows_by($this->template_data['q_param']));
			$this->template_data['donations']=$this->donation_m->read_rows_by($this->template_data['q_param'],$per_page,$offset);

			if($total_rows>$per_page){
				$this->load->library('pagination');
				// $config['base_url']=base_url().self::MODULE."index";
				$config['base_url']=base_url().self::MODULE."index?$param";
				$config['total_rows']=$total_rows;
				$config['per_page']=$per_page;
				$config['prev']='Previous';
				$config['next']='Next';
				$config['page_query_string']=TRUE;
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

	function unset_amount_filter(){
		unset($this->template_data['q_param']['amount_equal_to']);
		unset($this->template_data['q_param']['amount_above']);
		unset($this->template_data['q_param']['amount_below']);
		unset($this->template_data['q_param']['amount_start_from']);
		unset($this->template_data['q_param']['amount_end_at']);
	}

}

/* End of file sample.php */
/* Location: ./application/modules/sample/controllers/sample.php */