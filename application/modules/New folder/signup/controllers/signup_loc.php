<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

use Facebook\FacebookSession;
use Facebook\FacebookRedirectLoginHelper;
// add other classes you plan to use, e.g.:
use Facebook\FacebookRequest;
use Facebook\GraphUser;
use Facebook\FacebookRequestException;


class signup extends Frontend_Controller {

	public $data;
	const MODULE='signup/';

	public function __construct()
	{
		parent::__construct();

		$this->data['link']=base_url().self::MODULE;
		$this->load->library('facebook');
		$this->load->model(array('signup_m','user/user_m','campaign/campaign_m','fund_category/fund_category_m'));
		$this->load->helper(array('group/group'));
		$this->data['categories']=$this->fund_category_m->read_all_published();

	}

	public function index()
	{
		try {
			if($this->input->post())
			{			
				$rules=$this->signup_m->set_rules();
				$icon=array(
					'field'=>'description',
					'label'=>'Description',
					'rules'=>'trim|required|xss_clean',
					);

				$this->form_validation->set_rules($rules);
				if($this->form_validation->run($this)===TRUE)
				{
					$this->load->model('group/group_m');
					$param['slug'] = group_m::DONEE;
					$group=get_group($param);

					$this->data['donee']=array(
						'group_id'=>$group['id'],
						'username'=>$this->input->post('username'),
						'first_name'=>$this->input->post('first_name'),
						'last_name'=>$this->input->post('last_name'),
						'email'=>$this->input->post('email'),
						'pass'=>sha1($this->input->post('password')),
						'verification_code'=>md5(date('Y-m-d H:m:s')),
						'status'=>user_m::PENDING,
						'created_at'=>date('Y-m-d H:i:s'),
						);
					$this->session->set_userdata('donee',$this->data['donee']);
					redirect('signup/campaign');
				}
			}
			$this->data['subview']=self::MODULE.'sign_up';
			$this->load->view('front/main_layout',$this->data);		

		} catch (Exception $e) {
			$this->session->set_flashdata('error', 'Couldnt Signup '.$e->getMessage());
			redirect(current_url());
		}
	}

