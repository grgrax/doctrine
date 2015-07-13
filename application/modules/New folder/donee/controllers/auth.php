<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

use Facebook\FacebookSession;
use Facebook\FacebookRedirectLoginHelper;
// add other classes you plan to use, e.g.:
use Facebook\FacebookRequest;
use Facebook\GraphUser;
use Facebook\FacebookRequestException;

class auth extends Frontend_Controller {

	public $data;
	const MODULE='donee/';

	function __construct()
	{
		try {
			$this->load->model('user/user_m');
			parent::__construct();
		} catch (Exception $e) {
			
		}
	}

	public function index()
	{
		redirect('donee/auth/login');
	}

	function login(){
		try {

			if($this->session->userdata('donee_id'))
				redirect('donee/dashboard');
			else{
				if($this->input->post())
				{
					$rules=array(
						array(
							'field'=>'username',
							'rules'=>'trim|required|min_length[3]'
							),
						array(
							'field'=>'password',
							'rules'=>'trim|required|min_length[5]'
							)
						);	
					$this->form_validation->set_rules($rules);
					if($this->form_validation->run($this)===TRUE)
					{
						$username=$this->input->post('username',true);
						$pass=$this->input->post('password',true);

						$this->load->model('group/group_m');
						$group=$this->group_m->read_row_by_n(array('slug'=>group_m::DONEE));
						$user=$this->user_m->check_donee_login($username,$pass,$group['id']);
						show_pre($user);
						if($user)
						{
							$user_m=$this->user_m;
							switch ($user['status']) {
								case $user_m::PENDING:{
									throw new Exception("Pending user");
									break;
								}
								case $user_m::BLOCKED:{
									throw new Exception("Blocked user");
									break;
								}
								case $user_m::DELETED:{
									throw new Exception("Deleted user");
									break;
								}
							}
							$this->session->set_userdata('donee_id',$user['id']);
							redirect('donee/dashboard');
						}
						else
							throw new Exception("Invalid Username/Password");
					}
					else{
						throw new Exception(validation_errors());
					}
				}
				$this->load->view('login',$this->data);
			}
		} catch (Exception $e) {
			$this->session->set_flashdata('error', "Login Failed <hr/> ".$e->getMessage());
			redirect("donee/auth/login");			
		}
	}

	function logout(){
		try {
			if($this->session->userdata('donee_id')){
				$loggedin_user=$this->user_m->read_row($this->session->userdata('donee_id'));
				if($loggedin_user['facebook_id']){
					$this->session->set_flashdata('success', "Logout sucessfully");
					$this->data['url'] = '';	
				}else{
					echo $this->data['url'] = 'donee/auth/login';	
				}
				$this->session->unset_userdata('donee_id');
			}
		} catch (Exception $e) {
			$this->session->set_flashdata('error',$e->getMessage());			
		}
		// echo $this->data['url'];
		redirect($this->data['url']);
	}

	public function fb_login_($param='$')
	{
		try {
			if($param!='53edd6990376d7b5f512d2b5556613ca2567f04c') throw new Exception("Error Processing Request", 1);
			$fb = $this->facebook->getUser();
			if(!$fb){
				$this->data['url'] = $this->facebook->getLoginUrl(array(
					'redirect_uri' => base_url('donee'), 
					'scope' => array("email") 
					));
			} else {				
				$fb_user = $this->facebook->api('/me');
				$param=array(
					'facebook_id'=>$fb_user['id'],
					);
				//is registered facebook account with our site
				$this->load->model('user/user_m');
				$already_registered=$this->user_m->read_rows_by($param);
				// show_pre($already_registered);
				if(!$already_registered) throw new Exception("Your facebook account is not registered yet, please sign up with your facebook account.", 1);	
				$this->session->set_userdata('donee_id',$already_registered[0]['id']);			
				echo $this->data['url'] = 'donee/dashboard';	
				// die;			
			}
		} catch (Exception $e) {
			$this->session->set_flashdata('error', $e->getMessage());			
		}
		redirect($this->data['url']);
	}

	function fb_login($param='$'){
		try {
			if($param!='53edd6990376d7b5f512d2b5556613ca2567f04c') throw new Exception("Error Processing Request", 1);
			FacebookSession::setDefaultApplication($this->config->item('APPID'), $this->config->item('SECRET'));
			$helper = new FacebookRedirectLoginHelper(base_url("donee/auth/fb_login/53edd6990376d7b5f512d2b5556613ca2567f04c"));
			$session = $helper->getSessionFromRedirect();
			if ( isset( $session ) ) {
				$request = new FacebookRequest( $session, 'GET', '/me' );
				$response = $request->execute();
				$fb_user = $response->getGraphObject()->asArray();
				$param=array(
					'facebook_id'=>$fb_user['id'],
					);
				//is registered facebook account with our site
				$this->load->model('user/user_m');
				$already_registered=$this->user_m->read_rows_by($param);
				// show_pre($already_registered);
				if(!$already_registered) throw new Exception("Your facebook account is not registered yet, please sign up with your facebook account.", 1);	
				$this->session->set_userdata('donee_id',$already_registered[0]['id']);	
				echo $this->data['url'] = 'donee/auth/fb_signin';	
				// die;
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

	function fb_signin(){
		try {
			if($this->session->userdata('donee_id')){
				$this->data['url'] = 'donee/dashboard';	
			}
			else{
				$this->data['url'] ='';
				throw new Exception("Facebook account not found, please signup with your facebook account", 1);
			}			
		} catch (Exception $e) {
			$this->session->set_flashdata('error', $e->getMessage());						
		}
		echo $this->data['url'];
		redirect($this->data['url']);
	}
}	

/* End of file sample.php */
/* Location: ./application/modules/sample/controllers/sample.php */