<?php
class admin extends Admin_Controller
{
	const MODULE='campaign/admin/';

	function __construct()
	{
		try {
			parent::__construct();
			if(!permission_permit(['administrator-campaign'])) redirect_to_dashboard();


			$this->load->model('fund_category/fund_category_m');
			$this->load->model('user/user_m');

			$this->load->helper(array('campaign','user/user','fund_category/fund_category'));
			$this->template_data['campaign_m']=$this->load->model('campaign_m');
			$this->template_data['actions']=campaign_m::actions();
			$this->template_data['status']=campaign_m::status();
			$this->template_data['link']=base_url().self::MODULE;
			$this->breadcrumb->append_crumb('List Campaigns',base_url().self::MODULE.'index');			
		} catch (Exception $e) {
			$this->session->set_flashdata('error', 'Error '.$e->getMessage());
			redirect();
		}
	}


	function index($offset=0)
	{
		try {
			if(!permission_permit(['list-campaign'])) redirect_to_dashboard();
			$per_page=5;

			$this->template_data['q_param']=array('c.id >'=>'0');					
			

			//filter
			$param = '';
			if($this->input->get()){				
				unset($this->template_data['q_param']['id >']);								
				$filters = array();				
				foreach($this->input->get() as $k=>$v){
					if($k == 'per_page' or $k == 'filter'){
					}
					elseif ($v !='' ){
						$filters[$k]=$v;
						$param .=  $k.'='.$v.'&'; 						
					} 
				}				
				$offset = $this->input->get('per_page')?$this->input->get('per_page'):0;
				$param = substr($param,0,-1);
				$this->template_data['q_param']=$filters;
				// show_pre($this->template_data['q_param']);

				//amcount filter
				if(isset($filters['amount_option'])){
					switch ($filters['amount_option']) {
						case 1:{
							if(isset($filters['amount_equal_to']) and $filters['amount_equal_to']){
								$this->template_data['q_param']['target_amount']['=']=$filters['amount_equal_to'];							
							}
							$this->unset_amount_filter();							
							break;
						}
						case 2:{
							if(isset($filters['amount_above']) and  $filters['amount_above']!='')
								$this->template_data['q_param']['target_amount']['>']=$filters['amount_above'];
							$this->unset_amount_filter();							
							break;
						}
						case 3:{
							if(isset($filters['amount_below']) and $filters['amount_below']!='')
								$this->template_data['q_param']['target_amount']['<']=$filters['amount_below'];
							$this->unset_amount_filter();							
							break;
						}
						case 4:{
							if(isset($filters['amount_start_from']) and isset($filters['amount_end_at'])
								and $filters['amount_start_from']!='' and $filters['amount_end_at']!=''
								){
								$this->template_data['q_param']['target_amount'][">="]=$filters['amount_start_from'];
							$this->template_data['q_param']['target_amount']["<="]=$filters['amount_end_at'];
						}
						$this->unset_amount_filter();							
						break;
					}
				}
				unset($this->template_data['q_param']['amount_option']);					
			}
			$this->unset_amount_filter();							
			// show_pre($this->template_data['q_param']);	
		}
		//filter		

		$total=count($this->campaign_m->filter_rows_by($this->template_data['q_param']));
		$this->template_data['rows']=$this->campaign_m->filter_rows_by($this->template_data['q_param'],$per_page,$offset);

		if($total>$per_page){
			$this->load->library('pagination');
			$config['base_url']=base_url().self::MODULE."index?".$param;
			$config['total_rows']=$total;
			$config['per_page']=$per_page;
			$config['prev']='Previous';
			$config['next']='Next';
			// $config['uri_segment'] = 4;
			$config['page_query_string']=TRUE;
			$this->pagination->initialize($config);
			$this->template_data['pages']=$this->pagination->create_links();
		}
		$this->template_data['total']=$total;
		$this->template_data['offset']=$offset;
		$this->template_data['subview']=self::MODULE.'index';
		$this->load->view('admin/main_layout',$this->template_data);
		$this->session->set_userdata('tab','tab-1');
	} catch (Exception $e) {
		$this->session->set_flashdata('error', 'Couldnt list fund categories '.$e->getMessage());
		$this->controller_redirect();
	}
}

function add()
{
	try {
		
		$rules=$this->campaign_m->get_rules();

		if(!permission_permit(array('list-campaign','add-campaign'))) throw new Exception("Permissioin Denied", 1);
		if($this->input->post())
		{

			$rules=$this->campaign_m->get_rules();
			foreach ($rules as $k=>$rule) {
				if($rule['field']=='url_link')
					unset($rules[$k]);
			}
			$this->template_data['insert_data']=array(
				'campaign_title'=>$this->input->post('campaign_title'),
				'slug'=>get_slug($this->input->post('campaign_title')),
				'description'=>$this->input->post('description'),
				'fund_category_id'=>$this->input->post('categories'),
				'user_id'=>$this->input->post('donee'),
				'target_amount'=>$this->input->post('target_amount'),
				'starting_at'=>date('Y-m-d',strtotime($this->input->post('starting_at'))),
				'ending_at'=>date('Y-m-d',strtotime($this->input->post('ending_at'))),
				'url_link'=>"/".get_slug($this->input->post('url_link')),
				'created_at'=>date('Y-m-d H:i:s'),
				'status'=>campaign_m::PENDING,
				);
			$this->form_validation->set_rules($rules);
			if($this->form_validation->run($this)===TRUE)
			{
				if($_FILES && $_FILES['photos']['name'][0]!=''){
					$response=campaign_photos_upload();
					if(!$response['success']) throw new Exception($response['error'], 1);
					$this->template_data['insert_data']['pic']=$response['data'];						
				}
					// show_pre($this->template_data['insert_data']);
				$this->campaign_m->create_row($this->template_data['insert_data']);
				$this->session->set_flashdata('success', 'Campaign added successfully');
				redirect('campaign/admin');
			}
		} 
		$this->breadcrumb->append_crumb('Add','add');
		$this->template_data['subview']=self::MODULE.'add';
		$this->load->view('admin/main_layout',$this->template_data);

	}catch (Exception $e) {
		$this->session->set_flashdata('error', 'Couldnt add campaign, '.$e->getMessage());
		redirect('campaign/admin');
	}
}

function edit($slug=FALSE)
{
	try {
		if(!permission_permit(array('list-campaign','edit-campaign'))) $this->controller_redirect('Permissioin Denied');
		if(!$slug) throw new Exception("Error Processing Request", 1);
		$response=$this->get_data(array('slug'=>$slug));
		if(!$response['success']) throw new Exception($response['data'], 1);
		$this->template_data['row']=$response['data'];
		$id=$response['data']['id'];

		if($this->input->post())
		{
			$rules=null;
			if($this->input->post('add_content')){
				$rules=$this->campaign_m->get_rules(array('categories','description','donee'));
				$name_rule=array(
					'field'=>'campaign_title',
					'label'=>'Campaign Title',
					'rules'=>"trim|required|route|xss_clean|is_campaign_title_unique[$id]",
					);
				array_push($rules,$name_rule);
				$this->template_data['update_data']=array(
					'campaign_title'=>$this->input->post('campaign_title'),
					'description'=>$this->input->post('description'),
					'fund_category_id'=>$this->input->post('categories'),
					'user_id'=>$this->input->post('donee'),
					'updated_at'=>date('Y-m-d H:i:s'),
					);
				$tab='tab-1';
				$this->session->set_userdata('tab',$tab);
			}
			else if($this->input->post('add_amount')){
				$rules=$this->campaign_m->get_rules(array('target_amount','starting_at','ending_at'));
				$this->template_data['update_data']=array(
					'target_amount'=>$this->input->post('target_amount'),
					'starting_at'=>date('Y-m-d',strtotime($this->input->post('starting_at'))),
					'ending_at'=>date('Y-m-d',strtotime($this->input->post('ending_at'))),
					'updated_at'=>date('Y-m-d H:i:s'),
					);
				$tab='tab-2';
				$this->session->set_userdata('tab',$tab);
			}
			else if($this->input->post('add_photos')){
				if($_FILES && $_FILES['photos']['name'][0]!=''){
					$response=campaign_photos_upload($this->template_data['row']);
					if(!$response['success']) throw new Exception($response['error'], 1);
					$this->template_data['update_data']['pic']=$response['data'];						
				}
				else
					$this->template_data['update_data']['pic']=$this->template_data['row']['pic'];
				$tab='tab-3';
				$this->session->set_userdata('tab',$tab);
				$this->campaign_m->update_row($id,$this->template_data['update_data']);
				$this->session->set_flashdata('success', 'Campaign updated successfully');
				redirect(current_url());
			}
			else if($this->input->post('add_links')){
				$rules=$this->campaign_m->get_rules(array(''));
				$url_rule=array(
					'field'=>'url_link',
					'label'=>'URL Link',
					'rules'=>"trim|xss_clean|is_campaign_url_unique[$id]",
					);
				array_push($rules,$url_rule);
				$this->template_data['update_data']=array(
					'url_link'=>"/".get_slug($this->input->post('url_link')),
					'updated_at'=>date('Y-m-d H:i:s'),
					);
				$tab='tab-4';
				$this->session->set_userdata('tab',$tab);
			}
				// show_pre($rules);
				// die;
			$this->form_validation->set_rules($rules);
			if($this->form_validation->run($this)===TRUE)
			{
				$this->campaign_m->update_row($id,$this->template_data['update_data']);
				$this->session->set_flashdata('success', 'Campaign updated successfully');
				show_pre($this->template_data['update_data']);
				redirect(current_url());
			}
		}	
		$this->breadcrumb->append_crumb('Edit','edit');
		$this->template_data['subview']=self::MODULE.'edit';
		$this->load->view('admin/main_layout',$this->template_data);
	} catch (Exception $e) {
		$this->session->set_flashdata('error', 'Couldnt edit campaign, '.$e->getMessage());
		redirect('campaign/admin');
	}
}

function publish($slug=NULL){
	try{
		if(!permission_permit(array('list-campaign','activate-campaign'))) $this->controller_redirect('Permissioin Denied');
		if(!$slug) throw new Exception('Invalid paramter');
		$response=$this->get_data(array('slug'=>$slug));
		if(!$response['success']) throw new Exception($response['data'], 1);
		$this->template_data=array('status'=>campaign_m::ACTIVE);
		$this->campaign_m->update_row($response['data']['id'],$this->template_data);
		$this->session->set_flashdata('success', 'Campaign published successfully');
	}
	catch(Exception $e){
		$this->session->set_flashdata('error', 'Campaign not published '.$e->getMessage());
	}
	$this->controller_redirect();				
}


function unpublish($slug=NULL){
	try{
		if(!permission_permit(array('list-campaign','block-campaign'))) $this->controller_redirect('Permissioin Denied');

		$response=$this->get_data(array('slug'=>$slug));
		if(!$response['success']) throw new Exception($response['data'], 1);
		$this->template_data=array('status'=>campaign_m::BLOCKED);
		$this->campaign_m->update_row($response['data']['id'],$this->template_data);
		$this->session->set_flashdata('success', 'Campaign blocked successfully');
	}
	catch(Exception $e){
		$this->session->set_flashdata('error', 'Campaign not blocked '.$e->getMessage());
	}
	$this->controller_redirect();				
}

function delete($slug=NULL){
	try{

		if(!permission_permit(array('list-campaign','delete-campaign'))) $this->controller_redirect('Permissioin Denied');
		if(!$slug) throw new Exception('Invalid paramter');
		$response=$this->get_data(array('slug'=>$slug));
		if(!$response['success']) throw new Exception($response['data'], 1);
		$this->template_data=array('status'=>campaign_m::DELETED);
		$this->campaign_m->update_row($response['data']['id'],$this->template_data);
		$this->session->set_flashdata('success', 'Campaign deleted successfully');
	}
	catch(Exception $e){
		$this->session->set_flashdata('error', 'Campaign not deleted '.$e->getMessage());
	}
	$this->controller_redirect();				
}

public function remove_picture($slug,$pic=null){
	try {
		if(!$slug || !$pic) throw new Exception("Error Processing Request", 1);

		$response=$this->get_data(array('slug'=>$slug));
		if(!$response['success']) throw new Exception($response['data'], 1);			
		$id=$response['data']['id'];

		$remove_picture_response=campaign_photo_remove($response['data']['id'],$pic);

		if(!$remove_picture_response['success']) throw new Exception($remove_picture_response['error'], 1);			
		$this->template_data['update_data']['pic']=$remove_picture_response['data'];

		$this->session->set_flashdata('success','Category updated, picture has been removed successfully.');
		$this->campaign_m->update_row($id,$this->template_data['update_data']);

	} catch (Exception $e) {
		$this->session->set_flashdata('error', 'Couldnt remove picture '.$e->getMessage());
		echo $e->getMessage();
	}

	$this->session->set_userdata('tab','tab-3');
	redirect("campaign/admin/edit/$slug");
}


function controller_redirect($msg=false){
	if($msg) $this->session->set_flashdata('error', $msg);
	$this->template_data['link']=base_url().self::MODULE;
	redirect($this->template_data['link']);				
}

function get_data($param){
	$response['success']=false;
	$response['data']='Error Processing Request';
	if(!$param) return $response;
	$row=$this->campaign_m->read_rows_by($param,1);
	if($row) {
		$response['success']=true;
		$response['data']=$row;
	}
	else{
		$response['data']='data not found';
	}
	return $response;
}

function unset_amount_filter(){
	unset($this->template_data['q_param']['amount_equal_to']);
	unset($this->template_data['q_param']['amount_above']);
	unset($this->template_data['q_param']['amount_below']);
	unset($this->template_data['q_param']['amount_start_from']);
	unset($this->template_data['q_param']['amount_end_at']);
}


}
?>