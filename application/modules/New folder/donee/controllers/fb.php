<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class fb extends Frontend_Controller {

	public $data;
	const MODULE='donee/';	

	function __construct()
	{
		try {
			parent::__construct();
			//session handling rax
			$fb_user=get_session('fb_user');

			if($fb_user){								
				$this->load->model('group/group_m');
				$this->load->model('user/user_m');
				$param=array(
					'facebook_id'=>$fb_user['id'],
					);
				$already_registered=$this->user_m->read_rows_by($param);
				
				// show_pre($already_registered);
				// die;
				if(count($already_registered)==0){
					//register fb user
					$group=get_group_by(array('key'=>'slug','value'=>group_m::FACEBOOK_USER));
					$new_user=array(
						'facebook_id'=>$fb_user['id'],
						'group_id'=>$group['id'],
						'username'=>$fb_user['name'],
						'first_name'=>$fb_user['first_name'],
						'last_name'=>$fb_user['last_name'],
						'email'=>$fb_user['email'],
						'status'=>user_m::ACTIVE,
						'created_at'=>date('Y-m-d H:i:s'),
						);
					$this->user_m->create_row($new_user);
					$user=$this->user_m->read_row_by(array('key'=>'facebook_id','value'=>$new_user['facebook_id']));
					$this->session->set_userdata('donee_id',$user['id']);
				}
				else if(count($already_registered)==1){
					throw new Exception("Already registered, please sign in with your facebook account.", 1);
				}
			}
		} catch (Exception $e) {
			$this->session->set_flashdata('error', $e->getMessage());
			// echo $e->getMessage();	
			redirect('');
		}
		redirect('donee/dashboard');
	}

	function signin(){

	}

}


/* End of file sample.php */
/* Location: ./application/modules/sample/controllers/sample.php */