	public function campaign()
	{
		try {
			if(!get_session('donee')) {
				$this->session->set_flashdata('error', 'Error Processing Request');
				redirect('signup');
			}
			if($this->input->post()){
				$this->load->model('campaign/campaign_m');
				$rules=$this->campaign_m->get_rules();
				//unset donee and url link
				unset($rules[2]);
				unset($rules[7]);

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
					$this->data['campaign']=array(
						'campaign_title'=>$this->input->post('campaign_title'),
						'slug'=>get_slug($this->input->post('campaign_title')),
						'fund_category_id'=>$this->input->post('categories'),
						'description'=>$this->input->post('description'),
						'target_amount'=>$this->input->post('target_amount'),
						'status'=>1,
						'created_at'=>date('Y-m-d H:i:s'),
						'starting_at'=>date('Y-m-d',strtotime($this->input->post('starting_at'))),
						'ending_at'=>date('Y-m-d',strtotime($this->input->post('ending_at'))),
						);
//save to session
					$this->session->set_userdata('campaign',$this->data['campaign']);
//bank details
					$this->data['user_address']=array(
						'address_unit'=>$this->input->post('address_unit'),
						'address_street'=>$this->input->post('address_street'),
						'address_suburb'=>$this->input->post('address_suburb'),
						'address_state_id'=>$this->input->post('address_state_id')
						);
					$donee=array_merge(get_session('donee'),$this->data['user_address']);
					$this->session->unset_userdata('donee');
					$this->session->set_userdata('donee',$donee);
					redirect('signup/personal_details');
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


	public function personal_details()
	{

		try {
// start transaction					
			// show_pre($this->session->all_userdata());
			$this->db->trans_begin();

			$this->data['donee']=get_session('donee');
			$campaign=get_session('campaign');
			$session_campaign=get_session('campaign');
			if(!$this->data['donee'] or !$campaign) {
				$this->session->set_flashdata('error', 'Error Processing Request');
				// die('Error Processing Request');
				redirect('signup');
			}			

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
					$this->data['campaign']=array(
						'video'=>$this->input->post('video'),
						'document'=>$this->input->post('document')?$this->input->post('document'):null,
						);
//upload document
					if($_FILES['document']['name']){
						$this->data['campaign']['document']=$_FILES['document']['name'];
						$path='uploads/files/documents/campaign/';
						upload_file($path,'document');
					}

//upload pics
					$upload=$uploaded=false;
					if($_FILES['photos']['name'][0]!=''){
						$uploaded=$this->upload_pics('@');
					}

					if(!$upload or $uploaded){
						if($this->send_mail('@')){

//insert donee
							$this->user_m->create_row(get_session('donee'));

//insert campaign
							$campaign=array_merge(get_session('campaign'),$this->data['campaign']);
							$donee_session=get_session('donee');
							if(!$donee_session) throw new Exception("Couldnt load donee from session", 1);
							
							$donee=$this->user_m->read_row_by_n(array('username'=>$donee_session['username']));
							
							if(!$donee) throw new Exception("Couldnt load donee from database", 1);
							$campaign['user_id']=$donee['id'];	
							$this->campaign_m->create_row($campaign);

//insert bank details
							$this->load->model('signup/bank_details_m');
							$campaign_db=$this->campaign_m->read_rows_by(array('slug'=>$session_campaign['slug']),1);	
							if(!$campaign_db) throw new Exception("Couldnt load campaign from database", 1);
							$this->data['bank_details']=array(
//'bank_name'=>$this->input->post('bank_name')?$this->input->post('bank_name'):null,
								'campaign_id'=>$campaign_db['id'],
								'user_id'=>$donee['id'],
								'acc_no'=>$this->input->post('acc_no')?$this->input->post('acc_no'):null,
								'acc_holder_name'=>$this->input->post('acc_holder_name')?$this->input->post('acc_holder_name'):null,
								'created_at'=>date('Y-m-d H:i:s')
								);
							$this->bank_details_m->create_row($this->data['bank_details']);

//transaction complete
							if ($this->db->trans_status() === FALSE)
							{
								$this->db->trans_rollback();
//remove document if any
								if($_FILES['document']['name'] && $_FILES['document']['name']!=''){
									if(file_exists( $file = campaign_m::full_path.$_FILES['document']['name']) ){
										unlink($file); 			
									}
								}
//remove pics if any
								if(isset($this->data['uploaded'])){
									foreach ($this->data['uploaded'] as $pic) {
										if(file_exists( $file = campaign_m::full_path.$pic) ){
											unlink($file); 			
										}
									}
								}
							}
							else
							{
								$this->db->trans_commit();
								$this->session->unset_userdata('donee');
								$this->session->unset_userdata('campaign');
								$this->session->set_flashdata('success', 'Signup suuccessfully, Please login to your email id and confirm your confirmation');
							}
							redirect();
						}
					}					
				}
			}
			$this->data['subview']=self::MODULE.'personal_details';
			$this->load->view('front/main_layout',$this->data);		
		} catch (Exception $e) {
			$this->session->set_flashdata('error', 'Couldnt not signup, '.$e->getMessage());
			echo $e->getMessage();
			die;
			$this->db->trans_rollback();
//remove document if any
			if($_FILES['document']['name'] && $_FILES['document']['name']!=''){
				if(file_exists( $file = campaign_m::full_path.$_FILES['document']['name']) ){
					unlink($file); 			
				}
			}

//remove pics if any
			if(isset($this->data['uploaded'])){
				foreach ($this->data['uploaded'] as $pic) {
					if(file_exists( $file = campaign_m::full_path.$pic) ){
						unlink($file); 			
					}
				}
			}
			redirect(current_url());
		}
	}

	private function upload_pics($param='$'){
		try {
			if($param!='@') return false;
			$config = array(
				'upload_path'   => 'uploads/files/pics/campaign/',
				'allowed_types' => 'jpg|jpeg|gif|png',
				'overwrite'     => 1,                       
				);
			$this->load->library('upload', $config);
			$this->upload->initialize($config);
			foreach ($_FILES['photos']['name'] as $key => $value) {
				if(!$this->upload->do_my_upload('photos', $key))
					$this->data['error']=$this->upload->display_errors();
				else
					$this->data['success'][] = array('upload_data' => $this->upload->data());
			}
//$this->data['success']= array('1.jpg','2.jpg');
			if(isset($this->data['success'])){
				foreach ($this->data['success'] as $value) {
					$this->data['uploaded'][]=$value['upload_data']['file_name'];
				}
				$serialze=serialize($this->data['uploaded']);
				$this->data['campaign']['pic']=$serialze;						
				$campaign=array_merge(get_session('campaign'),$this->data['campaign']);
				$this->session->set_userdata('campaign',$campaign);
				return true;				
			}
			return false;
		} catch (Exception $e) {
			return false;	
		}
	}

	private function send_mail($param='$'){
		try {
			if($param!='@') return false;
			// die("inside send_mail");
			/*
			$config = Array(
				'smtp_host' => $this->config->item('smtp_host'),
				'smtp_port' => $this->config->item('smtp_port'),
				'smtp_user' => $this->config->item('smtp_user'), 
				'smtp_pass' => $this->config->item('smtp_pass'), 
				'mailtype' => 'html',
				'wordwrap' => TRUE
				);
			*/	
			$config = Array(
					'protocol' => 'smtp',
					'smtp_host' => 'ssl://smtp.googlemail.com',
					'smtp_port' => 465,
					'smtp_user' => 'celosiadesigns4u@gmail.com', 
					'smtp_pass' => 'setedeep', 
					'mailtype' => 'html',
					'charset' => 'iso-8859-1',
					'wordwrap' => TRUE
					);
			$this->load->library('email', $config);
			$this->email->from('celosiadesigns4u@gmail.com','Our Library'); 
			$this->email->to($this->input->post('email'),'raxizel@gmail.com');

			$this->email->subject('Our library Account Confirmation');
			$message = '';
			$message= "We're ready to activate your account. All we need to do is make sure this is your email address.";	
			$message.="<br/>";
			$user=get_session('donee');
			$key=$user['verification_code'];


			$donee=get_session('donee');
			if(!$donee) 
				throw new Exception("no donee", 1);				
			$url=base_url("signup/activate/$key/".$donee['username']);

			$message.=anchor($url, 'Click here to confirm', '');			
			$this->email->message($message);
			return true;

			// die('just to send email');

			
/*
			$to="raxizel@gmail.com,".$this->input->post('email');
			$headers = "MIME-Version: 1.0" . "\r\n";
			$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
			$headers .= 'From: <webmaster@ourlibrary.com>' . "\r\n";
			if(mail($to,"Confirmation Link",$message))
				return true;
			return false;
*/			
			/*
			if(ENVIRONMENT=='production' or ENVIRONMENT=='testing' or ENVIRONMENT=='development'){
				// die("in");
				if($this->email->send())
				{
					echo 'Email sent.';
					return true;
				}
				else
					throw new Exception("no email send".$this->email->print_debugger(), 1);					
			}
			elseif(ENVIRONMENT=='development')
				return true;
			*/
			return false;

		} catch (Exception $e) {
			return false;
		}

	}

	public function activate($token=null,$username=null)
	{
		try {
			if(!$token)
				throw new Exception("no token", 1);
			if(!$username)
				throw new Exception("no username", 1);
			$this->load->model('user/user_m');

			
			$param=array('verification_code'=>$token);
			$user=$this->user_m->read_row_by_n($param);

// echo count($user);
// show_pre($user);
// die;

			if(!$user)
				throw new Exception("no user", 1);
			if($user['username']!=$username)
				throw new Exception("invalid user for the token", 1);
			if($user['status']==user_m::ACTIVE)
				throw new Exception("Already activated", 1);
			$data=array(
				'status'=>user_m::ACTIVE,
				);
			$this->user_m->update_row($user['id'],$data);
			$this->session->set_userdata('donee_id',$user['id']);
			$this->session->set_flashdata('success', 'Your account has been verified, Welcome to our library');
			redirect('donee');
		} catch (Exception $e) {
			$this->session->set_flashdata('error', $e->getMessage());
			echo $e->getMessage();
//redirect();
		}
	}

	public function destroy(){
		$this->session->unset_userdata('donee');
		$this->session->unset_userdata('campaign');
	}

// http://localhost/cel/2015/may/projects/donatenow/signup/fb/53edd6990376d7b5f512d2b5556613ca2567f04c

	function fb($param='$'){
		try {
			if($param!='53edd6990376d7b5f512d2b5556613ca2567f04c') throw new Exception("Error Processing Request", 1);
// init app with app id (APPID) and secret (SECRET)
			FacebookSession::setDefaultApplication($this->config->item('APPID'), $this->config->item('SECRET'));
// login helper with redirect_uri
			$helper = new FacebookRedirectLoginHelper(base_url('donee/fb'));
			$session = $helper->getSessionFromRedirect();
			if ( isset( $session ) ) {
// graph api request for user data
				$request = new FacebookRequest( $session, 'GET', '/me' );
				$response = $request->execute();
// get response
				$fb_user = $response->getGraphObject()->asArray();
				$this->session->set_userdata('fb_user',$fb_user);
				show_pre(get_session('fb_user'));
				echo $this->data['url'] = 'donee/fb';
				die;
			} else {
				$this->data['url'] = $helper->getLoginUrl();
			}
		} 
		catch( FacebookRequestException $ex ) {
		} catch (Exception $e) {
			$this->session->set_flashdata('error', $e->getMessage());			
		}
		echo $this->data['url'];
		redirect($this->data['url']);
	}


	public function controller_redirect($msg=false){
		if($msg) $this->session->set_flashdata('error', $msg);
		$this->data['link']=base_url().self::MODULE;
		redirect($this->data['link']);				
	}

	public function all_destroy(){
		show_pre($this->session->all_userdata());
		$this->session->sess_destroy();
		show_pre($this->session->all_userdata());
	}

}

/* End of file sample.php */
/* Location: ./application/modules/sample/controllers/sample.php */