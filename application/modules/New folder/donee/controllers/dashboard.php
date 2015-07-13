<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class dashboard extends Frontend_Controller {

	public $data;
	const MODULE='donee/';

	
	function __construct()
	{
		try {
			parent::__construct();

			$donee_id=$this->session->userdata('donee_id');
			if(!$donee_id) throw new Exception("no donee_id", 1);				
			$this->data['link']=base_url().self::MODULE;

			$this->data['donee_id']=$this->session->userdata('donee_id'); 
			if(!$this->data['donee_id']) throw new Exception("Error Processing Request", 1);			
			
			$this->load->model(array('signup_m','user/user_m','campaign/campaign_m','fund_category/fund_category_m','donation/donation_m','signup/bank_details_m','group/group_m'));

			$this->data['donee']=$this->signup_m->read_row($this->data['donee_id']);
			$this->data['categories']=$this->fund_category_m->read_all_published();	
			
			$this->load->helper(array('donee','group/group','campaign/campaign','fund_category/fund_category','donor/donor','signup/signup'));

			$this->data['facebook_user']=is_facebook_user();
			


		} catch (Exception $e) {
			$this->session->set_flashdata('error','Donnee not logged in');
			redirect('donee');			
		}
	}

	public function index($offset=0)
	{
		$per_page=25;
		$param=array('c.id >'=>'0','c.user_id'=>$this->data['donee_id']);

		$total_rows=count($this->campaign_m->filter_rows_by($param));
		$this->data['campaigns']=$this->campaign_m->filter_rows_by($param,$per_page,$offset);

		if($total_rows>$per_page){
			$this->load->library('pagination');
			$config['base_url']=base_url().self::MODULE."dashboard/index";
			$config['total_rows']=$total_rows;
			$config['per_page']=$per_page;
			$config['prev']='Previous';
			$config['next']='Next';
			$config['uri_segment']='4';
			$this->pagination->initialize($config);
			$this->data['pages']=$this->pagination->create_links();
		}
		$this->data['total']=$total_rows;
		$this->data['offset']=$offset;
		$this->data['subview']=self::MODULE.'dashboard/campaign/list';
		$this->breadcrumb->append_crumb('My Campaigns',base_url().self::MODULE.'index');
		$this->load->view('donee/main_layout',$this->data);
	}

	function campaign($slug=FALSE)
	{
		try {
			// if(!permission_permit(array('list-campaign','edit-campaign'))) $this->controller_redirect('Permissioin Denied');
			if(!$slug) throw new Exception("Error Processing Request", 1);
			$response=$this->get_data(array('slug'=>$slug));
			if(!$response['success']) throw new Exception($response['data'], 1);
			$this->data['campaign']=$response['data'];
			$id=$response['data']['id'];

			if($this->input->post())
			{
				$rules=null;
				if($this->input->post('add_content')){
					$rules=$this->campaign_m->get_rules(array('categories'));
					$description=array(
						'field'=>'description',
						'label'=>'Description',
						'rules'=>"trim|required|xss_clean",
						);
					array_push($rules,$description);
					$name_rule=array(
						'field'=>'campaign_title',
						'label'=>'Campaign Title',
						'rules'=>"trim|required|xss_clean|route|is_campaign_title_unique[$id]",
						);
					array_push($rules,$name_rule);
					$this->data['update_data']=array(
						'campaign_title'=>$this->input->post('campaign_title'),
						'description'=>$this->input->post('description'),
						'fund_category_id'=>$this->input->post('categories'),
						'updated_at'=>date('Y-m-d H:i:s'),
						);
					$tab='tab-1';
					$this->session->set_userdata('tab',$tab);
					// show_pre($rules);
				}
				else if($this->input->post('add_amount')){
					$rules=$this->campaign_m->get_rules(array('target_amount','starting_at','ending_at'));
					$this->data['update_data']=array(
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
						$response=campaign_photos_upload($this->data['campaign']);
						if(!$response['success']) throw new Exception($response['error'], 1);
						$this->data['update_data']['pic']=$response['data'];						
					}
					else
						$this->data['update_data']['pic']=$this->data['campaign']['pic'];
					$tab='tab-3';
					$this->session->set_userdata('tab',$tab);
					$this->campaign_m->update_row($id,$this->data['update_data']);
					$this->session->set_flashdata('success', 'category updated successfully');
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
					$this->data['update_data']=array(
						'url_link'=>"/".get_slug($this->input->post('url_link')),
						'updated_at'=>date('Y-m-d H:i:s'),
						);
					$tab='tab-4';
					$this->session->set_userdata('tab',$tab);
				}
				// die('here');
				$this->form_validation->set_rules($rules);
				if($this->form_validation->run($this)===TRUE)
				{
					$this->campaign_m->update_row($id,$this->data['update_data']);
					$this->session->set_flashdata('success', 'campaign updated successfully');
					show_pre($this->data['update_data']);
					redirect(current_url());
				}
			}	
			$this->data['subview']=self::MODULE.'dashboard/campaign/edit';
			$this->breadcrumb->append_crumb('My Campaigns',base_url().self::MODULE.'index');
			$this->breadcrumb->append_crumb('Edit Campaign','edit');
			$this->load->view('donee/main_layout',$this->data);
		} catch (Exception $e) {
			$this->session->set_flashdata('error', 'Couldnt edit campaign, '.$e->getMessage());
			redirect('donee/dashboard');
		}
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

		$donee_id=$this->data['donee_id'];
		$campaign_id=$response['data']['id'];

		if(is_campaign_own($donee_id,$campaign_id,base_url('donee/dashboard')))
			return $response;
		else{
			$this->session->set_flashdata('error', 'Couldnt edit campaign, invalid request');
			redirect('donee/dashboard');
		}
	}

	function add_campaign()
	{
		try {
			// if(!permission_permit(array('list-campaign','add-campaign'))) throw new Exception("Permissioin Denied", 1);
			if($this->input->post())
			{

				$rules=$this->campaign_m->get_rules();
				//change about fund raiser label to Description
				$rules[1]['label']='Description';
				unset($rules[2]);//reset donee validation
				foreach ($rules as $k=>$rule) {
					if($rule['field']=='url_link')
						unset($rules[$k]);
				}

				$this->data['insert_data']=array(
					'campaign_title'=>$this->input->post('campaign_title'),
					'slug'=>get_slug($this->input->post('campaign_title')),
					'description'=>$this->input->post('description'),
					'fund_category_id'=>$this->input->post('categories'),
					'user_id'=>$this->data['donee_id'],
					'target_amount'=>$this->input->post('target_amount'),
					'starting_at'=>date('Y-m-d',strtotime($this->input->post('starting_at'))),
					'ending_at'=>date('Y-m-d',strtotime($this->input->post('ending_at'))),
					'url_link'=>"/".get_slug($this->input->post('url_link')),
					'created_at'=>date('Y-m-d H:i:s'),
					'status'=>campaign_m::ACTIVE,
					);
				$this->form_validation->set_rules($rules);				
				if($this->form_validation->run($this)===TRUE)
				{
					if($_FILES && $_FILES['photos']['name'][0]!=''){
						$response=campaign_photos_upload();
						if(!$response['success']) throw new Exception($response['error'], 1);
						$this->data['insert_data']['pic']=$response['data'];						
					}
					// show_pre($this->data['insert_data']);
					$this->campaign_m->create_row($this->data['insert_data']);
					$this->session->set_flashdata('success', 'campaign created successfully');
					redirect('donee/dashboard');
				}
			} 
			
			$this->data['subview']=self::MODULE.'dashboard/campaign/add';
			$this->breadcrumb->append_crumb('My Campaigns',base_url().self::MODULE.'index');
			$this->breadcrumb->append_crumb('Create New Campaign','add');
			$this->load->view('donee/main_layout',$this->data);

		}catch (Exception $e) {
			$this->session->set_flashdata('error', 'Couldnt create campaign, '.$e->getMessage());
			redirect(current_url());
		}
	}

	public function remove_picture($slug,$pic=null){
		try {
			if(!$slug || !$pic) throw new Exception("Error Processing Request", 1);

			$response=$this->get_data(array('slug'=>$slug));
			if(!$response['success']) throw new Exception($response['data'], 1);			
			$id=$response['data']['id'];

			$remove_picture_response=campaign_photo_remove($response['data']['id'],$pic);

			if(!$remove_picture_response['success']) throw new Exception($remove_picture_response['error'], 1);			
			$this->data['update_data']['pic']=$remove_picture_response['data'];
			$this->session->set_flashdata('success','Category updated, picture has been removed successfully.');
			$this->campaign_m->update_row($id,$this->data['update_data']);
		} catch (Exception $e) {
			$this->session->set_flashdata('error', 'Couldnt remove picture '.$e->getMessage());
		}
		$this->session->set_userdata('tab','tab-3');
		redirect("donee/dashboard/campaign/$slug");
	}



	function controller_redirect($msg=false){
		if($msg) $this->session->set_flashdata('error', $msg);
		$this->data['link']=base_url().self::MODULE;
		redirect($this->data['link']);				
	}

	function profile(){
		try {
			if($this->data['facebook_user']) {
				$this->session->set_flashdata('error', 'Error Processing Request');
				redirect('donee/dashboard');
			}			
			$this->load->model('user/user_m');
			$this->data['user']=$this->user_m->read_row($this->session->userdata('donee_id'));	
			$username=$this->data['user']['username'];		
			if(!$this->data['user']) throw new Exception("Couldnt load user", 1);
			if($this->input->post())
			{			
				$rules=array(
					array(
						'field'=>'first_name',
						'label'=>'First Name',
						'rules'=>'trim|required|alpha|xss_clean'
						),
					array(
						'field'=>'last_name',
						'label'=>'Last Name',
						'rules'=>'trim|required|alpha|xss_clean'
						),
					);
				
				if(!$this->data['facebook_user']){
					if($this->data['user']['email']!=$this->input->post('email')){
						$email=array(
							'field'=>'email',
							'label'=>'Email Address',
							'rules'=>'trim|required|valid_email|is_unique[tbl_users.email]|xss_clean'
							);
						array_push($rules,$email);
					}					
				}

				$this->form_validation->set_rules($rules);
				if($this->form_validation->run($this)===TRUE)
				{
					$this->data['update_data']=array(
						'first_name'=>$this->input->post('first_name'),
						'last_name'=>$this->input->post('last_name'),
						'updated_at'=>date('Y-m-d H:i:s'),
						);

					if(!$this->data['facebook_user']){
						if($this->data['user']['email']!=$this->input->post('email')){
							$this->data['update_data']['email']=$this->input->post('email');
						}
					}

					$updated=null;
					$updated=$this->user_m->update_row($this->session->userdata('donee_id'),$this->data['update_data']);
					if($updated){
						$this->session->set_flashdata('success', 'Profile Updated');													
					}
					$this->session->set_flashdata('success', 'Profile Updated');													
					redirect(current_url());
				}
			}
			$this->data['subview']=self::MODULE.'/dashboard/profile/index';
			$this->breadcrumb->append_crumb('My Profile',base_url().self::MODULE.'index');
			$this->load->view('donee/main_layout',$this->data);		
		} catch (Exception $e) {
			$this->session->set_flashdata('error', 'Couldnt Change,'.$e->getMessage());
			// echo $e->getMessage();
			redirect(current_url());
		}
	}
	function change_password(){
		try {

			if($this->data['facebook_user']) {
				$this->session->set_flashdata('error', 'Error Processing Request');
				redirect('donee/dashboard');
			}			

			if(!$this->session->userdata('donee_id')) throw new Exception("Error Processing Request", 1);
			$this->load->model('user/user_m');
			$this->data['user']=$this->user_m->read_row($this->session->userdata('donee_id'));	
			if(!$this->data['user']) throw new Exception("Couldnt load user", 1);
			if($this->input->post())
			{			
				$id=$this->session->userdata('donee_id');
				$rules=array(
					array(
						'field'=>'old_password',
						'label'=>'Old Password',
						'rules'=>"trim|required|min_length[6]|check_old_password[$id]|xss_clean"
						),
					array(
						'field'=>'new_password',
						'label'=>'New Password',
						'rules'=>'trim|required|min_length[6]|matches[confirm_password]|xss_clean'
						),
					array(
						'field'=>'confirm_password',
						'label'=>'Confirm Password',
						'rules'=>'trim|required|min_length[6]|xss_clean'
						),
					);
				$this->form_validation->set_rules($rules);
				if($this->form_validation->run($this)===TRUE)
				{
					$this->data['update_data']=array(
						'pass'=>sha1($this->input->post('new_password'))
						);
					$updated=null;
					$updated=$this->user_m->update_row($this->session->userdata('donee_id'),$this->data['update_data']);
					if($updated){
					}
					$this->session->set_flashdata('success', 'Password changed');
					redirect(current_url());
				}
			}
			$this->data['subview']=self::MODULE.'/dashboard/profile/change_password';
			$this->breadcrumb->append_crumb('Change Password',base_url().self::MODULE.'index');
			$this->load->view('donee/main_layout',$this->data);		
		} catch (Exception $e) {
			$this->session->set_flashdata('error', 'Couldnt Change password,'.$e->getMessage());
			redirect(current_url());
		}
	}


	function donations($offset=0)
	{
		try {

			$per_page=25;
			$this->data['q_param']=array('tbl_donation.id >'=>'0');	
			$this->data['q_param']['join']['user_id']=$this->data['donee_id'];
			
			$total_rows=count($this->donation_m->read_rows_by($this->data['q_param']));
			$this->data['donations']=$this->donation_m->read_rows_by($this->data['q_param'],$per_page,$offset);

			if($total_rows>$per_page){
				$this->load->library('pagination');
				$config['base_url']=base_url().self::MODULE."dashboard/donations";
				$config['total_rows']=$total_rows;
				$config['per_page']=$per_page;
				$config['uri_segment']=4;
				$this->pagination->initialize($config);
				$this->data['pages']=$this->pagination->create_links();
			}
			$this->data['total']=$total_rows;
			$this->data['offset']=$offset;
			$this->data['subview']=self::MODULE.'dashboard/donation/index';
			$this->breadcrumb->append_crumb('Donations',' ');
			$this->load->view('donee/main_layout',$this->data);
		} catch (Exception $e) {
			$this->session->set_flashdata('error', 'Couldnt list donation, '.$e->getMessage());
			$this->controller_redirect();
		}
	}

	function bank_details(){
		try {

			// if($this->data['facebook_user']) {
			// 	$this->session->set_flashdata('error', 'Error Processing Request');
			// 	redirect('donee/dashboard');
			// }			

			$this->data['user']=$this->user_m->read_row($this->session->userdata('donee_id'));	
			if(!$this->data['user']) throw new Exception("Couldnt load user", 1);

			if($this->input->post())
			{			
				$rules=$this->bank_details_m->get_rules();
				$this->form_validation->set_rules($rules);
				if($this->form_validation->run($this)===TRUE)
				{

					$this->data['update_bank_data']=array(
						'bsb'=>$this->input->post('bsb'),
						'bank_name'=>$this->input->post('bank'),
						'acc_no'=>$this->input->post('account_number'),
						'acc_holder_name'=>$this->input->post('account_holder_name'),
						);
					$this->bank_details_m->update_row($this->input->post('bank_id'),$this->data['update_bank_data']);
					$this->session->set_flashdata('success', 'Bank Details Updated');													
					redirect(current_url());
				}
			}
			$this->data['subview']=self::MODULE.'/dashboard/bank_details';
			$this->data['bank_details']=get_bank_details(array('user_id'=>$this->data['user']['id']));
			// show_pre($this->data['bank_details']);
			$this->breadcrumb->append_crumb('My Bank Details',base_url().self::MODULE.'index');
			$this->load->view('donee/main_layout',$this->data);		
		} catch (Exception $e) {
			$this->session->set_flashdata('error', 'Couldnt Change Bank Details,'.$e->getMessage());
			redirect(current_url());
		}
	}

}
/* End of file sample.php */
/* Location: ./application/modules/sample/controllers/sample.php */