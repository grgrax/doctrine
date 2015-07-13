<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class signup_ extends Frontend_Controller {

	public $data;
	const MODULE='signup/';

	function __construct()
	{
		parent::__construct();
		// $this->session->unset_userdata('signup_user_id');
		$this->data['link']=base_url().self::MODULE;
		$this->load->model('signup_m');
		$this->load->model('user/user_m');
	}

	public function index()
	{
		try {
			if($this->input->post())
			{			
				$rules=$this->signup_m->set_rules();
				$this->form_validation->set_rules($rules);
				if($this->form_validation->run($this)===TRUE)
				{
					$this->load->model('group/group_m');
					$param['key'] = 'slug';
					$param['value'] = group_m::DONEE;
					$group=$this->group_m->read_row_by($param);

					$this->data['insert_data']=array(
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
					$this->signup_m->create_row($this->data['insert_data']);
					$lastuser= $this->signup_m->read_row_by_name($this->input->post('username'));
					if(!$lastuser)
						throw new Exception("No user added", 1);						
					else
						$this->session->set_userdata('signup_user_id', $lastuser['id']);
					redirect('campaign');
				}
			}
			$this->data['subview']=self::MODULE.'sign_up';
			$this->load->view('front/main_layout',$this->data);		

		} catch (Exception $e) {
			$this->session->set_flashdata('error', 'Couldnt Signup '.$e->getMessage());
			redirect(current_url());
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
			$param['key']='verification_code';
			$param['value']=$token;
			$user=$this->user_m->read_row_by($param);
			echo count($user);
			show_pre($user);
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

	

	function controller_redirect($msg=false){
		if($msg) $this->session->set_flashdata('error', $msg);
		$this->data['link']=base_url().self::MODULE;
		redirect($this->data['link']);				
	}

}

/* End of file sample.php */
/* Location: ./application/modules/sample/controllers/sample.php */