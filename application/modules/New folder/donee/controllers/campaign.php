<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class campaign extends Frontend_Controller {

	public $data;
	const MODULE='donee/';

	function __construct()
	{
		parent::__construct();
		$this->data['link']=base_url().self::MODULE;
		$this->load->model('campaign/campaign_m');
		$this->load->model('fund_category/fund_category_m');
		$this->load->model('signup/signup_m');

		$this->data['categories']=$this->fund_category_m->read_all_published();
		$this->data['donee']=$this->signup_m->read_row($this->session->userdata('signup_user_id'));
	}

	public function index()
	{
		try {
			if($this->input->post()){
				$rules=$this->campaign_m->set_rules();
				$new_rules=array(
					array(
						'field'=>'address_unit',
						'label'=>'Unit/Apartment',
						'rules'=>'trim|xss_clean'
						),
					array(
						'field'=>'address_street',
						'label'=>'Street',
						'rules'=>'trim|xss_clean'
						),
					array(
						'field'=>'address_suburb',
						'label'=>'Suburb',
						'rules'=>'trim|xss_clean'
						),
					array(
						'field'=>'state',
						'label'=>'State',
						'rules'=>'trim|xss_clean'
						),
					array(
						'field'=>'postcode',
						'label'=>'Postcode',
						'rules'=>'trim|xss_clean'
						),
					);
				foreach ($new_rules as $rule) {
					array_push($rules, $rule);
				}
				$this->form_validation->set_rules($rules);
				if($this->form_validation->run($this)===TRUE)
				{
					$this->data['insert_data']=array(
						'user_id'=>$this->session->userdata('signup_user_id'),
						'campaign_title'=>$this->input->post('campaign_title'),
						'fund_category_id'=>$this->input->post('categories'),
						'description'=>$this->input->post('description'),
						'target_amount'=>$this->input->post('target_amount'),
						'status'=>1,
						'created_at'=>date('Y-m-d H:i:s')
					);
					$this->campaign_m->create_row($this->data['insert_data']);
					$param['key']='campaign_title';
					$param['value']=$this->input->post('campaign_title');
					$this->data['campaign']=$this->campaign_m->read_row_by($param);
					//store campaign id
					$this->session->set_userdata('current_campaign_id',$this->data['campaign']['id']);
					$this->load->model('signup/signup_m');
					$this->data['insert_data']=array(
						'address_unit'=>$this->input->post('address_unit'),
						'address_street'=>$this->input->post('address_street'),
						'address_suburb'=>$this->input->post('address_suburb'),
						'address_state_id'=>$this->input->post('address_state_id')
						);
					$this->signup_m->update_row($this->session->userdata('signup_user_id'),$this->data['insert_data']);
					$this->session->set_flashdata('success', 'Campaign created successfully');
					redirect('campaign/personal_details');			
				}
			}
			$this->data['subview']=self::MODULE.'campaign';
			$this->load->view('front/main_layout',$this->data);		
		}
		catch (Exception $e) {
			$this->session->set_flashdata('error', 'Couldnt create campaign '.$e->getMessage());
			redirect(current_url());
		}
	}


	public function media($campaign_id)
	{
		try {
			$this->data['campaign']=$this->campaign_m->read_row($campaign_id);

			if($this->input->post()){
				// $this->form_validation->set_rules($rule);
				// if($this->form_validation->run($this)===TRUE)
				// {
				if($_FILES && $_FILES['photos']['name'][0]!=''){
					//multi and single upload
					$config = array(
						'upload_path'   => 'uploads/files/pics/campaign/',
						'allowed_types' => 'jpg|gif|png',
						'overwrite'     => 1,                       
						);
					$this->load->library('upload', $config);
					foreach ($_FILES['photos']['name'] as $key => $value) {
						$this->upload->initialize($config);
						if(!$this->upload->do_my_upload('photos', $key)){
							$this->data['error']=$this->upload->display_errors();
						}
						else{
							$this->data['success'][] = array('upload_data' => $this->upload->data());
						}
					}
					if($this->data['success']){
						foreach ($this->data['success'] as $value) {
							$this->data['uploaded'][]=$value['upload_data']['file_name'];
						}
						//merge two serialzed data
						$old_pics = unserialize($this->data['campaign']['pic']);
						$pics=array_merge($old_pics,$this->data['uploaded']);
						show_pre($pics);
						$serialze=serialize($pics);
						$this->data['insert_data']['pic']=$serialze;						
						$this->campaign_m->update_row($campaign_id,$this->data['insert_data']);
						$this->session->set_flashdata('success', 'Pictures updated successfully ');
						redirect(current_url());
					}
				}
			// }
			}
			$this->data['subview']=self::MODULE.'dashboard/media';
			$this->load->view('front/main_layout',$this->data);		
		} catch (Exception $e) {
			$this->session->set_flashdata('error', 'Couldnt add campaign '.$e->getMessage());
			redirect(current_url());
		}
	}

	public function remove_media($id,$pic=null){
		try {
			if(!$id || !$pic) throw new Exception("Error Processing Request", 1);
			$this->data['campaign']=$this->campaign_m->read_row($id);
			if(!$this->data['campaign']) throw new Exception("Couldnt load campaign", 1);
			if(file_exists( $file = campaign_m::full_path.$pic) ){
				if(!unlink($file)) 	throw new Exception("Unable to unlink", 1);		
				
				//save new serialize data
				$un_serialized_data = unserialize($this->data['campaign']['pic']);
				// show_pre($un_serialized_data);
				foreach($un_serialized_data as $key => $value){
					if ($value == $pic) {
						unset($un_serialized_data[$key]);
					}
				}
				$serialized_data = serialize($un_serialized_data);
				$data['pic']=$serialized_data;
				$this->campaign_m->update_row($id,$data);
				$this->session->set_flashdata('success', 'Picture has been removed successfully.');
			}
			else
				throw new Exception("No media found", 1);
		} catch (Exception $e) {
			$this->session->set_flashdata('error', 'Couldnt remove picture '.$e->getMessage());
		}
		redirect("donee/campaign/media/$id");			
	}

	public function personal_details()
	{
		try {
			if($this->input->post()){
				$rule=array(
					array(
						'field'=>'checkagree',
						'label'=>'i agree',
						'rules'=>'required'
						)
					);	
				$this->form_validation->set_rules($rule);
				if($this->form_validation->run($this)===TRUE)
				{
					$this->data['insert_data']=array(
						'video'=>$this->input->post('video'),
						'document'=>$this->input->post('document')?$this->input->post('document'):null,
						);
					$this->campaign_m->update_row($this->session->userdata('current_campaign_id'),$this->data['insert_data']);

					//multi and single upload
					$config = array(
						'upload_path'   => 'uploads/files/pics/campaign/',
						'allowed_types' => 'jpg|gif|png',
						'overwrite'     => 1,                       
						);
					$this->load->library('upload', $config);
					foreach ($_FILES['photos']['name'] as $key => $value) {
						$this->upload->initialize($config);
						if(!$this->upload->do_my_upload('photos', $key)){
							$this->data['error']=$this->upload->display_errors();
						}
						else{
							$this->data['success'][] = array('upload_data' => $this->upload->data());
						}
					}
					if($this->data['success']){
						foreach ($this->data['success'] as $value) {
							$this->data['uploaded'][]=$value['upload_data']['file_name'];
						}
						$serialze=serialize($this->data['uploaded']);
						show_pre($serialze);
						$this->data['insert_data']['pic']=$serialze;						
					}

					if($_FILES['document']['name']){
						$this->data['insert_data']['document']=$_FILES['document']['name'];
						$path='uploads/campaign';
						upload_file($path,'document');
					}
					$this->campaign_m->update_row_by_userid($this->session->userdata('signup_user_id'),$this->data['insert_data']);

					//send verfication code to his/her email
					$from['from_name'] = 'Our Library';
					$from['from_email'] =  'basant@gmail.com';
					$to['to_name'] = $this->data['donee']['first_name'].$this->data['donee']['last_name'];
					$to['to_email'] = $this->data['donee']['email'];
					$to['to_name'] = 'ram';
					$to['to_email'] = 'raxizel@gmail.com';					
					$subject = "Our library Account Confirmation";
					$message= "We're ready to activate your account. All we need to do is make sure this is your email address.";	
					$message.="<br/>";
					$key=md5(date('Y-m-d H:m:s'));
					$user_id=$this->session->userdata('signup_user_id');
					if(!$user_id) 
						throw new Exception("no signup_user_id", 1);				
					$url=base_url("signup/activate/$key/$user_id");
					$style="border-radius:3px;background:#3aa54c;color:#fff;display:block;font-weight:700;font-size:16px;line-height:1.25em;margin:24px auto 24px;padding:10px 18px;text-decoration:none;width:180px;text-align:center";
					// $message.=anchor($url, 'Click here to confirm', $style);
					$message.=anchor($url, 'Click here to confirm', '');
					// $res=1;
					$res = App\Mailer::sendMail($from, $to, $subject, $message);	
					if($res==1){
						$this->data['update_data']=array(
							'verification_code'=>$key
							);
						$this->signup_m->update_row($this->session->userdata('signup_user_id'),$this->data['update_data']);
						$this->session->set_flashdata('success', 'Signup suuccessfully, Please login to your email id and confirm your confirmation');
						$this->session->unset_userdata('signup_user_id');

						//insert bank details
						//validation left
						$this->load->model('signup/bank_details_m');
						$this->data['insert_data']=array(
							//'bank_name'=>$this->input->post('bank_name')?$this->input->post('bank_name'):null,
							'campaign_id'=>$this->session->userdata('current_campaign_id'),
							'acc_no'=>$this->input->post('acc_no')?$this->input->post('acc_no'):null,
							'acc_holder_name'=>$this->input->post('acc_holder_name')?$this->input->post('acc_holder_name'):null,
							'created_at'=>date('Y-m-d H:i:s')
							);
						$this->bank_details_m->create_row($this->data['insert_data']);

						redirect();
					}else{
						throw new Exception("no email send", 1);						
					}
				}
			}
			$this->data['subview']=self::MODULE.'personal_details';
			$this->load->view('front/main_layout',$this->data);		
		} catch (Exception $e) {
			$this->session->set_flashdata('error', 'Couldnt add campaign '.$e->getMessage());
			redirect(current_url());
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